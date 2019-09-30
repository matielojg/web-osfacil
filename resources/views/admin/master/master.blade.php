<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">

    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/libs.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/style.css')) }}"/>

    @hasSection('css')
        @yield('css')
    @endif

    <link rel="icon" type="image/png" href="backend/assets/images/favicon.png"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OS Fácil - Dashboard</title>
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<div class="ajax_response"></div>

@php
    if (\Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . \Illuminate\Support\Facades\Auth::user()->photo)){
        $photo = \Illuminate\Support\Facades\Auth::user()->url_photo;
    } else {
        $photo = url(asset('backend/assets/images/avatar.jpg'));
    }
@endphp

<div class="dash">
    <aside class="dash_sidebar">
        <article class="dash_sidebar_user">
            <img class="dash_sidebar_user_thumb" src="{{ $photo }}" alt="" title=""/>

            <h1 class="dash_sidebar_user_name">
                <a href="">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
            </h1>
        </article>

        <ul class="dash_sidebar_nav">
            <li class="dash_sidebar_nav_item {{ isActive('admin.home') }} ">
                <a class="icon-tachometer" href="{{ route('admin.home') }}">Dashboard</a>
            </li>
            <li class="dash_sidebar_nav_item {{ isActive('admin.users') }}"><a class="icon-users" href="{{ route('admin.users.index') }}">Usuários</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class="{{ isActive('admin.users.index') }}"><a href="{{ route('admin.users.index') }}">Todos Usuários</a></li>
                    <li class="{{ isActive('admin.users.create') }}"><a href="{{ route('admin.users.create') }}">Novo Usuário</a></li>
                    <li class="{{ isActive('admin.users.trashed') }}"><a href="{{ route('admin.users.trashed') }}">Usuários Inativos</a></li>
                 </ul>
            </li>
            <li class="dash_sidebar_nav_item" {{ isActive('admin.orders.index') }}><a class="icon-file-text" href="{{ route('admin.orders.index') }}">Ordens de Serviço</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class="{{ isActive('admin.orders.index') }}"><a href="{{ route('admin.orders.index') }}">Ver Todas</a></li>
                    <li class=""><a href="{{ route('admin.orders.create') }}">Nova Ordem de Serviço</a></li>
                    <li class=""><a href="{{ route('admin.orders.assign') }}">Atribuir Técnico</a></li>
                 </ul>
            </li>
            <li class="dash_sidebar_nav_item {{ isActive('admin.sector') }}"><a class="icon-columns" href="{{ route('admin.sector') }}">Setores</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class=""><a href="{{ route('admin.sector') }}">Ver Todos</a></li>
                    <li class=""><a href="{{ route('admin.sector.create') }}">Criar Novo</a></li>
                </ul>
            </li>
            <li class="dash_sidebar_nav_item {{ isActive('admin.services') }}"><a class="icon-external-link" href="{{ route('admin.services.index') }}">Serviços</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class=""><a href="{{ route('admin.services.index') }}">Ver Todos</a></li>
                    <li class=""><a href="{{ route('admin.services.create') }}">Criar Novo</a></li>
                </ul>
            </li>

            <li class="dash_sidebar_nav_item"><a class="icon-sign-out on_mobile" href="{{route('admin.logout')}}">Sair</a></li>
        </ul>

    </aside>

    <section class="dash_content">

        <div class="dash_userbar">
            <div class="dash_userbar_box">
                <div class="dash_userbar_box_content">
                    <span class="icon-align-justify icon-notext mobile_menu transition btn btn-green"></span>
                    <h1 class="transition">
                        <a href="{{ route('admin.home') }}">Painel <b>OS Fácil</b></a>
                    </h1>
                    <div class="dash_userbar_box_bar no_mobile">
                        <a class="text-red icon-sign-out" href=" {{route('admin.logout')}}">Sair</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash_content_box">
            @yield('content')

        </div>
    </section>
</div>


<script src="{{ url(mix('backend/assets/js/jquery.js')) }}"></script>
<script src="{{ url(mix('backend/assets/js/libs.js')) }}"></script>
<script src="{{ url(mix('backend/assets/js/scripts.js')) }}"></script>

@hasSection('js')
    @yield('js')
@endif

</body>
</html>
