@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">

            <h2 class="icon-file-text">Atribuir Técnico para Ordem de Serviço Nº: {{ $order->id }}</h2>

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
                        <a href="#assign" class="nav_tabs_item_link">Atribuir Técnico</a>
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
                                    <h3>Setor:</h3>
                                    <p>{{ $order->sectorRequester->name_sector}}</p>
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
                                    <p> {{ $order->description }} </p>
                                </div>
                            </div>

                            <div class="label">
                                <div class="order_image">
                                    @foreach($order->images()->get() as $image)
                                        <div class="order_image_item">
                                            <img src="{{ $image->url_cropped }}" alt="">
                                            <div class="order_image_actions">
                                                <a href="javascript:void(0)"
                                                   class="btn btn-red btn-small icon-times icon-notext image-remove"
                                                   data-action="{{ route('admin.orders.image.remove', ['id' =>$image->id]) }}"></a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>


                        <div id="assign">

                            <form class="app_form" method="post"
                                  action="{{ route('admin.orders.assign.updateTechnical', ['id' => $order->id ]) }}"
                                  enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="label_g2">
                                    <label class="label">
                                        <h3>Escolha o técnico:</h3>
                                        <select name="responsible" class="form-control">
                                            <option value="0">-- Selecione o Técnico --</option>
                                            @foreach($technicals as $technical)
                                                <option
                                                        value="{{ $technical->id }}" {{ ( $technical->id == $order->responsible) ? 'selected' : "" }}> {{ $technical->first_name}} {{ $technical->last_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="label">
                                        <h3>Escolha o Auxiliar:</h3>
                                        <select name="responsible" class="form-control">
                                            <option value="0">-- Selecione o Auxiliar --</option>
                                            @foreach($technicals as $technical)
                                                <option
                                                        value="{{ $technical->id }}" {{ ( $technical->id == $order->responsible) ? 'selected' : "" }}> {{ $technical->first_name}} {{ $technical->last_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    {{--                                    <input type="hidden" name="status" value="2">--}}
                                </div>
                        </div>
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                        Alterações
                    </button>
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
