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
                        <li><a href="{{ route('admin.orders.index') }}">Ordens de Serviço</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Editar Ordem de Serviço</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <div class="app_form">
                    <div class="nav_tabs_content">

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">Data de Abertura:</span>
                                <p>{{ date('d/m/Y H:i', strtotime($order->created_at))}}</p>
                            </label>

                            @if($order->status == 'executado')
                            <label class="label">
                                <span class="legend">Data de Encerramento:</span>
                                <p>{{ date('d/m/Y H:i', strtotime($order->closed_at)) ?? "-"}}</p>
                            </label>
                            @endif
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">Solicitante:</span>
                                <p>{{ $order->userRequester->first_name}} {{ $order->userRequester->last_name }}</p>
                            </label>

                            <label class="label">
                                <span class="legend">Setor do Problema:</span>
                                <p>{{ $order->sectorRequester->name_sector }}</p>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">Setor Responsável:</span>
                                <p>{{ $order->sectorProvider->name_sector }}</p>
                            </label>

                            <label class="label">
                                <span class="legend">Prioridade:</span>
                                <p>{{ ucfirst($order->priority)}}</p>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">Serviço:</span>
                                <p>{{ ucfirst($order->serviceProvider->name_service) }}</p>
                            </label>

                            <label class="label">
                                <span class="legend">Tipo de Serviço:</span>
                                <p>Manutenção {{ucfirst($order->type_service)}}</p>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">Técnico Responsável:</span>
                                <p>{{ $order->userResponsible->first_name ?? "-"}} {{ $order->userResponsibleg->last_name ?? "" }}</p>
                            </label>

                            <label class="label">
                                <span class="legend">Auxiliar:</span>
                                <p>{{ $order->technicianAncillary->first_name ?? "-"}} {{ $order->technicianAncillary->last_name ?? "" }}</p>
                            </label>
                        </div>

                        <div class="label">
                            <label class="label">
                                <span class="legend">Descrição do Problema:</span>
                                <p>{{ $order->description }}</p>
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
                                               class=""
                                               data-action="{{ route('admin.orders.image.remove', ['id' =>$image->id]) }}"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </label>

                    </div>
                </div>
            </div>

            <input type="hidden" name="sector_requester" id="" value="{{ auth()->user()->sector }}">
            <input type="hidden" name="requester" id="" value="{{ auth()->user()->id }}">
            <div class="text-right mt-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-large btn-green icon-arrow-left" >Voltar</a>
                <a class="btn btn-large btn-blue icon-print" onClick="self.print();" >Imprimir</a>
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
