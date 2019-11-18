@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-building-o">Setores Cadastrados:</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Setores</a></li>
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
                        <th>Criado</th>
                        <th>Ação</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($sectors as $sector)
                        <tr>
                            <td> {{$sector->id}}  </td>

                            <td><a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}"
                                   class="text-green"> {{ $sector->name_sector }} </a></td>
                            <td><a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}"
                                   class="text-green"> {{ date('d/m/Y H:i', strtotime($sector->created_at))}}</a></td>
                            <td><a href="{{ route('admin.sector.edit', ['id'=>$sector->id]) }}"
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
