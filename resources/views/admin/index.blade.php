<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/login.css')) }}"/>
    <!-- ALTERAR A FAVICON -->
    <link rel="icon" type="image/png" href="backend/assets/images/favicon.png"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OS Fácil - Login</title>
</head>
<body>

<div class="ajax_response"></div>

<div class="dash_login">
    <div class="dash_login_left">
        <article class="dash_login_left_box">
            <header class="dash_login_box_headline">
                <div class="dash_login_box_headline_logo icon-imob icon-notext"></div>
                <h1>Login</h1>
            </header>

            <form name="login" action="{{ route('admin.login.do') }}" method="post" autocomplete="off">

                <label>
                    <span class="field icon-envelope">E-mail:</span>
                    <input type="email" name="email" placeholder="Informe seu e-mail" required/>
                </label>

                <label>
                    <span class="field icon-unlock-alt">Senha:</span>
                    <input type="password" name="password_check" placeholder="Informe sua senha" required/>
                </label>

                <button class="gradient gradient-green radius icon-sign-in">Entrar</button>
            </form>

            <footer>
                <p>$desenvolvidoPor = alunos( <br>
                    'Andrew' => <a href="https://github.com/andrewwalmir">Github</a>'<br>
                    'Diego' => '<a href="https://github.com/Diegooliveira93">Github</a>'<br>
                    'Matielo' => '<a href="https://github.com/matielojg">Github</a>'<br>
                    );
                </p>
                <br>
                <p>&copy; <?= date("Y"); ?> - Todos os Direitos Reservados</p>
                <p class="dash_login_left_box_support">
                    <a target="_blank"
                       class="icon-whatsapp transition text-green"
                       href="https://api.whatsapp.com/send?phone=5545999016608&text=Olá, preciso de ajuda com o login."
                    >Precisa de Ajuda?</a>
                </p>
            </footer>
        </article>
    </div>

    <div class="dash_login_right"></div>

</div>

<script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
<script src="{{ url(mix('backend/assets/js/login.js')) }}"></script>

</body>
</html>