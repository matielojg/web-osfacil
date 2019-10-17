@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">
        <header class="dash_content_app_header">
            <h2 class="icon-pencil">Editar Setor</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.sector.index') }}">Setores</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Editar Setor</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action=" {{ url('admin/setor/update' , ['id'=>$sectorEdit->id]) }}" method="post"
                      enctype="multipart/form-data">
                    <div class="nav_tabs_content">
                        <div id="data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Nome do Setor:</span>
                                    <input type="text" name="name_sector" id="name_sector" placeholder="Nome do Setor"
                                           autocomplete="off" value="{{$sectorEdit->name_sector}}"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                        <a href="" class="btn btn-large btn-red icon-trash jpop_up_delete">Excluir Setor</a>
                    </div>
                </form>
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
                    popupDelete += '<h1>Excluir Setor</h1>';
                    popupDelete += '<p>Está certo disso? Posso perguntar?</p>';
                    popupDelete += '</header>';
                    popupDelete += '<form action=" {{route('admin.sector.destroy', ['id'=>$sectorEdit->id])}} " method="POST">';
                    popupDelete += '@csrf';
                    popupDelete += '@method('DELETE')';
                    popupDelete += '<button class="btn btn-red ml-1 icon-trash" type="submit">Excluir Setor</button>';
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
