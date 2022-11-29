@extends('layouts.admin-layout')

@section('content')

<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }
</style>

<div class="page" style="margin-top: 100px;">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="container">
                <div class="card">
                    <div class="row mt-5">
                        <div class="col-6">
                            <h2>Packages</h2>
                        </div>
                        <div class="col-6 mb-5">
                            <a href="{{ route('packages.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Package</a>
                        </div>

                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>


                                <th>Active</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $i=1; @endphp
                        @foreach($packages as $package)

                        <tbody>
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $package->name }}</td>
                                @if($package->active == 0)
                                <td><span class="badge badge-danger">Not Active</span></td>
                                @else
                                <td><span class="badge badge-success">Active</span></td>

                                @endif
                                <td>
                                    <a href="{{ route('packages.edit',$package->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('packages.show',$package->id) }}" style="background-color: orange;" class="btn"><i class="fa fa-eye"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['packages.destroy', $package->id], 'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline']) !!}
                                    {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' => 'btn btn-danger']) !!}

                                    {{ Form::token() }}
                                    {!! Form::close() !!}

                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection