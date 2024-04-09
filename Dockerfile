ARG BASE_DEBIAN=buster
FROM docker.io/library/debian:${BASE_DEBIAN}
ARG XAMPP_URL
#LABEL maintainer="Tomas Jasek<tomsik68 (at) gmail (dot) com>"

ENV DEBIAN_FRONTEND noninteractive

# Set root password to root, format is 'user:password'.
RUN echo 'root:root' | chpasswd

RUN apt-get update --fix-missing && \
  apt-get upgrade -y && \
  # curl is needed to download the xampp installer, net-tools provides netstat command for xampp
  apt-get -y install curl net-tools && \
  apt-get -yq install openssh-server supervisor && \
  # Few handy utilities which are nice to have
  apt-get -y install nano vim less --no-install-recommends && \
  apt-get clean

RUN curl -Lo xampp-linux-installer.run $XAMPP_URL && \
  chmod +x xampp-linux-installer.run && \
  bash -c './xampp-linux-installer.run' && \
  ln -sf /opt/lampp/lampp /usr/bin/lampp && \
  # Enable XAMPP web interface(remove security checks)
  sed -i.bak s'/Require local/Require all granted/g' /opt/lampp/etc/extra/httpd-xampp.conf && \
  # Enable error display in php
  sed -i.bak s'/display_errors=Off/display_errors=On/g' /opt/lampp/etc/php.ini && \
  sed -i.bak s'/mysqli.default_socket=/mysqli.default_socket=\/opt\/lampp\/var\/mysql\/mysql.sock/g' /opt/lampp/etc/php.ini && \
  # Enable includes of several configuration files
  mkdir /opt/lampp/apache2/conf.d && \
  echo "IncludeOptional /opt/lampp/apache2/conf.d/*.conf" >> /opt/lampp/etc/httpd.conf && \
  # Create a /www folder and a symbolic link to it in /opt/lampp/htdocs. It'll be accessible via http://localhost:[port]/www/
  # This is convenient because it doesn't interfere with xampp, phpmyadmin or other tools in /opt/lampp/htdocs
  mkdir /www && \
  ln -s /www /opt/lampp/htdocs && \
  # SSH server
  mkdir -p /var/run/sshd && \
  # Allow root login via password
  sed -ri 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/g' /etc/ssh/sshd_config

COPY ./composer.json /www/
COPY ./index.html /www/
COPY ./paginas/ /www/paginas/
COPY ./css/ /www/css/
COPY ./js/ /www/js/
COPY ./php/ /www/php/

RUN cd /www/ && \
	ln -s /opt/lampp/bin/php /usr/local/bin/php && \
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
	php composer-setup.php && \
	php -r "unlink('composer-setup.php');" && \
	cp composer.phar /usr/local/bin/composer && \
	COMPOSER_ALLOW_SUPERUSER=1 composer install -n

# copy supervisor config file to start openssh-server
COPY supervisord-openssh-server.conf /etc/supervisor/conf.d/supervisord-openssh-server.conf

# copy a startup script
COPY startup.sh /startup.sh

VOLUME [ "/var/log/mysql/", "/var/log/apache2/", "/www", "/opt/lampp/apache2/conf.d/" ]

EXPOSE 3306
EXPOSE 22
EXPOSE 80

CMD ["sh", "/startup.sh"]
