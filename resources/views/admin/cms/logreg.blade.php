@extends('layouts.admin-layout')

@section('content')
<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
</style>
<div class="page">
   <div class="page-main h-100">
		<div class="app-content">
            <div class="error-message">
            @if($errors->any())
            {{ implode('', $errors->all(':message')) }}
            @endif

            </div>

        <div class="container" style="margin-top: 50px;">
        @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Login/Register Page Text</h2>

            <form id="frm" action="{{ route('setting.update.logreg', $setting->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h2>In French</h2>
                    <div class="form-group">
                        <label for="">Login text</label>
                        <input type="text" name="login" value="{{ $setting->login }}" class="form-control" >
                        <label for="">Register text</label>
                        <input type="text" name="register" value="{{ $setting->register }}" class="form-control" >
                        <label for="">Name text</label>
                        <input type="text" name="name" value="{{ $setting->name }}" class="form-control" >
                        <label for="">Remember Me text</label>
                        <input type="text" name="rem_me" value="{{ $setting->rem_me }}" class="form-control" >
                        <label for="">Email text</label>
                        <input type="text" name="email" value="{{ $setting->email }}" class="form-control" >
                        <label for="">Password text</label>
                        <input type="text" name="pass" value="{{ $setting->pass }}" class="form-control" >
                        <label for="">Confirm Password text</label>
                        <input type="text" name="c_pass" value="{{ $setting->c_pass }}" class="form-control" >
                        <label for="">Not Registered Yet text</label>
                        <input type="text" name="not_reg_yet" value="{{ $setting->not_reg_yet }}" class="form-control" >
                        <label for="">Register Here text</label>
                        <input type="text" name="reg_here" value="{{ $setting->reg_here }}" class="form-control" >
                        <label for="">Have Account text</label>
                        <input type="text" name="h_acc" value="{{ $setting->h_acc }}" class="form-control" >
                        <label for="">Login Now text</label>
                        <input type="text" name="log_now" value="{{ $setting->log_now }}" class="form-control" >


                    </div>
                </div>
                <div class="col-md-6">
                    <h2>In Other Language</h2>
                    <div class="form-group">
                    <label for="">Login text</label>
                        <input type="text" name="login1" value="{{ $setting->login1 }}" class="form-control" >
                        <label for="">Register text</label>
                        <input type="text" name="register1" value="{{ $setting->register1 }}" class="form-control" >
                        <label for="">Name text</label>
                        <input type="text" name="name1" value="{{ $setting->name1 }}" class="form-control" >
                        <label for="">Remember Me text</label>
                        <input type="text" name="rem_me1" value="{{ $setting->rem_me1 }}" class="form-control" >
                        <label for="">Email text</label>
                        <input type="text" name="email1" value="{{ $setting->email1 }}" class="form-control" >
                        <label for="">Password text</label>
                        <input type="text" name="pass1" value="{{ $setting->pass1 }}" class="form-control" >
                        <label for="">Confirm Password text</label>
                        <input type="text" name="c_pass1" value="{{ $setting->c_pass1 }}" class="form-control" >
                        <label for="">Not Registered Yet text</label>
                        <input type="text" name="not_reg_yet1" value="{{ $setting->not_reg_yet1 }}" class="form-control" >
                        <label for="">Register Here text</label>
                        <input type="text" name="reg_here1" value="{{ $setting->reg_here1 }}" class="form-control" >
                        <label for="">Have Account text</label>
                        <input type="text" name="h_acc1" value="{{ $setting->h_acc1 }}" class="form-control" >
                        <label for="">Login Now text</label>
                        <input type="text" name="log_now1" value="{{ $setting->log_now1 }}" class="form-control" >

                    </div>
                </div>

                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>



            </div>

@endsection