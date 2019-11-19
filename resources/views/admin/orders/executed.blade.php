@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">
        <header class="dash_content_app_header">
            <h2 class="icon-file-text">Ordens Executadas:</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Ordens Executadas</a></li>
                    </ul>
                </nav>
            </div>
        </header>


        <div class="dash_content_app_box">
            <div class="dash_content_app_box_stage">
                <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Solicitante</th>
                        <th>Setor Solicitante</th>
                        <th>Prioridade</th>
                        <th>Data de Abertura</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $order)

                        <tr>
                            <td> #{{$order->id}}</td>
                            <td>
                                <a class="text-green">{{ $order->userRequester->first_name }} {{ $order->userRequester->last_name }}</a>
                            </td>
                            <td><a class="text-green"> {{$order->sectorRequester->name_sector}}</a>
                            </td>
                            <td><a class="text-green">{{ ucfirst($order->priority) }}</a></td>
                            <td><a class="text-green"> {{ date('d/m/Y H:i', strtotime($order->created_at))}}</a></td>
                            <td>
                                @can('onlyManagersView', App\User::class)
                                    <a href="{{ route('admin.orders.editExecuted', ['id'=>$order->id]) }}"
                                       class="btn btn-green icon-pencil-square-o">Revisar Ordem</a>
                                @endcan
                                <a href="{{ route('admin.orders.show', ['id'=>$order->id]) }}"
                                   class="btn btn-green icon-eye">Ver</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
