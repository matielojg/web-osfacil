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


                <form class="app_form" action=" " method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="nav_tabs_content">
                        <div id="data">
                            <div class="label_g2">
                                <label class="label">
                                    <span class="legend">*Nome:</span>
                                    <input type="text" name="first-name" value="{{$user->first_name}} "/>
                                </label>
                                <label class="label">
                                    <span class="legend">*Sobrenome:</span>
                                    <input type="text" name="last-name" placeholder="Sobrenome"
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
                                {{-- VER COMO PUXAR O NOEM DO SETOR E FUNÇÃO --}}
                                <label class="label">
                                    <span class="legend">*Setor:</span>
                                    <input type="text" name="sector-name" value="Adicionar o setor"/>
                                </label>
                                <label class="label">
                                    <span class="legend">*Função:</span>
                                    <input type="text" name="function" value="Adicionar a função"/>
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
                                            <input type="tel" name="primary-contact" class="mask-cell"
                                                   value="{{ $user->primary_contact }} "/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Residencial:</span>
                                            <input type="tel" name="secondary-contact" class="mask-phone"
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

                        <div id="complementary" class="d-none">
                            <div class="app_collapse">
                                <div class="app_collapse_header collapse">
                                    <h3>Cônjuge</h3>
                                    <span class="icon-plus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content d-none content_spouse">

                                    <label class="label">
                                        <span class="legend">Tipo de Comunhão:</span>
                                        <select name="type_of_communion" class="select2">
                                            <option value="Comunhão Universal de Ben">Comunhão Universal de Bens
                                            </option>
                                            <option value="Comunhão Parcial de Bens">Comunhão Parcial de Bens</option>
                                            <option value="Separação Total de Bens">Separação Total de Bens</option>
                                            <option value="Participação Final de Aquestos">Participação Final de
                                                Aquestos
                                            </option>
                                        </select>
                                    </label>

                                    <label class="label">
                                        <span class="legend">Nome:</span>
                                        <input type="text" name="spouse_name" placeholder="Nome do Cônjuge"
                                               value=""/>
                                    </label>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Genero:</span>
                                            <select name="spouse_genre">
                                                <option value="male">Masculino</option>
                                                <option value="female">Feminino</option>
                                                <option value="other">Outros</option>
                                            </select>
                                        </label>

                                        <label class="label">
                                            <span class="legend">CPF:</span>
                                            <input type="text" class="mask-doc" name="spouse_document"
                                                   placeholder="CPF do Cliente" value=""/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">RG:</span>
                                            <input type="text" name="spouse_document_secondary"
                                                   placeholder="RG do Cliente" value=""/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Órgão Expedidor:</span>
                                            <input type="text" name="spouse_document_secondary_complement"
                                                   placeholder="Expedição" value=""/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Data de Nascimento:</span>
                                            <input type="tel" class="mask-date" name="spouse_date_of_birth"
                                                   placeholder="Data de Nascimento" value=""/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Naturalidade:</span>
                                            <input type="text" name="spouse_place_of_birth"
                                                   placeholder="Cidade de Nascimento" value=""/>
                                        </label>
                                    </div>

                                    <div class="label_g2">
                                        <label class="label">
                                            <span class="legend">Profissão:</span>
                                            <input type="text" name="spouse_occupation"
                                                   placeholder="Profissão do Cliente" value=""/>
                                        </label>

                                        <label class="label">
                                            <span class="legend">Renda:</span>
                                            <input type="text" class="mask-money" name="spouse_income"
                                                   placeholder="Valores em Reais" value=""/>
                                        </label>
                                    </div>

                                    <label class="label">
                                        <span class="legend">Empresa:</span>
                                        <input type="text" name="spouse_company_work" placeholder="Contratante"
                                               value=""/>
                                    </label>
                                </div>
                            </div>

                            <div class="app_collapse mt-2">
                                <div class="app_collapse_header collapse">
                                    <h3>Empresa</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">

                                    <div class="companies_list">
                                        <div class="no-content mb-2">Não foram encontrados registros!</div>

                                        <div class="companies_list_item mb-2">
                                            <p><b>Razão Social:</b> UpInside Treinamentos LTDA</p>
                                            <p><b>Nome Fantasia:</b> UpInside Treinamentos</p>
                                            <p><b>CNPJ:</b> 12.3456.789/0001-12 - <b>Inscrição Estadual:</b>1231423421
                                            </p>
                                            <p><b>Endereço:</b> Rodovia Dr. Antônio Luiz de Moura Gonzaga, 3339 Bloco A
                                                Sala
                                                208</p>
                                            <p><b>CEP:</b> 88048-301 <b>Bairro:</b> Campeche <b>Cidade/Estado:</b>
                                                Florianópolis/SC</p>
                                        </div>
                                    </div>

                                    <p class="text-right">
                                        <a href="javascript:void(0)" class="btn btn-green btn-disabled icon-building-o">Cadastrar
                                            Nova Empresa</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div id="realties" class="d-none">
                            <div class="app_collapse">
                                <div class="app_collapse_header collapse">
                                    <h3>Locador</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div id="realties">
                                        <div class="realty_list">
                                            <div class="realty_list_item mb-1">
                                                <div class="realty_list_item_actions_stats">
                                                    <img src="assets/images/realty.jpeg" alt="">
                                                    <ul>
                                                        <li>Venda: R$ 450.000,00</li>
                                                        <li>Aluguel: R$ 2.000,00</li>
                                                    </ul>
                                                </div>

                                                <div class="realty_list_item_content">
                                                    <h4>Casa Residencial - Campeche</h4>

                                                    <div class="realty_list_item_card">
                                                        <div class="realty_list_item_card_image">
                                                            <span class="icon-realty-location"></span>
                                                        </div>
                                                        <div class="realty_list_item_card_content">
                                                            <span
                                                                class="realty_list_item_description_title">Bairro:</span>
                                                            <span
                                                                class="realty_list_item_description_content">Campeche</span>
                                                        </div>
                                                    </div>

                                                    <div class="realty_list_item_card">
                                                        <div class="realty_list_item_card_image">
                                                            <span class="icon-realty-util-area"></span>
                                                        </div>
                                                        <div class="realty_list_item_card_content">
                                                            <span
                                                                class="realty_list_item_description_title">Área Útil:</span>
                                                            <span class="realty_list_item_description_content">150m&sup2;</span>
                                                        </div>
                                                    </div>

                                                    <div class="realty_list_item_card">
                                                        <div class="realty_list_item_card_image">
                                                            <span class="icon-realty-bed"></span>
                                                        </div>
                                                        <div class="realty_list_item_card_content">
                                                            <span
                                                                class="realty_list_item_description_title">Domitórios:</span>
                                                            <span class="realty_list_item_description_content">4 Quartos<br><span>Sendo 2 suítes</span></span>
                                                        </div>
                                                    </div>

                                                    <div class="realty_list_item_card">
                                                        <div class="realty_list_item_card_image">
                                                            <span class="icon-realty-garage"></span>
                                                        </div>
                                                        <div class="realty_list_item_card_content">
                                                            <span
                                                                class="realty_list_item_description_title">Garagem:</span>
                                                            <span
                                                                class="realty_list_item_description_content">4 Vagas<br><span>Sendo 2 cobertas</span></span>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="realty_list_item_actions">
                                                    <ul>
                                                        <li class="icon-eye">1234 Visualizações</li>
                                                    </ul>
                                                    <div>
                                                        <a href="" class="btn btn-blue icon-eye">Visualizar Imóvel</a>
                                                        <a href="" class="btn btn-green icon-pencil-square-o">Editar
                                                            Imóvel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="no-content">Não foram encontrados registros!</div>
                                    </div>
                                </div>
                            </div>

                            <div class="app_collapse mt-3">
                                <div class="app_collapse_header collapse">
                                    <h3>Locatário</h3>
                                    <span class="icon-minus-circle icon-notext"></span>
                                </div>

                                <div class="app_collapse_content">
                                    <div id="realties">
                                        <div class="no-content">Não foram encontrados registros!</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="management" class="d-none">
                            <div class="label_gc">
                                <span class="legend">Conceder:</span>
                                <label class="label">
                                    <input type="checkbox" name="admin"><span>Administrativo</span>
                                </label>

                                <label class="label">
                                    <input type="checkbox" name="client"><span>Cliente</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-2">
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                            <form action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-large btn-red ml-1 icon-trash" type="submit">Excluir Usuário
                                </button>
                            </form>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
