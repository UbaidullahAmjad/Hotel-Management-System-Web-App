@extends('layouts.admin-layout')

@section('content')
<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }
</style>
<div class="page">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="error-message">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>

            <div class="container" style="margin-top: 50px;">
                <div class="card">
                    <h2 class="mb-5 ml-5 mt-5">Edit Customer</h2>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    <form id="frm" action="{{ route('customers.update',$customer->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        {{ method_field('PUT') }}

                        @csrf

                        <div class="row">
                            <div class="col-12">
                            <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" value="{{$customer->fname}}" name="f_name"  required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="{{$customer->lname}}" name="l_name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{$customer->email}}" required>
                                </div><div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div><div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{$customer->mobno}}" required>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" id="role" class="form-control">
                                        @foreach($roles as $role)
                                            @if($customer->hasRole($role->name))
                                            <option value="{{$role->name}}" selected>{{ $role->name }}</option>
                                            @else
                                            <option value="{{$role->name}}">{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                


                                <div class="form-group mt-5">
                                    <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                                </div>

                            </div>

                        </div>

                       



                        @endsection