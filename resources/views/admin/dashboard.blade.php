@extends('admin.master.master')

@section('content')

    <div style="flex-basis: 100%;">
        <section class="dash_content_app">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Dashboard</h2>
            </header>

            <div class="dash_content_app_box">
                <section class="app_dash_home_stats">
                    <article class="control radius">
                        <h4 class="icon-users">Usuários</h4>
                        <p><b>Supervisores:</b> 2</p>
                        <p><b>Funcionários:</b> 46</p>
                        <p><b>Técnicos:</b> 12</p>
                    </article>

                    <article class="blog radius">
                        <h4 class="icon-file-text">Ordens</h4>
                        <p><b>Abertas:</b> 100</p>
                        <p><b>Pendentes:</b> 100</p>
                        <p><b>Finalizadas:</b> 200</p>
                    </article>

                    <article class="users radius">
                        <h4 class="icon-file-text">Prioridades de Ordem</h4>
                        <p><b>Urgentes:</b> 57</p>
                        <p><b>Urgentes:</b> 57</p>
                        <p><b>Urgentes:</b> 57</p>
                    </article>
                </section>
            </div>
        </section>

        <section class="dash_content_app" style="margin-top: 40px;">
            <header class="dash_content_app_header">
                <h2 class="icon-tachometer">Últimas Ordens de Serviço Cadastradas</h2>
            </header>

            <div class="dash_content_app_box">
                <div class="dash_content_app_box_stage">
                    <table id="dataTable" class="nowrap hover stripe" width="100" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Solicitante</th>
                                <th>Setor</th>
                                <th>Prioridade</th>
                                <th>Status</th>
                                <th>Data de Abertura</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td> #1</td>
                                <td><a href="" class="text-green">Marcela Turim</a></td>
                                <td><a href="" class="text-green">Manutenção</a></td>
                                <td><a href="" class="text-green">Urgente</a></td>
                                <td><a href="" class="text-green">Aberto</a></td>
                                <td><a href="" class="text-green">22/08/2019</a></td>
                                <td><a href="" class="btn btn-green ml-1 icon-check-square-o">Editar</a></td>
                            </tr>
                            <tr>
                                <td> #1</td>
                                <td><a href="" class="text-green">Marcela Turim</a></td>
                                <td><a href="" class="text-green">Manutenção</a></td>
                                <td><a href="" class="text-green">Urgente</a></td>
                                <td><a href="" class="text-green">Aberto</a></td>
                                <td><a href="" class="text-green">22/08/2019</a></td>
                                <td><a href="" class="btn btn-green ml-1 icon-check-square-o">Editar</a></td>
                            </tr>        
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

@endsection
