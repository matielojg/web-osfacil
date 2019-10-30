@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">
        <header class="dash_content_app_header">
            <h2 class="icon-file-text">Nova Ordem de Serviço:</h2>
            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.orders.index') }}">Ordens de Serviço</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Nova Ordem</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action="{{ route('admin.orders.store') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="nav_tabs_content">

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Setor Responsável:</span>
                                <select id="sector_provider" name="filter_sector_provider"
                                        title="Escolha ..."
                                        data-action="{{ route('admin.main-filter.search') }}" data-index="1">
                                    <option value="">-- Selecione --</option>
                                    @foreach ($sectorProviders as $sector)
                                        <option
                                            value="{{ $sector->id }}" }}> {{ $sector->name_sector }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>


                            <label class="label">
                                <span class="legend">*Serviço:</span>
                                <select id="service" name="filter_service" data-index="2">
                                    <option value=" ">-- Selecione --</option>
                                </select>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Prioridade:</span>
                                <select name="priority">
                                    <option value="">-- Selecione --</option>
                                    <option value="1">Baixa</option>
                                    <option value="2">Media</option>
                                    <option value="3">Alta</option>
                                    <option value="4">Emergencial</option>
                                </select>
                            </label>

                            <label class="label">
                                <span class="legend">*Tipo de Serviço:</span>
                                <select name="type_service">
                                    <option value="">-- Selecione --</option>
                                    <option value="1">Manutenção Corretiva</option>
                                    <option value="2">Manutenção Preventiva</option>
                                </select>
                            </label>

                        </div>
                        <div class="label">
                            <label class="label">
                                <span class="legend">*Descreva o Problema:</span>
                                <textarea name="description" placeholder="Descreva o Problema" value=""></textarea>
                            </label>
                        </div>

                        <label class="label">
                            <span class="legend">Imagens</span>
                            <input type="file" name="files[]" multiple>
                        </label>

                        <div class="content_image"></div>

                    </div>
            </div>
        </div>

        <input type="hidden" name="sector_requester" id="" value="{{ auth()->user()->sector }}">
        <input type="hidden" name="requester" id="" value="{{ auth()->user()->id }}">
        <div class="text-right mt-2">
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
        });
    </script>
@endsection
