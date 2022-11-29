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

        <div class="container" style="margin-top: 100px;">
        @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Edit Header/Footer Text</h2>

            <form id="frm" action="{{ route('setting.update.newhome', $setting->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image">Logo</label>
                        <input type="file" class="dropify" data-default-file="{{ asset('/storage/'. $setting->logo) }}" data-height="180" name="logo" id="image" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="image">Background Image (Recommended Size: 1500x400)</label>
                        <input type="file" class="dropify" data-default-file="{{ asset('/storage/'. $setting->back) }}" data-height="180" name="back" id="image" />
                    </div>
                </div>
                <div class="col-md-12">
                

                    <div class="form-group">

                        <label for="">Address</label>
                        <textarea name="address" class="form-control" id="description" cols="100" rows="4">{{ $setting->address }}</textarea>
                                    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('address', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                        <label for="">Buttons Color</label>
                        <input type="color" name="btncolor" value="{{$setting->btncolor}}" style="background:{{$setting->btncolor}}" class="form-control" >
                        


                    </div>


                </div>


            </div>
            <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

@endsection