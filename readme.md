<a href="http://localhost/web-osfacil/public/admin/home"></a>

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<b>Passos para funcionar:</b>

-Quando clonar pela primeira vez, criar e configurar o arquivo .env
    cp .env.example .env

Configurações do arquivo .env:
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=osfacil
- DB_USERNAME=root
- DB_PASSWORD=
    
-Criar base de dados com o nome que deu no .env

<br>
<b>*Para atualizar seu projeto local com o do git:</b>
    <p>git pull origin master</p>
    
<b>-Rodar:</b>
   <p>composer update </p>
        ou
    composer install
    
-Rodar:
    php artisan migrate

-Rodar:
    php artisan key:generate



