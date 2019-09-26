@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-user-plus">Novo Usuário</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a class="text-green" href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}" class="text-green">Usuários</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.create') }}" class="text-red">Criar Usuário</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">

                {{-- Mensagem de Erro--}}
                @if($errors->all())
                    @foreach($errors->all() as $error)
                        @message(['color' => 'red'])
                        <p class="icon-asterisk">{{ $error }}</p>
                        @endmessage
                    @endforeach
                @endif

                <form class="app_form" action=" {{ route('admin.users.store') }}" method="post"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="nav_tabs_content">
                        <div id="data">
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">* Nome:</span>
                                    <input type="text" name="first_name" placeholder="Nome" value="{{ old('first_name') }}"/>
                                </label>
                                <label class="label">
                                    <span class="legend">* Sobrenome:</span>
                                    <input type="text" name="last_name" placeholder="Sobrenome" value="{{ old('last_name') }}"/>
                                </label>
                            </div>
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">* E-mail:</span>
                                    <input type="email" name="email" placeholder="Melhor e-mail" value="{{ old('email') }}"/>
                                </label>
                                <label class="label">
                                    <span class="legend">* CPF:</span>
                                    <input type="tel" class="mask-doc" name="document" placeholder="Número do CPF" value="{{ old('document') }}"/>
                                </label>
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">* Setor:</span>
                                    <select name="sector" >
                                        <option
                                            value=""> -- Selecione o setor --</option>
                                        @foreach ($sectors as $sector)
                                            <option
                                                    value="{{ $sector->id }}"
                                                    {{ old('sector') == $sector->id ? 'selected' : '' }}> {{ $sector->name_sector }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="label">
                                    <span class="legend">* Função:</span>
                                    <select name="function">
                                        <option value=""> -- Selecione a função --</option>
                                        <option value="funcionario" {{ old('function') == 'funcionario' ? 'selected' : '' }}> Funcionário</option>
                                        <option value="tecnico" {{ old('function') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                        <option value="supervisor" {{ old('function') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                        <option value="gerente" {{ old('function') == 'gerente' ? 'selected' : '' }}>Gerente</option>
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
                                            <span class="legend">* Celular:</span>
                                            <input type="tel" name="primary_contact" class="mask-cell"
                                                   placeholder="Número do Telefonce com DDD" value="{{ old('primary_contact') }}"/>
                                        </label>
                                        <label class="label">
                                            <span class="legend">Residencial:</span>
                                            <input type="tel" name="secondary_contact" class="mask-phone"
                                                   placeholder="Número do Telefonce com DDD" value="{{ old('secondary_contact') }}"/>
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
                                            <span class="legend">* Login:</span>
                                            <input type="text" name="username" placeholder="Nome de usuário"
                                                   value="{{ old('username') }}"/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">* Senha:</span>
                                            <input type="password" name="password" placeholder="Senha de acesso"
                                                   value="{{ old('password') }}" />
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
