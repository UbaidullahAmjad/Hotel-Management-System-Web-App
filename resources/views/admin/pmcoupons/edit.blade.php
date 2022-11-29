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
            <div class="card">
            <h2 class="mb-5 ml-5 mt-5">Update Coupon</h2>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif

            <form id="frm" action="{{ route('coupons.update',$coupon->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">

            @Method('PUT')
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="coupon">Coupon Name</label>
                        <input type="text" id="coupon" name="coupon" value="{{ $coupon->coupon }}" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="couponp1">Coupon Price % (€)</label>
                        <input type="number" min="1" max="90" id="coupon_price1" value="{{ $coupon->coupon_price1 }}" name="coupon_price1" class="form-control">

                    </div>
                    <div class="form-group">
                        <label for="couponp2">Coupon Price % (TND)</label>
                        <input type="number" min="1" max="90" id="coupon_price2" value="{{ $coupon->coupon_price2 }}" name="coupon_price2" class="form-control">

                    </div>

                    <div class="form-group">
                        <label for="valid">Valid</label>
                        <select name="valid" id="valid" class="form-control">
                            @if($coupon->valid == 0)
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                            @else
                            <option value="0" >No</option>
                            <option value="1" selected>Yes</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="enable">Enable</label>
                        <select name="enable" id="enable" class="form-control">

                        @if($coupon->enable == 0)
                        <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                            @else
                            <option value="0" >No</option>
                            <option value="1" selected>Yes</option>
                            @endif

                        </select>
                    </div>



                    <div class="form-group">
                        <label for="cc">CC</label>
                        <select name="cc" id="cc" class="form-control">
                            @if($coupon->cc == 0)
                            <option value="0" selected>No</option>
                            <option value="{{ $cc->id }}">Yes</option>
                            @else
                            <option value="0">No</option>
                            <option value="{{ $cc->id }}" selected>Yes</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cc">In Person</label>
                        <select name="in_person" id="in_person" class="form-control">
                            @if($coupon->in_person == 0)
                            <option value="0" selected>No</option>
                            <option value="{{ $in_person->id }}">Yes</option>
                            @else
                            <option value="0">No</option>
                            <option value="{{ $in_person->id }}" selected>Yes</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_transfer">Bank Transfer</label>
                        <select name="bank_transfer" id="bank_transfer" class="form-control">
                            @if($coupon->bank_transfer == 0)
                            <option value="0" selected>No</option>
                            <option value="{{ $bank_transfer->id }}">Yes</option>
                            @else
                            <option value="0">No</option>
                            <option value="{{ $bank_transfer->id }}" selected>Yes</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="upfront">% UpFront</label>
                        <input type="number" min="1" max="80" class="form-control" name="percentage_upfront" id="percentage_upfront" value="{{ $coupon->percentage_upfront }}">

                    </div>
                    <div class="form-group">
                        <label for="arrival">% Arrival</label>
                        <input type="number" min="1" max="80" class="form-control" name="percentage_arrival" id="percentage_arrival" value="{{ $coupon->percentage_arrival }}">

                    </div>






                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection