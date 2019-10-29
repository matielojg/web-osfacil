@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">

            <h2 class="icon-file-text">Ordem de Serviço Nº {{ $order->id }}</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.orders.index') }}">Ordens de Serviço</a>
                        </li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="" class="text-green">Editar Ordem</a></li>
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
                        <a href="#change" class="nav_tabs_item_link">Inserir Alterações</a>
                    </li>
                </ul>

                <div class="app_form">

                    <div class="nav_tabs_content">

                        <div id="data">
                            <div class="label_g2">
                                <div class="label">
                                    <h3>Data de Abertura:</h3>
                                    <p> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                                </div>
                                <div class="label">
                                    <h3>Usuário solicitante:</h3>
                                    <p>{{ $order->userRequester->first_name }} {{ $order->userRequester->last_name }}</p>
                                </div>
                            </div>
                            <div class="label_g2">
                                <div class="label">
                                    <h3>Setor solicitante:</h3>
                                    <p>{{ $order->sectorRequester->name_sector }}</p>
                                </div>
                                <div class="label">
                                    <h3>Setor Responsável:</h3>
                                    <p>{{ $order->sectorProvider->name_sector }}</p>
                                </div>
                            </div>

                            <div class="label_g2">
                                <div class="label">
                                    <h3>Serviço:</h3>
                                    <p>{{ ucfirst($order->serviceProvider->name_service) }}</p>
                                </div>
                                <div class="label">
                                    <h3>Prioridade:</h3>
                                    <p>{{ ucfirst($order->priority) }}</p>
                                </div>
                            </div>
                            <div class="label_g2">
                                <div class="label">
                                    <h3>Descreva o Problema:</h3>
                                    <p>
                                        {{ $order->description }}
                                    </p>
                                </div>
                                {{--                                @if(!empty($order->responsible_first))--}}
                                {{--                                    <div class="label">--}}
                                {{--                                        <h3>Técnico Responsável:</h3>--}}
                                {{--                                        <p>--}}
                                {{--                                            {{ $order->responsible_first }} {{ $order->responsible_last }}--}}
                                {{--                                        </p>--}}
                                {{--                                    </div>--}}
                                {{--                                @endif--}}
                            </div>


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

                        <div id="change" class="d-none">
                            <form class="app_form"
                                  action="{{ route('admin.orders.edit.action', ['id' => $order->id ]) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <label class="label">
                                    <span class="legend">*Status:</span>
                                    <select name="status">
                                        <option value="{{ $order->status }}">-- {{ucfirst( $order->status) }}--
                                        </option>
                                        <option value="3">Em Execução</option>
                                        <option value="4">Executado</option>
                                        <option value="5">Suspenso</option>
                                        <option value="6">Pendente</option>
                                    </select>
                                </label>

                                <div class="label">
                                    <label class="label">
                                        <span class="legend">*Descreva suas Alterações:</span>
                                        <textarea name="description" placeholder="Descreva suas Alterações"
                                                  value="" required></textarea>
                                    </label>
                                </div>
                                <label class="label">
                                    <h3>Imagens</h3>
                                    <input type="file" name="files[]" multiple>
                                </label>

                                <div class="content_image"></div>

                                <div class="text-right mt-2">
                                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                                        Alterações
                                    </button>
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
