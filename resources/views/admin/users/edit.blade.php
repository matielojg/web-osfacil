@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-pencil">Editar Usuário: # {{ $user->id }}</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}">Usuários</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Editar Usuário</a></li>
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

                @if(session()->exists('message'))
                    @message(['color' => session()->get('color')])
                    <p class="icon-asterisk">{{ session()->get('message') }}</p>
                    @endmessage
                @endif


                <form class="app_form" action=" {{ route('admin.users.update', ['user' =>$user->id]) }} " method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="nav_tabs_content">
                        <input type="hidden" name="_method" value="PUT">
                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">* Nome:</span>
                                <input type="text" name="first_name"
                                       value="{{ old('first_name') ?? $user->first_name}} "/>
                            </label>
                            <label class="label">
                                <span class="legend">* Sobrenome:</span>
                                <input type="text" name="last_name" placeholder="Sobrenome"
                                       value="{{ old('last_name') ?? $user->last_name}}"/>
                            </label>
                        </div>
                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">* E-mail:</span>
                                <input type="email" name="email" value="{{ old('email') ?? $user->email}}"/>
                            </label>
                            <label class="label">
                                <span class="legend">* CPF:</span>
                                <input type="text" class="mask-doc" name="document"
                                       value="{{ old('document') ?? $user->document}}"/>
                            </label>
                        </div>

                        <div class="label_g2">
                            <label class="label">
                                <span class="legend">* Setor:</span>
                                <select name="sector" class="form-control" required="ON">
                                    @foreach ($sectors as $sector)
                                        <option
                                                value="{{ $sector->id }}" {{ ( $sector->id == $user->sector) ? 'selected' : '' }} > {{ $sector->name_sector }}
                                            {{-- {{ (old('sector') == $sector->id ? 'selected' : ( $user->sector == $sector->id ? 'selected' : '')) }}> {{ $sector->name_sector }} --}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="label">
                                <span class="legend">* Função:</span>

                                <select name="function" class="form-control" required="ON">
                                    <option value="{{$user->function}}"> {{ ucfirst($user->function) }} </option>
                                    <option value="1" {{ (old('function') == '1' ? 'selected' : ( $user->function == '1' ? 'selected' : '')) }}>
                                        Funcionário
                                    </option>
                                    <option value="2" {{ (old('function') == '2' ? 'selected' : ( $user->function == '2' ? 'selected' : '')) }}>
                                        Técnico
                                    </option>
                                    <option value="3" {{ (old('function') == '3' ? 'selected' : ( $user->function == '3' ? 'selected' : '')) }}>
                                        Supervisor
                                    </option>
                                    <option value="4" {{ (old('function') == '4' ? 'selected' : ( $user->function == '4' ? 'selected' : '')) }}>
                                        Gerente
                                    </option>
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
                                               value="{{ old('primary_contact') ?? $user->primary_contact }} "/>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Telefone Residencial:</span>
                                        <input type="tel" name="secondary_contact" class="mask-phone"
                                               value=" {{ old('secondary_contact') ?? $user->secondary_contact }} "/>
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
                                        <span class="legend">* Nome de Usuário:</span>
                                        <input type="text" name="username"
                                               value="{{ old('username') ?? $user->username}}"/>
                                    </label>

                                    <label class="label">
                                        <span class="legend">* Senha:</span>
                                        <input type="password" name="password" placeholder="Senha de Acesso"
                                               value=""/>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="text-right mt-2">
                        <button
                                class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                        <a href="" class="btn btn-large btn-red icon-trash jpop_up_delete">Excluir Usuário</a>
                    </div>
                </form>
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
                    popupDelete += '<h1>Excluir Usuário</h1>';
                    popupDelete += '<p>Está certo disso? Posso perguntar?</p>';
                    popupDelete += '</header>';
                    popupDelete += '<form action=" {{route('admin.users.destroy', ['id'=>$user->id])}} " method="POST">';
                    popupDelete += '@csrf';
                    popupDelete += '@method('DELETE')';
                    popupDelete += '<button class="btn btn-red ml-1 icon-trash" type="submit">Excluir Usuário</button>';
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
