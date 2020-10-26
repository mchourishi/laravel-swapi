@extends('layouts.master')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">SWAPI</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="property-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Tasks</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{ url('/film/characters/jedi') }}">List all characters in film Return of the Jedi</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('species') }}">List all mammals in all StarWars films.</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('people.import') }}">Import all People.</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ url('/people/backup/swapi_data_pre_update.sql') }}">Backup Characters (swapi_characters table).</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('people.update') }}">Update Characters.</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ url('/people/backup/swapi_data_post_update.sql') }}">Backup Characters post update.</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('people.create')  }}">Create Character.</a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Tasks</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
