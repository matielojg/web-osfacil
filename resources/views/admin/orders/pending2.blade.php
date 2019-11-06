@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-file-text">Atribuir Técnico:</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Ordens de Serviço Pendentes</a></li>
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
                        <th>Setor</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Técnico</th>
                        <th>Data de Abertura</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td> #{{$order->id}}</td>
                            <td><a href="{{ route('admin.orders.assign.technical', ['id'=>$order->id]) }}"
                                   class="text-green">{{ $order->userRequester->first_name }} {{  $order->userRequester->last_name }}</a>
                            </td>

                            <td><a href="{{ route('admin.orders.assign.technical', ['id'=>$order->id]) }}"
                                   class="text-green"> {{$order->sectorRequester->name_sector}}</a>
                            </td>

                            <td><a href="" class="text-green">{{ ucfirst($order->priority) }}</a></td>
                            <td><a href="" class="text-green">{{ ucfirst($order->status) }}</a></td>
                            <td><a href=""
                                   class="text-green"> {{ $order->userResponsible->first_name}}{{ $order->userResponsible->last_name }}</a>
                            </td>

                            <td><a href="" class="text-green"> {{ date('d/m/Y H:i', strtotime($order->created_at))}}</a>
                            </td>

                            <td><a href="{{ route('admin.orders.assign.technical', ['id'=>$order->id]) }}"
                                   class="btn btn-green ml-1 icon-check-square-o">Atribuir Técnico</a>
                                <a href="{{route('admin.orders.edit', ['id'=>$order->id]) }}"
                                   class="btn btn-blue ml-1 icon-check-square-o">Avaliar Ordem</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
