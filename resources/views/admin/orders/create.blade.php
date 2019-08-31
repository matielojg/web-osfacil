@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-file-text">Nova Ordens de Serviço:</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.orders.index') }}" class="text-green">Ordens de Serviço</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.orders.create') }}" class="text-red">Nova Ordem</a></li>
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


                        <div id="data">
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Setor Solicitante:</span>

                                    <select name="genre">
                                        @foreach($sectors as $sector)
                                            <option value="sector_requester">--Selecione--</option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">*Setor Responsável:</span>

                                    <select name="sector_provider">
                                        @foreach($sectors as $sector)
                                            <option value="">--Selecione--</option>
                                        @endforeach
                                    </select>

                                </label>
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Setor:</span>

                                    <select name="sector">
                                        <option
                                            value=""> ::Selecione o setor::
                                        </option>
                                        @foreach ($sectors as $sector)
                                            <option
                                                value="{{ $sector->id }}" }}> {{ $sector->name_sector }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">*Prioridade:</span>
                                    <select name="priority">
                                        <option value="">--Selecione--</option>
                                        <option value="">--Selecione--</option>
                                        <option value="">--Selecione--</option>
                                        <option value="">--Selecione--</option>
                                    </select>

                                </label>
                            </div>
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Descreva o Problema:</span>
                                    <textarea name="description" placeholder="Descreva o Problema" value=""></textarea>
                                </label>
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Adicionar Imagem</span>
                                    <input type="file" name="cover">
                                </label>
                            </div>
                        </div>

                        <div id="history" class="d-none">
                            <div class="label_g4">
                                <label class="label">
                                    <img class="" src="{{ url(asset('backend/assets/images/avatar.jpg')) }}" alt=""
                                         title=""/>

                                </label>
                                <label class="label_g2">
                                    <table id="dataTable" class="" width="100" style="width: 100% !important;">
                                        <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th>Comentário</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        <tr>
                                            <td>25/08/2019 - 16h30</td>
                                            <td><a href="" class="text-green">Jeferson</a></td>
                                            <td><a href="" class="text-green">Alterou o Status para: <b>Em Execução</b></a>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </label>
                            </div>
                        </div>

                        <div id="change" class="d-none">
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Status:</span>
                                    <select name="status">
                                        <option value="">--Selecione--</option>
                                        <option value="1">Concluído</option>
                                        <option value="2">Pendente</option>
                                        <option value="2">Em execução</option>
                                        <option value="2">Pendente</option>
                                    </select>

                                </label>
                            </div>
                            <div class="label">
                                <div class="label">
                                    <label class="label">
                                        <span class="legend">*Descreva suas Alterações:</span>
                                        <textarea name="name" placeholder="Descreva suas Alterações"
                                                  value=""></textarea>
                                    </label>
                                </div>
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
