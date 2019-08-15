@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-user-plus">Novo Usuário</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                <li><a href="{{ route('admin.users.index') }}">Novo Usuário</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="#" class="text-orange">Novo Cliente</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="dash_content_app_box">
        <div class="nav">
        
            <form class="app_form" action=" {{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
        <div class="nav_tabs_content">
                    <div id="data">

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">*Nome:</span>
                                <input type="text" name="first-name" placeholder="Nome" value=""/>
                            </label>

                            <label class="label">
                                <span class="legend">*Sobrenome:</span>
                                <input type="text" name="last-name" placeholder="Sobrenome" value=""/>
                            </label>
                        </div>
                        
                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">E-mail:</span>
                                <input type="email" name="email" placeholder="Melhor e-mail"
                                               value=""/>
                            </label>
                            <label class="label">
                                <span class="legend">*CPF:</span>
                                <input type="tel" class="mask-doc" name="document" placeholder="CPF do Cliente"
                                       value=""/>
                            </label>
                        </div>
                        <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Setor:</span>
                                    <select name="sector">
                                        <option value="">--Selecione--</option>
                                        <option value="">Marketing</option>
                                        <option value="">Cozinha</option>
                                        <option value="">Reservas</option>
                                    </select>
                                </label>

                                <label class="label">
                                    <span class="legend">*Tipo de Usuário:</span>
                                    <select name="function">
                                        <option value="">--Selecione--</option>
                                        <option value="">Gerente</option>
                                        <option value="">Supervisor</option>
                                        <option value="">Funcionário</option>
                                        <option value="">Técnico</option>
                                    </select>
                                </label>
                            </div>
            

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">Foto</span>
                                <input type="file" name="photo">
                            </label>
                        </div>

                        <div class="app_collapse mt-2">
                            <div class="app_collapse_header collapse">
                                <h3>Contato</h3>
                                <span class="icon-plus-circle icon-notext"></span>
                            </div>

                            <div class="app_collapse_content d-none">
                                <div class="label_g2">
                                        <label class="label">
                                                <span class="legend">*Celular:</span>
                                                <input type="tel" name="primary-contact" class="mask-cell"
                                                       placeholder="Número do Telefonce com DDD" value=""/>
                                            </label>
                                    <label class="label">
                                        <span class="legend">Residencial:</span>
                                        <input type="tel" name="secondary-contact" class="mask-phone"
                                               placeholder="Número do Telefonce com DDD" value=""/>
                                    </label>

                                  
                                </div>
                            </div>
                        </div>

                        <div class="app_collapse mt-2">
                            <div class="app_collapse_header collapse">
                                <h3>Acesso</h3>
                                <span class="icon-plus-circle icon-notext"></span>
                            </div>

                            <div class="app_collapse_content d-none">
                                <div class="label_g2">
                                    <label class="label">
                                        <span class="legend">*Login:</span>
                                        <input type="text" name="username" placeholder="Nome de Usuário"
                                               value=""/>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Senha:</span>
                                        <input type="password" name="password" placeholder="Senha de acesso"
                                               value=""/>
                                    </label>
                                </div>
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
