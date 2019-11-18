@extends('admin.master.master')

@section('content')


    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-plus-square-o">Novo Serviço</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.services.index') }}">Serviços</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Novo Serviço</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action="{{ route('admin.services.store') }}" method="post"
                      enctype="multipart/form-data">
                    <div class="nav_tabs_content">
                        <div id="data">
                            @csrf
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Nome do Serviço:</span>
                                    <input type="text" name="name_service" id="name_service"
                                           placeholder="Nome do Serviço"
                                           autocomplete="off"/>
                                </label>
                                <label class="label">
                                    <span class="legend">*Setor:</span>
                                    <select name="sector" class="form-control" required="ON">
                                        <option  value=" "> -- Selecione um Setor -- </option>
                                        @foreach ($sectors as $sector)
                                            <option
                                                value="{{ $sector->id }}"> {{ $sector->name_sector}} </option>
                                        @endforeach
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <a href="JavaScript: window.history.back();" class="btn btn-large btn-dark icon-arrow-left">Voltar</a>
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
