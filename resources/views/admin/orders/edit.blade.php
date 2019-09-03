@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            @foreach($orders as $order)
                <h2 class="icon-file-text">Ordem de Serviço Nº: {{ $order->id }}</h2>

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
                        <a href="#history" class="nav_tabs_item_link">Histórico</a>
                    </li>
                    <li class="nav_tabs_item">
                        <a href="#change" class="nav_tabs_item_link">Alterações</a>
                    </li>
                </ul>

                <form class="app_form" action="" method="post" enctype="multipart/form-data">

                    <div class="nav_tabs_content">

                        <div id="data">

                            <div class="label_g2">
                                <label class="label">
                                    <h3>Data de Abertura:</h3>
                                    <p> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                                </label>
                                <label class="label">
                                    <h3>Usuário solicitante:</h3>
                                    <p>{{ $order->first_name }} {{ $order->last_name }}</p>
                                </label>
                            </div>
                            <div class="label_g2">
                                <label class="label">
                                    <h3>Setor solicitante:</h3>
                                    <p>{{ $order->requester }}</p>
                                </label>
                                <label class="label">
                                    <h3>Setor Responsável:</h3>
                                    <p>{{ $order->provider }}</p>
                                </label>
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <h3>Serviço:</h3>
                                    <p>{{ ucfirst($order->name_service) }}</p>
                                </label>
                                <label class="label">
                                    <h3>Prioridade:</h3>
                                    <p>{{ ucfirst($order->priority) }}</p>
                                </label>
                            </div>
                            <div class="label">
                                <label class="label">
                                    <h3>Descreva o Problema:</h3>
                                    <p>
                                        {{ $order->description }}
                                    </p>
                                </label>
                                @endforeach
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <h3>Imagens</h3>
                                    <img src="{{ url('backend/assets/images/realty.jpeg') }}" width="250px">

                                </label>
                            </div>
                        </div>

                        <div id="history" class="d-none">
                            <div class="label">

                                <label class="label">
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
                                        <tr>
                                            <td>25/08/2019 - 16h30</td>
                                            <td><a href="" class="text-green">Jeferson</a></td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    <b>Em Execução</b></a>
                                            </td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    Mussum Ipsum, cacilds vidis litro abertis.
                                                    A ordem dos tratores não altera o pão duris.
                                                    Atirei o pau no gatis, per gatis num morreus.
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>26/08/2019 - 16h30</td>
                                            <td><a href="" class="text-green">Marcieli</a></td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    <b>Em Execução</b></a>
                                            </td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    Mussum Ipsum, cacilds vidis litro abertis.
                                                    A ordem dos tratores não altera o pão duris.
                                                    Atirei o pau no gatis, per gatis num morreus.
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>26/08/2019 - 16h30</td>
                                            <td><a href="" class="text-green">Marcieli</a></td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    <b>Em Execução</b></a>
                                            </td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    Mussum Ipsum, cacilds vidis litro abertis.
                                                    A ordem dos tratores não altera o pão duris.
                                                    Atirei o pau no gatis, per gatis num morreus.
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>26/08/2019 - 16h30</td>
                                            <td><a href="" class="text-green">Marcieli</a></td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    <b>Em Execução</b></a>
                                            </td>
                                            <td><a href="" class="text-green">Alterou o Status para:
                                                    Mussum Ipsum, cacilds vidis litro abertis.
                                                    A ordem dos tratores não altera o pão duris.
                                                    Atirei o pau no gatis, per gatis num morreus.
                                                </a>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </label>
                            </div>
                        </div>

                        <div id="change" class="d-none">
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Status:</span>
                                    <select name="status">
                                        <option value="">--Selecione--</option>
                                        <option value="">Concluído</option>
                                        <option value="">Pendente</option>
                                    </select>
                                </label>
                            </div>
                            <div class="label">
                                <div class="label">
                                    <label class="label">
                                        <span class="legend">*Descreva suas Alterações:</span>
                                        <textarea name="name" placeholder="Descreva suas Alterações"
                                                  value=""></textarea>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-large btn-red icon-check-square-o" type="submit">Excluir</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
