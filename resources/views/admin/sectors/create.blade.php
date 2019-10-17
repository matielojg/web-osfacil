@extends('admin.master.master')

@section('content')


    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-plus-square-o">Novo Setor</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.sector.index') }}">Setores</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Novo Setor</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action="<?= url('admin/setor/store'); ?>" method="post"
                      enctype="multipart/form-data">
                    <div class="nav_tabs_content">
                        <div id="data">
                            @csrf
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Nome do Setor:</span>
                                    <input type="text" name="name_sector" id="name_sector" placeholder="Nome do Setor"
                                           autocomplete="off"/>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
