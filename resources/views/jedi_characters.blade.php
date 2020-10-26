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
                            <h3 class="card-title">Film Characters</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="property-list" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($results as $result)
                                    <tr>
                                        <td>{{ $result->name }}</td>
                                        <td>{{ $result->gender }}</td>
                                    </tr>
                                @empty
                                    @include('layouts.noRecords',['colspan' => 2])
                                @endforelse

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                </tr>
                                </tfoot>
                            </table>
                            {{ $characters->links() }}
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
