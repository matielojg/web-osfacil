@extends('admin.master.master')

@section('content')

    <div style="flex-basis: 100%;">

        <section class="dash_content_app" style="margin-top: 10px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Minhas Ordens de Serviço</h2>
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
                            <th>Status</th>
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
                                <td><a class="text-green">{{ ucfirst($order->status) }}</a></td>
                                <td><a class="text-green"> {{ date('d/m/Y H:i', strtotime($order->created_at))}}</a></td>
                                <td>
                                    @if($order->status == 'aberto' && $order->requester == auth()->user()->id)
                                        <a href="{{ route('admin.orders.edit.open', ['id'=>$order->id]) }}"
                                           class="btn btn-green ml-1 icon-pencil">Editar</a>
                                    @else
                                        <a href="{{ route('admin.orders.show', ['id'=>$order->id]) }}"
                                           class="btn btn-green ml-1 icon-eye">Ver</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

@endsection
