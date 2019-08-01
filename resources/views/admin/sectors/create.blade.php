@extends('admin.master.master')

@section('content')


    <section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-user-plus">Novo Setor</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="">Setores</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="" class="text-orange">Novo Setor</a></li>
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
                                <span class="legend">*Nome do Setor:</span>
                                <input type="text" name="name" placeholder="Nome do Setor" value=""/>
                            </label>

                            <label class="label">
                                <span class="legend">*Responsável:</span>
                                <select name="genre">
                                    <option value="">- Selecione -</option>
                                    <option value="">Andrew Walmir</option>
                                    <option value="">Diego Oliveira</option>
                                    <option value="">Matielo Gern</option>
                                </select>
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