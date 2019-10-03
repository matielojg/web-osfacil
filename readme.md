<a href="http://localhost/web-osfacil/public/admin/home"></a>

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<b>Passos para funcionar</b>
<hr>
<b> /** Quando clonar pela primeira vez, criar e configurar o arquivo .env */ </b>
<br>
<p> -> Criar base de dados </p>
<p> Rodar: </p>

    cp .env.example .env
 
-> Configurar o arquivo .env (nome e senha do BD + nome do banco que criou)
   
<hr>

<b> /** Para atualizar seu projeto local com o do git */ </b>

<p> Rodar: </p>

    git pull origin master    (puxar atualizações do git remoto)
    composer install          (instalar as dependencias do composer)
    php artisan migrate       (rodar para migrar os arquivos do BD) 
    php artisan key:generate  (necessário para criptografia do laralel)
    npm install               (necessário instalar as dependencias do node)  
    
    
    composer dump-autoload    (para detectar alterações nos arq. JScript
    php artisan storage:link  (cria a pasta storage para armazenar as fotos)

  <hr>

<b> Para funcionar a foto do perfil, faça isso no arquivo .env </b>

    APP_URL=http://localhost/web-osfacil/public
    FILESYSTEM_DRIVER=public -> (abaixo de LOG_CHANNEL=stack)

<hr>
<b> Para instalar o pacote do cropper:

    composer require coffeecode/cropper

    
<p> https://packagist.org/packages/coffeecode/cropper </p>

<hr>
<b> Migrations: </b>
    
    php artisan make:migration create_users_table --create=users
    php artisan make:migration add_votes_to_users_table --table=users
