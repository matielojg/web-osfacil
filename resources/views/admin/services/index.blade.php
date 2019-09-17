@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-columns">Serviços Cadastrados:</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.services.index') }}" class="text-green">Serviços</a></li>
                    </ul>
                </nav>

                <a href="{{ route('admin.services.create') }}" class="btn btn-green ml-1">Novo Serviço</a>

            </div>
        </header>


        <div class="dash_content_app_box">
            <div class="dash_content_app_box_stage">
                <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Serviço</th>
                        <th>Setor</th>
                        <th>Criado</th>
                        <th>Ação</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($services as $service)
                        <tr>
                            <td> {{$service->id}}  </td>

                            <td><a href="{{ route('admin.services.edit', ['id'=>$service->id]) }}"
                                   class="text-green"> {{ $service->name_service }} </a></td>
                            <td><a href="{{ route('admin.services.edit', ['id'=>$service->id]) }}"
                                   class="text-green"> {{ $service->name_sector }} </a></td>
                            <td><a href="{{ route('admin.services.edit', ['id'=>$service->id]) }}"
                                   class="text-green"> {{ date('d/m/Y H:i', strtotime($service->created_at))}}</a></td>
                            <td><a href="{{ route('admin.services.edit', ['id'=>$service->id]) }}"
                                   class="btn btn-green ml-1 icon-check-square-o">Editar</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
