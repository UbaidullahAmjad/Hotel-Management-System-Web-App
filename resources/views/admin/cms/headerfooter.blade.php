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
            <h2 class="mb-5 ml-5 mt-5">Edit Header/Footer Text</h2>

            <form id="frm" action="{{ route('setting.update.header', $setting->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
            <label for="">logo</label>
                        <img src="{{ asset('/storage/'.$setting->logo) }}" alt="">
                        <input type="file" name="logo" value="{{ $setting->logo }}" class="form-control mb-5" >
                <div class="col-md-6">
                <h2>In French</h2>

                    <div class="form-group">

                        <label for="">Login Text</label>
                        <input type="text" name="login" value="{{ $setting->login }}" class="form-control" >
                        <label for="">Register Text</label>
                        <input type="text" name="reg" value="{{ $setting->reg }}" class="form-control" >
                        <label for="">Important Link Text</label>
                        <input type="text" name="imp_link" value="{{ $setting->imp_link }}" class="form-control" >
                        <label for="">Link 1 Text</label>
                        <input type="text" name="im_link_1" value="{{ $setting->im_link_1 }}" class="form-control" >
                        <label for="">Link 2 Text</label>
                        <input type="text" name="im_link_2" value="{{ $setting->im_link_2 }}" class="form-control" >
                        <label for="">Link 3 Text</label>
                        <input type="text" name="im_link_3" value="{{ $setting->im_link_3 }}" class="form-control" >
                        <label for="">Link 4 Text</label>
                        <input type="text" name="im_link_4" value="{{ $setting->im_link_4 }}" class="form-control" >

                        <label for="">Support Link Text</label>
                        <input type="text" name="s_link" value="{{ $setting->s_link }}" class="form-control" >
                        <label for="">Telephone Text</label>
                        <input type="text" name="tel" value="{{ $setting->tel }}" class="form-control" >
                        <label for="">Fax Text</label>
                        <input type="text" name="fax" value="{{ $setting->fax }}" class="form-control" >
                        <label for="">Mail Text</label>
                        <input type="text" name="mail" value="{{ $setting->mail }}" class="form-control" >


                    </div>


                </div>
                <div class="col-md-6">
                    <h2>In Other Language</h2>
                    <div class="form-group">

                        <label for="">Login Text</label>
                        <input type="text" name="login1" value="{{ $setting->login1 }}" class="form-control" >
                        <label for="">Register Text</label>
                        <input type="text" name="reg1" value="{{ $setting->reg1 }}" class="form-control" >
                        <label for="">Important Link Text</label>
                        <input type="text" name="imp_link1" value="{{ $setting->imp_link1 }}" class="form-control" >
                        <label for="">Link 1 Text</label>
                        <input type="text" name="im_link_11" value="{{ $setting->im_link_11 }}" class="form-control" >
                        <label for="">Link 2 Text</label>
                        <input type="text" name="im_link_22" value="{{ $setting->im_link_22 }}" class="form-control" >
                        <label for="">Link 3 Text</label>
                        <input type="text" name="im_link_33" value="{{ $setting->im_link_33 }}" class="form-control" >
                        <label for="">Link 4 Text</label>
                        <input type="text" name="im_link_44" value="{{ $setting->im_link_44 }}" class="form-control" >

                        <label for="">Support Link Text</label>
                        <input type="text" name="s_link1" value="{{ $setting->s_link1 }}" class="form-control" >
                        <label for="">Telephone Text</label>
                        <input type="text" name="tel1" value="{{ $setting->tel1 }}" class="form-control" >
                        <label for="">Fax Text</label>
                        <input type="text" name="fax1" value="{{ $setting->fax1 }}" class="form-control" >
                        <label for="">Mail Text</label>
                        <input type="text" name="mail1" value="{{ $setting->mail1 }}" class="form-control" >


                    </div>


                </div>





                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>



            </div>

@endsection