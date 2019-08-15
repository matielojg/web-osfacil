@extends('admin.master.master')

@section('content')

<section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-search">Filtro</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="#" class="text-green">Usuários</a></li>
                </ul>
            </nav>

            <a href="{{ route('admin.users.create') }}" class="btn btn-green icon-user ml-1">Criar Usuário</a>
            
        </div>
    </header>
    


    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Setor</th>
                    <th>E-mail</th>
                    <th>Função</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}" class="text-green"> {{$user->first_name}} {{$user->last_name}} </a></td>
                    <td>{{$user->sector}}</td>
                    <td><a href="" class="text-green">{{ $user->email }}</a></td>
                    <td>{{$user->function}}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', ['id'=>$user->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}" class="btn btn-green ml-1 icon-check-square-o">Editar</a>
                            <button class="btn btn-red ml-1 icon-check-square-o" type="submit">Excluir</button>
                        </form>
                    </td>
                {{-- @if( $user->function == "SUPERVISOR")
                @endif --}}
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
