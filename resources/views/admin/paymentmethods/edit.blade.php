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
            <h2 class="mb-5 ml-5 mt-5">Update Payment Method</h2>

            <form id="frm" action="{{ route('payment_methods.update',$payment_method->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">

            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="coupon">Payment Method</label>
                        <input type="text" class="form-control" value="{{ $payment_method->payment_method }}" name="payment_method" id="payment_method" placeholder="Coupon">
                    </div>
                    <div class="form-group">
                        <label for="enable">Enable</label>
                        <select name="enable" id="enable" class="form-control">
                            @if($payment_method->enable == 0)
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                            @else
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                            @endif
                        </select>
                    </div>
                    @if($payment_method->payment_method == "Bank Transfer")
                    <div class="form-group">
                        <label for="enable">Bank Detail</label>
                        <textarea name="details" id="froala-editor" cols="30" rows="10">{{ $payment_method->details }}</textarea>
                    </div>
                    @endif








                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

            <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>

CKEDITOR.replace( 'details', {
							filebrowserUploadUrl: "{{ route('details.upload', ['_token' => csrf_token() ]) }}",
							filebrowserUploadMethod: 'form'
						});
</script>
@endsection