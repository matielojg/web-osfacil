@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-user">Usuários</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Usuários</a></li>
                    </ul>
                </nav>

                <a href="{{ route('admin.users.create') }}" class="btn btn-green icon-user-plus ml-1">Criar Usuário</a>

            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="dash_content_app_box_stage">
                <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Setor</th>
                        <th>Função</th>
                        <th>E-mail</th>
                        <th>Último Login</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>#{{$user->id}}</td>
                            <td><a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                                   class="text-green"> {{$user->first_name}}  {{$user->last_name}} </a></td>
                            <td><a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                                   class="text-green">{{ ucfirst($user->name_sector) }}</a></td>
                            <td><a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                                   class="text-green">{{ucfirst($user->function) }}</a></td>
                            <td><a href="mailto:{{ $user->email }}"
                                   class="text-green">{{ $user->email }}</a></td>
                            <td><a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                                   class="text-green">{{ date('d/m/Y - H:i', strtotime($user->last_login_at))}}</a></td>
                            <td>
                                <a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                                   class="btn btn-green ml-1 icon-pencil-square-o">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
