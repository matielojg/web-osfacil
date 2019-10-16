@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-building-o">Setores de Serviço:</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Setores de Serviços</a></li>
                    </ul>
                </nav>
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
                        <th>Ação</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($sectorProviders as $sector)
                        <tr>
                            <td> #{{$sector->id}}  </td>

                            <td><a href="{{ route('admin.sectorsProvider.edit', ['id'=>$sector->id]) }}"
                                   class="text-green"> {{ $sector->name_sector }} </a></td>
                            <td><a href="{{ route('admin.sectorsProvider.edit', ['id'=>$sector->id]) }}"
                                   class="text-green"> {{ $sector->first_name}} {{ $sector->last_name}} </a></td>
                            <td><a href="{{ route('admin.sectorsProvider.edit', ['id'=>$sector->id]) }}"
                                   class="btn btn-green ml-1 icon-check-square-o">Editar</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
