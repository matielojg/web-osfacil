@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">

            <h2 class="icon-file-text">Atribuir Técnico para Ordem de Serviço Nº: {{ $order->id ?? "-" }}</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Atribuir Técnico</a>
                        </li>
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
                        <a href="#technician" class="nav_tabs_item_link">Atribuir Técnico</a>
                    </li>
                </ul>

                <div class="app_form">
                    <div class="nav_tabs_content">

                        <div id="data">
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend ">Data de Abertura:</span>
                                    <p> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                                </label>
                                <label class="label">
                                    <span class="legend">Usuário solicitante:</span>
                                    <p>{{ $order->userRequester->first_name }} {{ $order->userRequester->last_name }}</p>
                                </label>
                            </div>
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Setor:</span>
                                    <p>{{ $order->sectorRequester->name_sector}}</p>
                                </label>
                                <label class="label">
                                    <span class="legend">Setor Responsável:</span>
                                    <p> {{ $order->sectorProvider->name_sector }}</p>
                                </label>
                            </div>
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Serviço:</span>
                                    <p>{{ ucfirst($order->serviceProvider->name_service) }}</p>
                                </label>
                                <label class="label">
                                    <span class="legend">Prioridade:</span>
                                    <p>{{ ucfirst($order->priority) }}</p>
                                </label>
                            </div>
                            <div class="label">
                                <label class="label">
                                    <span class="legend">Descreva o Problema:</span>
                                    <p> {{ $order->description }} </p>
                                </label>
                            </div>
                            <div class="label">
                                <span class="legend">Imagens:</span>
                                <div class="order_image">
                                    @foreach($order->images()->get() as $image)
                                        <div class="order_image_item">
                                            <img src="{{ $image->url_cropped }}" alt="">
                                            <div class="order_image_actions">
                                                <a href="javascript:void(0)"
                                                   class=""
                                                   data-action="{{ route('admin.orders.image.remove', ['id' =>$image->id]) }}"></a>
                                            </div>
                                        </div>
                                    @endforeach
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

                                    @foreach($order->action()->get() as $action)

                                        <tr>
                                            <td>{{ date('d/m/Y H:i', strtotime($action->created_at)) }}</td>
                                            <td>
                                                <a class="text-green">{{ $action->user2->first_name }} {{ $action->user2->last_name }} </a>
                                            </td>
                                            <td><a class="text-green">Alterou o status para:
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

                        <div id="technician" class="d-none">
                            <form class="app_form" method="post"
                                  action="{{ route('admin.orders.assign.updateTechnical', ['id' => $order->id ]) }}"
                                  enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <label class="label">
                                    <span class="legend">Escolha o técnico*:</span>
                                    <select name="responsible" class="form-control" required>
                                        <option value="">-- Selecione o Técnico --</option>
                                        @foreach($technicals as $technical)
                                            <option
                                                    value="{{ $technical->id }}" {{ ( $technical->id == $order->responsible) ? 'selected' : "" }}> {{ $technical->first_name}} {{ $technical->last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="label">
                                    <span class="legend">Escolha o Auxiliar:</span>
                                    <select name="ancillary" class="form-control">
                                        <option value="0">-- Selecione o Auxiliar --</option>
                                        @foreach($technicals as $technical)
                                            <option
                                                    value="{{ $technical->id }}" {{ ( $technical->id == $order->responsible) ? 'selected' : "" }}> {{ $technical->first_name}} {{ $technical->last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                                <div class="text-right mt-2">
                                    <a href="JavaScript: window.history.back();"
                                       class="btn btn-large btn-dark icon-arrow-left">Voltar</a>
                                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                                        Alterações
                                    </button>
                                    <a href="" class="btn btn-large btn-red icon-stop jpop_up_delete">Suspender
                                        Ordem</a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script>
        $(function () {

            $(".jpop_up_delete").click(function (e) {
                e.preventDefault();

                if (!$(".pop_up_delete").length) {
                    var popupDelete = '<div class="pop_up_delete">';
                    popupDelete += '<div class="pop_up_delete_box radius">';
                    popupDelete += '<header>';
                    popupDelete += '<h1>Suspender Ordem de Serviço?</h1>';
                    popupDelete += '<p>Está certo disso? Posso perguntar?</p>';
                    popupDelete += '</header>';
                    popupDelete += '<form action=" {{route('admin.orders.suspended', ['id'=>$order->id])}} " method="POST">';
                    popupDelete += '@csrf';
                    popupDelete += '<textarea style="border-radius: 4px; display: block; width: 100% !important; color: #000000;' +
                        'padding: 5px; border: 1px solid #cccccc; background: #ffffff; resize: none; outline: none; " ' +
                        'name="comment" placeholder="Descreva o Motivo" value="" required></textarea>';
                    popupDelete += '<button class="btn btn-red mt-1 icon-stop" type="submit">Suspender Ordem</button>';
                    popupDelete += '</form>';
                    popupDelete += '</div>';
                    popupDelete += '</div>';

                    $("body").prepend(popupDelete);
                    $(".pop_up_delete").fadeIn(200).css("display", "flex");

                    $("body").click(function (e) {
                        if ($(e.target).attr("class") === "pop_up_delete") {
                            $(".pop_up_delete").fadeOut(200, function () {
                                $(this).remove();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
