@extends('layouts.admin-layout')

@section('content')
<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
    #price{
        border: 1px solid lightgrey;
    font-weight: 400;
    font-size: 16px;
}

</style>
<div class="page">
   <div class="page-main h-100">
		<div class="app-content">
            <div class="error-message">
            @if($errors->any())
            {{ implode('', $errors->all(':message')) }}
            @endif
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif
            </div>

        <div class="container" style="margin-top: 50px;">
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Email Management</h2>

            <form id="frm" action="{{ route('emails.send') }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
            @csrf

            <input type="hidden" name="date" value="{{$date}}">
            <input type="hidden" name="countres[]" value="{{$countries}}">

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Subject</label>
                        <input type="text" name="subject" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea name="message" id="message" cols="30" rows="10"></textarea>
                        <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('message', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                    </div>


                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Send </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>
        </form>

            
@endsection