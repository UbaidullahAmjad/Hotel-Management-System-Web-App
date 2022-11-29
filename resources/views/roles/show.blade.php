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
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h3> Show Role</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                </div>
            </div>
        
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Role Name:</strong>
                    {{ $role->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permissions:</strong>
                    @if(count($rolePermissions))
                        @foreach($rolePermissions as $v)
                            <label class="label label-success">{{ $v->name }},</label>
                        @endforeach
                    @else
                    <label class="label label-danger">No Permissions</label>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection