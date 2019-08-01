@extends('admin.master.master')

@section('content')

    <section class="dash_content_app">

    <header class="dash_content_app_header">
        <h2 class="icon-columns">Setores Cadastrados:</h2>

        <div class="dash_content_app_header_actions">
            <nav class="dash_content_app_breadcrumb">
                <ul>
                    <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="separator icon-angle-right icon-notext"></li>
                    <li><a href="{{ route('admin.sector') }}" class="text-green">Setores</a></li>
                </ul>
            </nav>

            <a href="{{ route('admin.sectorCreate') }}" class="btn btn-green ml-1">Novo Setor</a>

        </div>
    </header>


    <div class="dash_content_app_box">
        <div class="dash_content_app_box_stage">
            <table id="dataTable" class="nowrap stripe" width="100" style="width: 100% !important;">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Setor</th>
                    <th>Responsável</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td><a href="" class="text-green">Marketing</a></td>
                    <td><a href="" class="text-green">Andrew Walmir</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><a href="" class="text-green">Manutenção</a></td>
                    <td><a href="" class="text-green">Matielo Gerônimo</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

    @endsection