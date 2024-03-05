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

podman exec -it NOMEDOCONTAINER /opt/lampp/bin/mysql -u root -h 127.0.0.1
