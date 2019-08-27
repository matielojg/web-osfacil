@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-columns">Setores Cadastrados:</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('admin.sector') }}" class="text-green">Setores</a></li>
                </ul>
            </nav>

            <a href="{{ route('admin.sector.create') }}" class="btn btn-green ml-1">Novo Setor</a>

        </div>
    </header>


    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Setor</th>
                    <th>Responsável</th>
                    <th>Criado</th>
                    <th>Ação</th>

                </tr>
                </thead>
                <tbody>

               @foreach($sectors as $sector)
                <tr>
                    <td> {{$sector->id}}  </td>

                    <td><a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}" class="text-green"> {{ $sector->name_sector }} </a></td>
                    <td><a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}" class="text-green"> {{ $sector->first_name}} {{ $sector->last_name}} </a></td>
                    <td><a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}" class="text-green"> {{ date('d/m/Y H:i', strtotime($sector->created_at))}}</a></td>
                    <td>
                        <form action="{{ route('admin.sector.destroy', ['id'=>$sector->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}" class="btn btn-green ml-1 icon-check-square-o">Editar</a>
                           {{-- <a href="{{ route('admin.sector.disable', ['id'=>$sector->id]) }}" class="btn btn-yellow ml-1 icon-check-square-o">Desabilitar</a> --}}
                            <button class="btn btn-red ml-1 icon-trash" type="submit">Excluir</button>
                        </form>
                    </td>


                </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

    @endsection
