@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">
        <header class="dash_content_app_header">
            <h2 class="icon-file-text">Editar Ordens de Serviço Nº {{ $order->id }}</h2>
            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.orders.index') }}">Ordens de Serviço</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Editar Ordem de Serviço</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action="{{ route('admin.orders.update', ['id'=>$order->id]) }}" method="post"
                      enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="nav_tabs_content">

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Setor Responsável:</span>
                                <select name="sector_provider">
                                    <option
                                        value="{{ $order->sectorProvider->id }}"> {{ $order->sectorProvider->name_sector }}
                                    </option>
                                    @foreach ($sectorProviders as $sector)
                                        <option
                                            value="{{ $sector->id }}" }}> {{ $sector->name_sector }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="label">
                                <span class="legend">*Prioridade:</span>
                                <select name="priority">
                                    <option value="{{ $order->priority}}">{{ ucfirst($order->priority)}}</option>
                                        <option value="1">Baixa</option>
                                        <option value="2">Media</option>
                                        <option value="3">Alta</option>
                                        <option value="4">Emergencial</option>
                                </select>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Serviço:</span>
                                <select name="service">
                                    <option
                                        value="{{ $order->serviceProvider->id }}">{{ ucfirst($order->serviceProvider->name_service) }}</option>
                                    @foreach ($services as $service)
                                        <option
                                            value="{{ $service->id }}" }}> {{ $service->name_service }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="label">
                                <span class="legend">*Tipo de Serviço:</span>
                                <select name="type_service">
                                    <option value="{{ $order->type_service }}">
                                        Manutenção {{ucfirst($order->type_service)}}</option>
                                    <option value="1">Manutenção Corretiva</option>
                                    <option value="2">Manutenção Preventiva</option>
                                </select>
                            </label>

                        </div>
                        <div class="label">
                            <label class="label">
                                <span class="legend">*Descreva o Problema:</span>
                                <textarea name="description" placeholder="Descreva o Problema"
                                          value="">{{ $order->description }}</textarea>
                            </label>
                        </div>

                        <label class="label">
                            <span class="legend">Imagens</span>
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
                        </label>

                        <label class="label">
                            <input type="file" name="files[]" multiple>
                        </label>

                        <div class="content_image"></div>


                    </div>
            </div>
        </div>
        <div class="text-right mt-2">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-large btn-green icon-arrow-left">Voltar</a>
            <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar
                Alterações
            </button>
        </div>
        </form>
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
