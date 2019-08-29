@extends('admin.master.master')

@section('content')


    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-user-plus">Novo Serviço</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.services.index') }}">Serviços</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.services.create') }}" class="text-orange">Novo Serviço</a></li>
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
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Nome do Serviço:</span>
                                    <input type="text" name="name_service" id="name_service" autocomplete="off"
                                           value="{{ $service->name_service }}"/>
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
