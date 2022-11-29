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
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif
            </div>

        <div class="container" style="margin-top: 50px;">
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Update Policy</h2>

            <form id="frm" action="{{ route('policy.update',$policy->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">

            @Method('PATCH')
            @csrf
            <div class="row">
                <div class="col-12">

                    <label for="">Title</label>
                    <input type="text" name="title" value="{{ $policy->title }}" class="form-control">
                    <label for="">Policy</label>
                    <textarea name="policy" id="policy" cols="30" rows="10">{{ $policy->policy }}</textarea>
                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

            <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
            <script>

CKEDITOR.replace( 'policy', {
							filebrowserUploadUrl: "{{ route('policy.upload', ['_token' => csrf_token() ]) }}",
							filebrowserUploadMethod: 'form'
						});
</script>
@endsection