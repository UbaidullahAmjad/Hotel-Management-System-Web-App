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
            <h2 class="mb-5 ml-5 mt-5">Update Coupon</h2>

            <form id="frm" action="{{ route('coupons.update',$coupon->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="coupon">Coupon</label>
                        <input type="text" class="form-control" value="{{ $coupon->coupon }}" name="coupon" id="coupon" placeholder="Coupon">
                    </div>
                    <div class="form-group">
                        <label for="enable">Enable</label>
                        <select name="enable" id="enable" class="form-control">
                            @if($coupon->enable == 0)
                            <option value="0" selected>0</option>
                            <option value="1">1</option>
                            @else
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                            @endif
                        </select>
                    </div>






                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection