@extends('layouts.admin-layout')


@section('content')

<style>
    .card{
        padding: 20px;
    }
</style>
<div class="app-content">
	<div class="side-app">
		<div class="row card" style="margin-top:50px">
            <div class="col-lg-12 margin-tb" style="margin-bottom:40px">
                <div class="pull-left">
                    <h2>Role Management</h2>
                </div>
                <div class="pull-right">
                
                    <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                  
                </div>
            </div>



            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif


            <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="280px">Action</th>
            </tr>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                       
                            <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                        
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

{!! $roles->render() !!}


@endsection