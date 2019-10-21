@extends('admin.master.master')

@section('content')

    <div style="flex-basis: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box">
                <section class="app_dash_home_stats">
                    <article class="control radius">
                        <h4 class="icon-users">Usuários</h4>
                        <p><b>Gerentes:</b> {{ $manager }} </p>
                        <p><b>Supervisores:</b> {{ $supervisor }} </p>
                        <p><b>Funcionários:</b> {{ $employee }} </p>
                        <p><b>Técnicos:</b> {{ $technician }} </p>
                    </article>

                    <article class="blog radius">
                        <h4 class="icon-file-text">Ordens</h4>
                        <p><b>Abertas:</b> {{ $orderOpen }}</p>
                        <p><b>Pendentes:</b> {{ $orderPending }}</p>
                        <p><b>Em execução:</b> {{ $orderInExecution }}</p>
                        <p><b>Finalizadas:</b> {{ $orderExecution }}</p>
                    </article>

                    <article class="users radius">
                        <h4 class="icon-file-text">Prioridades de Ordem</h4>
                        <p><b>Crítica:</b> {{ $orderCritical }}</p>
                        <p><b>Alta:</b> {{ $orderHigh }}</p>
                        <p><b>Média:</b> {{ $orderMedium }}</p>
                        <p><b>Baixa:</b> {{ $orderLow }}</p>
                    </article>
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimas Ordens de Serviço Cadastradas</h2>
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
                            <th>Data de Abertura</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($orders as $order)

                            <tr>
                                <td> #{{$order->id}}</td>
                                <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}"
                                       class="text-green">{{ $order->first_name }} {{ $order->last_name }}</a></td>

                                <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}"
                                       class="text-green"> {{$order->name_sector}}</a>
                                </td>

                                <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}"
                                       class="text-green">{{ ucfirst($order->priority) }}</a></td>
                                <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}"
                                       class="text-green">{{ ucfirst($order->status) }}</a></td>
                                <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}"
                                       class="text-green"> {{ date('d/m/Y H:i', strtotime($order->created_at))}}</a>
                                </td>
                                <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}"
                                       class="btn btn-green ml-1 icon-check-square-o">Editar</a></td>
                                                            <td><a href="{{ route('admin.orders.edit', ['id'=>$order->id]) }}" class="text-green"> {{ ( $sector->id == $order->sector_provider_id) ? 'selected' : '' }} > {{ $sector->name_sector }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

@endsection
