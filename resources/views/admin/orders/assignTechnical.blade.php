@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">

            @foreach($assigns as $assign)
                <h2 class="icon-file-text">Ordem de Serviço Nº: {{ $assign->id }}</h2>

                <div class="dash_content_app_header_actions">
                    <nav class="dash_content_app_breadcrumb">
                        <ul>
                            <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="separator icon-angle-right icon-notext"></li>
                            <li><a href="{{ route('admin.orders.index') }}" class="text-green">Ordens de Serviço</a>
                            </li>
                            <li class="separator icon-angle-right icon-notext"></li>
                            <li><a href="" class="text-red">Editar Ordem</a></li>
                        </ul>
                    </nav>
                </div>

        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <ul class="nav_tabs">
                    <li class="nav_tabs_item">
                        <a href="#data" class="nav_tabs_item_link active">Informações</a>
                    </li>

                    <li class="nav_tabs_item">
                        <a href="#assign" class="nav_tabs_item_link">Atribuir Técnico</a>
                    </li>
                    <li class="nav_tabs_item">
                        <a href="#history" class="nav_tabs_item_link">Histórico</a>
                    </li>

                </ul>

                <div class="app_form">

                    <div class="nav_tabs_content">

                        <div id="data">
                            <div class="label_g2">
                                <div class="label">
                                    <h3>Data de Abertura:</h3>
                                    <p> {{ date('d/m/Y H:i', strtotime($assign->created_at)) }}</p>
                                </div>
                                <div class="label">
                                    <h3>Usuário solicitante:</h3>
                                    <p>{{ $assign->first_name }} {{ $assign->last_name }}</p>
                                </div>
                            </div>
                            <div class="label_g2">
                                <div class="label">
                                    <h3>Setor solicitante:</h3>
                                    <p>{{ $assign->requester }}</p>
                                </div>
                                <div class="label">
                                    <h3>Setor Responsável:</h3>
                                    <p>{{ $assign->provider }}</p>
                                </div>
                            </div>

                            <div class="label_g2">
                                <div class="label">
                                    <h3>Serviço:</h3>
                                    <p>{{ ucfirst($assign->name_service) }}</p>
                                </div>
                                <div class="label">
                                    <h3>Prioridade:</h3>
                                    <p>{{ ucfirst($assign->priority) }}</p>
                                </div>
                            </div>

                            <div class="label_g2">
                                <div class="label">
                                    <h3>Descreva o Problema:</h3>
                                    <p> {{ $assign->description }} </p>
                                </div>
                                @if(!empty($assign->responsible_first))
                                    <div class="label">
                                        <h3>Técnico Responsável:</h3>
                                        <p>
                                            {{ $assign->responsible_first }} {{ $assign->responsible_last }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            <div class="label">
                                <div class="label">
                                    <h3>Imagens</h3>
                                    <img src="{{ url('backend/assets/images/realty.jpeg') }}" width="250px">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div id="assign">
                            <div class="label">
                                <div class="label">

                                    <form class="app_form" method="post"
                                          action="{{ route('admin.orders.assign.updateTechnical', ['id' => $assign->id ]) }}"
                                          enctype="multipart/form-data">
                                        @method('PATCH')
                                        @csrf
                                        <h3>Escolha o técnico:</h3>
                                        <select name="responsible" class="form-control">
                                            @foreach($technicals as $technical)
                                                <option
                                                    value="{{ $technical->id }}" {{ ( $technical->id == $assign->responsible) ? 'selected' : "" }}> {{ $technical->first_name}} {{ $technical->last_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="status"  value="2">
                                </div>
                            </div>
                        </div>


                        <div id="history" class="d-none">
                            <div class="label">
                                <table id="dataTable" class="" width="100"
                                       style="width: 100% !important;">
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Usuário</th>
                                        <th>Status</th>
                                        <th>Comentário</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($actions as $action)
                                        <tr>
                                            <td>{{ date('d/m/Y H:i', strtotime($action->created_at)) }}</td>
                                            <td>
                                                <a class="text-green">{{ $action->first_name }} {{ $action->last_name }}</a>
                                            </td>
                                            <td><a class="text-green">Alterou o Status para:
                                                    <b>{{ $action->status }}</b></a>
                                            </td>
                                            <td><a class="text-green">{{ $action->description }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                            Alterações
                        </button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection
