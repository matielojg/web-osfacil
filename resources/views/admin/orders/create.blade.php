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
                        <li><a href="{{ route('admin.order') }}" class="text-green">Ordens de Serviço</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="" class="text-red">Nova Ordem</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action="" method="post" enctype="multipart/form-data">

                    <div class="nav_tabs_content">


                        <div id="data">
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Setor Solicitante:</span>
                                    <select name="genre">
                                        <option value="">--Selecione--</option>
                                        <option value="">Marketing</option>
                                        <option value="">Cozinha</option>
                                        <option value="">Reservas</option>
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">*Setor Responsável:</span>
                                    <select name="genre">
                                        <option value="">--Selecione--</option>
                                        <option value="">Manutenção</option>
                                        <option value="">Zeladoria</option>
                                    </select>
                                </label>
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Serviço:</span>
                                    <select name="genre">
                                        <option value="">--Selecione--</option>
                                        <option value="">Marketing</option>
                                        <option value="">Cozinha</option>
                                        <option value="">Reservas</option>
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">*Prioridade:</span>
                                    <select name="genre">
                                        <option value="">--Selecione--</option>
                                        <option value="">Manutenção</option>
                                        <option value="">Zeladoria</option>
                                    </select>
                                </label>
                            </div>
                            <div class="label">
                                <label class="label">
                                    <span class="legend">*Descreva o Problema:</span>
                                    <textarea name="name" placeholder="Descreva o Problema" value=""></textarea>
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
                                        <option value="">Concluído</option>
                                        <option value="">Pendente</option>
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