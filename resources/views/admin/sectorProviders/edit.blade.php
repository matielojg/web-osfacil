@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

        <header class="dash_content_app_header">
            <h2 class="icon-pencil">Atribuir Supervisor ao Setor: <span
                        class="text-green">{{$sectorEdit->name_sector}}</span></h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a href="{{ route('admin.sectorsProvider.index') }}">Setores</a></li>
                        <li class="separator icon-angle-right icon-notext"></li>
                        <li><a class="text-green">Editar Setor</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
            <div class="nav">
                <form class="app_form" action=" {{ url('admin/providers/update' , ['id'=>$sectorEdit->id]) }}"
                      method="post" enctype="multipart/form-data">
                    <div class="nav_tabs_content">
                        <div id="data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="label">

                                <label class="label">
                                    <span class="legend">*Responsável:</span>
                                    <select name="supervisor" class="form-control">
                                        @foreach ($supervisores as $supervisor)
                                            <option
                                                    value="{{ $supervisor->id }}" {{ ( $supervisor->id == $sectorEdit->supervisor) ? 'selected' : '' }}> {{ $supervisor->first_name}} {{ $supervisor->last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <a href="{{ route('admin.sectorsProvider.index')  }}" class="btn btn-large btn-yellow icon-arrow-left" type="submit">Cancelar
                        </a>
                        <button class="btn btn-large btn-green icon-check-square-o" type="submit">Salvar Alterações
                        </button>
                    </div>

                </form>

            </div>

        </div>
        </div>
    </section>

@endsection
