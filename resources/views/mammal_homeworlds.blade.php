@extends('layouts.master')

@section('inline-css')
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Mammals</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="property-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Homeworld</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($mammals as $mammal)
                                    <tr>
                                        <td>{{ $mammal['name'] }}</td>
                                        <td>{{ $mammal['homeworld'] }}</td>
                                    </tr>
                                @empty
                                    @include('layouts.noRecords',['colspan' => 2])
                                @endforelse

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Homeworld</th>
                                </tr>
                                </tfoot>
                            </table>
                            {{ $data->links() }}
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
    <div class="mx-auto mt-2" style="width: 200px;">
        <a href={{url()->previous()}}><button type="button" class="btn btn-primary">Back</button></a>
    </div>
@endsection

@section('inline-js')
    @parent
    @include('layouts.datatableJs')
@endsection
