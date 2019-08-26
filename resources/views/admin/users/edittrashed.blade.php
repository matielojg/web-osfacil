@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-user-plus">Editar Usuário: # {{ $user->id }}</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a class="text-green" href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}" class="text-green">Usuários</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="#" class="text-red">Editar Usuário</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">

                {{--ADICIONAR O ACTION admin.users.update--}}


                <form class="app_form" action=" {{ route('admin.users.update', ['id' =>$user->id]) }} " method="post"
                      enctype="multipart/form-data">
                    <div class="nav_tabs_content">
                        <div id="data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Nome:</span>
                                    <input type="text" name="first_name" value="{{$user->first_name}} "/>
                                </label>
                                <label class="label">
                                    <span class="legend">*Sobrenome:</span>
                                    <input type="text" name="last_name" placeholder="Sobrenome"
                                           value="{{$user->last_name}}"/>
                                </label>
                            </div>
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*E-mail:</span>
                                    <input type="email" name="email" value="{{$user->email}}"/>
                                </label>
                                <label class="label">
                                    <span class="legend">*CPF:</span>
                                    <input type="tel" class="mask-doc" name="document" value="{{$user->document}}"/>
                                </label>
                            </div>

                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Setor:</span>
                                    <select name="sector" class="form-control" required="ON">
                                        @foreach ($sectors as $sector)
                                            <option
                                                    value="{{ $sector->id }}" {{ ( $sector->id == $user->sector_id) ? 'selected' : '' }}> {{ $sector->name_sector }} </option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="label">
                                    <span class="legend">*Função:</span>
                                    <input type="text" name="function" value="{{ $user->function }}"/>

                                    {{-- <select name="function" class="form-control" required="ON">
                                        <option value="$user->[function]"> {{ $user->function }} </option>
                                        <option value="0"> funcionario</option>
                                        <option value="1"> tecnico</option>
                                        <option value="2"> supervisor</option>
                                        <option value="3"> gerente</option>
                                    </select>
                                    --}}

                                </label>

                            </div>
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">Foto</span>
                                    <input type="file" name="cover">
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
                                            <input type="tel" name="primary_contact" class="mask-cell"
                                                   value="{{ $user->primary_contact }} "/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Residencial:</span>
                                            <input type="tel" name="secondary_contact" class="mask-phone"
                                                   value=" {{ $user->secondary_contact }} "/>
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
                                            <span class="legend">*Username:</span>
                                            {{-- ALTERAR PARA USERNAME DEPOIS QUE RODAR A MIGRATION --}}
                                            <input type="text" name="username" value="{{$user->username}}"/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">*Senha:</span>
                                            <input type="password" name="password" value="{{$user->password}}"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="text-right mt-2">

                        <form action="admin.users.destroy" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-large btn-yellow ml-1 icon-check-square-o" type="submit">Restaurar
                            </button>
                        </form>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection