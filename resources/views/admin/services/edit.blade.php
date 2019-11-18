@extends('admin.master.master')

@section('content')


    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-pencil">Editar Serviço</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.services.index') }}">Serviços</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Editar Serviço</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action="{{ route('admin.services.update', ['id' =>$service->id]) }}" method="post"
                      enctype="multipart/form-data">
                    <div class="nav_tabs_content">
                        <div id="data">
                            @csrf
                            @method('PUT')
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Nome do Serviço:</span>
                                    <input type="text" name="name_service" id="name_service" autocomplete="off"
                                           value="{{ $service->name_service }}"/>
                                </label>
                                <label class="label">
                                    <span class="legend">*Setor Responsável:</span>
                                    <select name="sector" class="form-control" required="ON">
                                        <option  value=" "> -- Selecione um Setor -- </option>
                                        @foreach ($sectors as $sector)
                                            <option
                                                value="{{ $sector->id }}" {{ ( $sector->id == $service->sector) ? 'selected' : '' }}> {{ $sector->name_sector}}
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <a href="{{ route('admin.services.index')  }}" class="btn btn-large btn-yellow icon-arrow-left" type="submit">Cancelar
                        </a>
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                        <a href="" class="btn btn-large btn-red icon-trash jpop_up_delete">Excluir Serviço</a>
                    </div>
                </form>
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
                    popupDelete += '<h1>Excluir Serviço</h1>';
                    popupDelete += '<p>Está certo disso? Posso perguntar?</p>';
                    popupDelete += '</header>';
                    popupDelete += '<form action=" {{route('admin.services.destroy', ['id'=>$service->id])}} " method="POST">';
                    popupDelete += '@csrf';
                    popupDelete += '@method('DELETE')';
                    popupDelete += '<button class="btn btn-red ml-1 icon-trash" type="submit">Excluir Serviço</button>';
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
