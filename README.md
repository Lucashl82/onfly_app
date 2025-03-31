Pré-requisitos:
Configure seu .env com as credenciais do banco de dados:

env
Copy
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

Utilizar o comando 

composer install para instalação de dependencias após isso criar as tabelas através de migrates

php artisan migrate

para confirmar que os fronts estão atualizados utilizaremos 

npm install

assim faremos download das dependencias de frontend

após isso utilizaremos 

npm run development

e por final 

php artisan serve

para iniciarmos o servidor php e utilizarmos a interface web.
