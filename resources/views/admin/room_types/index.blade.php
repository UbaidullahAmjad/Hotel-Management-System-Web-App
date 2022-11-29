@extends('layouts.admin-layout')

@section('content')

<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
</style>

<div class="page" style="margin-top: 100px;">
   <div class="page-main h-100">
		<div class="app-content">
        <div class="container">
            <div class="card">
            <div class="row mt-5 ml-5">
                <div class="col-6">
                    <h2>Room Types</h2>
                </div>
                <div class="col-6 mb-5">
                    <a href="{{ route('room_types.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Room Type</a>
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
                                <th>Name</th>

                                <th>Active</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        @if(!empty($room_types))
                        @foreach($room_types as $room_type)

                        <tbody>
                            <tr>
                                <td>{{ $room_type->name }}</td>
                                <td>{{ $room_type->active }}</td>


                                <td>
                                    <a href="{{ route('room_types.edit',$room_type->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('room_types.show',$room_type->id) }}" style="background-color: #925F0C;" class="btn"><i class="fa fa-eye"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['room_types.destroy', $room_type->id], 'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline']) !!}
                {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' => 'btn btn-danger']) !!}

                {{ Form::token() }}
                {!! Form::close() !!}

                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                        @endif
                    </table>
            </div>
        </div>

        </div>
   </div>
</div>

@endsection