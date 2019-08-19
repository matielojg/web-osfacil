<a href="http://localhost/web-osfacil/public/admin/home"></a>

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<b>Passos para funcionar</b>
<hr>
<b> /** Quando clonar pela primeira vez, criar e configurar o arquivo .env */ </b>

<p> -> Criar base de dados </p>
<p> Rodar: </p>

    cp .env.example .env
 
-> Configurar o arquivo .env (nome e senha do BD + nome do banco que criou)
   
<hr>

<b> /** Para atualizar seu projeto local com o do git */ </b>

<p> Rodar: </p>

    git pull origin master
    composer install
    php artisan migrate
    php artisan key:generate
    npm install
    



