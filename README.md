# Trabalho experiência criativa.

## Como rodar o projeto:

podman-compose up -d

## Popular o banco

podman exec -it NOMEDOCONTAINER /opt/lampp/bin/mysql -u root < script.sql

## Pasta para edição

./www

## Status atual para login

Banco estruturado sem hash, possui o banco "web" com tabela "users" com campos "id" (auto incremento), "email" (varchar), "senha" (varchar), "otp" (varchar, opcional por enquanto).

Para acesso do banco:

podman exec -it NOMEDOCONTAINER /opt/lampp/bin/mysql -u root -h 127.0.0.1 -p root

ou, via o PC local, sem conectar no container:

mysql -u root -h 127.0.0.1 --port=41063 -p root

Já no PHP:

usuário:root
senha:root
host:127.0.0.1
porta:3306

Isso obviamente é um problema *GRITANTE* e deve ser arrumado breve, com a
utilização de um banco de senhas ou algo similar.

## Informações de confirmação do banco

Campo "codconfirmacao":
    Campo para preenchimento com o código aleatório de 4 dígitos gerado pelo PHP. Deve ser utilizado na confirmação do e-mail.

Campo "confirmado":
    Campo para verificar se a conta foi confirmada ou não. Não permitir o login caso seja 0. Fazer a troca após a confirmação para 1.
