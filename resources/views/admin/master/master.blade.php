<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0">
    {{--  link do fontAwesome necessário pro arquivo Rating no show.blade da order  --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/reset.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/libs.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/boot.css')) }}"/>
    <link rel="stylesheet" href="{{ url(mix('backend/assets/css/style.css')) }}"/>
    <link rel='manifest' href="{{ url('/manifest.json') }}">

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
    if(\Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . auth()->user()->photo)){
        $photo = \Illuminate\Support\Facades\Auth::user()->url_photo;
    }else{
        $photo = url(asset("backend/assets/images/avatar.jpg"));
    }
@endphp


<div class="dash">
    <aside class="dash_sidebar">
        <article class="dash_sidebar_user">
            <img class="dash_sidebar_user_thumb" src="{{ $photo  }}" alt="" title=""/>

            <h1 class="dash_sidebar_user_name">
                <a href=" {{ route('admin.users.edit', ['id'=>auth()->user()->id]) }} "> {{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
            </h1>
        </article>

        <ul class="dash_sidebar_nav">
            <li class="dash_sidebar_nav_item {{ isActive('admin.home') }} ">
                <a class="icon-tachometer" href="{{ route('admin.home') }}">Dashboard</a>
            </li>

            {{-- USER --}}
            @can('onlyManagersView', App\User::class)
                <li class="dash_sidebar_nav_item {{ isActive('admin.users') }}"><a class="icon-users"
                                                                                   href="{{ route('admin.users.index') }}">Usuários</a>
                    <ul class="dash_sidebar_nav_submenu">
                        <li class="{{ isActive('admin.users.index') }}"><a href="{{ route('admin.users.index') }}">Todos
                                Usuários</a></li>
                        <li class="{{ isActive('admin.users.create') }}"><a href="{{ route('admin.users.create') }}">Novo
                                Usuário</a></li>
                        <li class="{{ isActive('admin.users.trashed') }}"><a href="{{ route('admin.users.trashed') }}">Usuários
                                Inativos</a></li>
                    </ul>
                </li>
            @endcan

            {{-- ORDER --}}
            <li class="dash_sidebar_nav_item {{ isActive('admin.orders') }}">

                <a class="icon-file-text" href="{{ route('admin.orders.index') }}">Ordens
                    de Serviço</a>
                <ul class="dash_sidebar_nav_submenu">
                    <li class="{{ isActive('admin.orders.index') }}"><a href="{{ route('admin.orders.index') }}"
                                                                        title="Exibir todas as ordens de serviço criadas pelo usuário logado">Minhas
                            Ordens</a></li>

                    @can('onlyTechnicalView', App\User::class)
                        <li class="{{ isActive('admin.orders.servicesToDo') }}"><a
                                    href="{{ route('admin.orders.servicesToDo') }}"
                                    title="Exibir todas os serviços que o usuário logado (técnico) precisa realizar">Serviços
                                a Realizar</a></li>
                    @endcan

                    <li class="{{ isActive('admin.orders.create') }}"><a href="{{ route('admin.orders.create') }}"
                                                                         title="Criar uma nova ordem de serviço">Nova
                            Ordem de Serviço</a></li>


                    @can('onlyManagersView', App\User::class)
                        <li class="{{ isActive('admin.orders.assign') }}"><a href="{{ route('admin.orders.assign') }}"
                                                                             title="Atribuir um técnico para ser responsável pela realização de uma ordem de serviço">
                                Atribuir Técnico</a></li>

                        <li class="{{ isActive('admin.orders.ordersInProgress') }}"><a
                                    href="{{ route('admin.orders.ordersInProgress') }}"
                                    @if(auth()->user()->function == "gerente")
                                    title="Exibir todas as ordens de serviço do sistema que estejam sendo realizadas"
                                    @else
                                    title="Exibir todas as ordens de serviço que estejam sendo realizadas, dos setores em que o usuário logado é supervisor"
                                    @endif
                            >Ordens em Andamento</a></li>

                        <li class="{{ isActive('admin.orders.pending') }}"><a
                                    href="{{ route('admin.orders.pending') }}"
                                    @if(auth()->user()->function == "gerente")
                                    title="Exibir todas as ordens de serviço pendentes do sistema"
                                    @else
                                    title="Exibir todas as ordens de serviço pendentes, dos setores em que o usuário logado é supervisor"
                                    @endif
                            >Ordens Pendentes</a></li>

                        <li class="{{ isActive('admin.orders.avaliate') }}"><a
                                    href="{{ route('admin.orders.avaliate') }}"
                                    @if(auth()->user()->function == "gerente")
                                    title="Exibir todas as ordens de serviço executadas do sistema"
                                    @else
                                    title="Exibir todas as ordens de serviço executadas, dos setores em que o usuário logado é supervisor"
                                    @endif
                            >Ordens Executadas</a></li>

                        <li class="{{ isActive('admin.orders.completed') }}"><a
                                    href="{{ route('admin.orders.completed') }}"
                                    @if(auth()->user()->function == "gerente")
                                    title="Exibir todas as ordens de serviço finalizadas do sistema"
                                    @else
                                    title="Exibir todas as ordens de serviço finalizadas, dos setores em que o usuário logado é supervisor"
                                    @endif
                            >Ordens Finalizadas</a></li>

                        <li class="{{ isActive('admin.orders.avaliate') }}"><a
                                    href="{{ route('admin.orders.avaliate') }}"
                                    @if(auth()->user()->function == "gerente")
                                    title="Exibir todas as ordens de serviço do sistema"
                                    @else
                                    title="Exibir todas as ordens de serviço, dos setores em que o usuário logado é supervisor"
                                    @endif
                            >Ver Todas</a></li>
                    @endcan

                    @can('onlyEmployeeView', App\User::class)
                        <li class="{{ isActive('admin.orders.completed') }}"><a
                                    href="{{ route('admin.orders.completed') }}"
                                   title="Exibir todas as ordens de serviço abertas pelo usuário logado e que estão finalizadas"
                            >Ordens Finalizadas</a></li>
                    @endcan

                </ul>
            </li>

            {{-- SECTOR --}}
            @can('onlyManagersView', App\User::class)
                <li class="dash_sidebar_nav_item {{ isActive('admin.sector') }}"><a class="icon-building-o"
                                                                                    href="{{ route('admin.sector.index') }}">Setores</a>
                    <ul class="dash_sidebar_nav_submenu">
                        <li class="{{ isActive('admin.sector.index') }}"><a href="{{  route('admin.sector.index') }}">Ver
                                Todos</a></li>
                        <li class="{{ isActive('admin.sector.create') }}"><a href="{{ route('admin.sector.create') }}">Criar
                                Novo</a></li>
                        <li class="{{ isActive('admin.sectorsProvider.index') }}"><a
                                    href="{{ route('admin.sectorsProvider.index') }}">Supervisores</a></li>
                    </ul>
                </li>

                {{-- SERVICE --}}
                <li class="dash_sidebar_nav_item {{ isActive('admin.services') }}"><a class="icon-cogs"
                                                                                      href="{{ route('admin.services.index') }}">Serviços</a>
                    <ul class="dash_sidebar_nav_submenu">
                        <li class="{{ isActive('admin.services.index') }}"><a
                                    href="{{ route('admin.services.index') }}">Ver
                                Todos</a></li>
                        <li class="{{ isActive('admin.services.create') }}"><a
                                    href="{{ route('admin.services.create') }}">Criar
                                Novo</a></li>
                    </ul>
                </li>
            @endcan


            <li class="dash_sidebar_nav_item"><a class="icon-sign-out on_mobile"
                                                 href="{{route('admin.logout')}}">Sair</a></li>
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
