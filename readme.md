<a href="http://localhost/web-osfacil/public/admin/home"></a>

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<b>Passos para funcionar</b>
<hr>
<b> /** Quando clonar pela primeira vez, criar e configurar o arquivo .env */ </b>

-> Criar base de dados

Rodar:
    <p>cp .env.example .env</p>
 
-> Configurar o arquivo .env (nome e senha do BD + nome do banco que criou)
<br>    
<hr>
<br>
/** Para atualizar seu projeto local com o do git */

    git pull origin master
    
Rodar:
    <p>composer install</p>
    <p>php artisan migrate</p>
    <p>php artisan key:generate</p>
    <p>npm install</p>
    



