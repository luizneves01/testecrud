# Teste BackEnd Luiz Felipe Tavares das Neves

A aplicação foi construida utilizando as seguintes tecnologias

* PHP 7.3
* Lumen 8.x
* Mysql 5.7

Para a aplicação funcionar localmente é necessário ter préviamente instalado os pacotes Docker e Docker-compose

Após clonar o repositório basta seguir os seguintes passos:

+ dentro da pasta raiz execute o comando "docker-compose up -d"
+ docker exec -it appcrud_web_1 bash
+ cd app
+ composer install
+ cp .env.example .env

Para a criação do banco de dados foi utilizado o padrão de migrations, para utiliza-los siga os passos abaixo:

+ php artisan migrate
+ php artisan db:seed

Após essas instruções o sistema estará diponível no link: [http://localhost:8000](http://localhost:8000)

Acessando esse link, deverá ser apresentado a frase "It is working!".

## Importante

Para acessar os métodos da integração, deve-se utilizar os seguintes dados para login:
* E-mail: admin@admin.com
* Password: admin

Cada método está explicado na documentação [http://localhost:8000/doc.html](http://localhost:8000/doc.html)