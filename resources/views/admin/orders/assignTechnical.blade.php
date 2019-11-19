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
                                    <a href="JavaScript: window.history.back();" class="btn btn-large btn-dark icon-arrow-left">Voltar</a>
                                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                                        Alterações
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
    </section>

@endsection

@section('js')
    <script>
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input[name="files[]"]').change(function (files) {

                $('.content_image').text('');

                $.each(files.target.files, function (key, value) {
                    var reader = new FileReader();
                    reader.onload = function (value) {
                        $('.content_image').append(
                            '<div class="order_image_item">' +
                            '<div class="embed radius" ' +
                            'style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;">' +
                            '</div>' +
                            '</div>');
                    };
                    reader.readAsDataURL(value);
                });
            });

            $('.image-remove').click(function (event) {
                event.preventDefault();

                var button = $(this);

                $.ajax({
                    url: button.data('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (response) {

                        if (response.success === true) {
                            button.closest('.order_image_item').fadeOut(function () {
                                $(this).remove();
                            });
                        }
                    }
                })
            });

        });
    </script>
@endsection
