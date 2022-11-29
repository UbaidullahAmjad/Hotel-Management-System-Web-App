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
            <h2 class="mb-5 ml-5 mt-5">Update Order Price</h2>

            <form id="frm" action="{{ route('order_prices.update',$order_price->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">

            @Method('PUT')
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="eprice1">Price1 (€)</label>
                        <input type="text" class="form-control" name="euro_price_1" id="euro_price_1" value="{{ $order_price->euro_price_1 }}">

                    </div>
                    <div class="form-group">
                        <label for="eprice2">Price2 (€)</label>
                        <input type="text" class="form-control" name="euro_price_2" id="euro_price_2" value="{{ $order_price->euro_price_2 }}">

                    </div>
                    <div class="form-group">
                        <label for="tprice1">Price1 (TND)</label>
                        <input type="text" class="form-control" name="tnd_price_1" id="tnd_price_1" value="{{ $order_price->tnd_price_1 }}">

                    </div>
                    <div class="form-group">
                        <label for="tprice2">Price2 (TND)</label>
                        <input type="text" class="form-control" name="tnd_price_2" id="tnd_price_2" value="{{ $order_price->tnd_price_2 }}">

                    </div>


                    <div class="form-group">
                        <label for="cc">CC</label>
                        <select name="cc" id="cc" class="form-control">
                            @if($order_price->cc == 0)
                            <option value="0" selected>Disable</option>
                            <option value="{{ $cc->id }}">Active</option>
                            @else
                            <option value="0">Disable</option>
                            <option value="{{ $cc->id }}" selected>Active</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cc">In Person</label>
                        <select name="in_person" id="in_person" class="form-control">
                            @if($order_price->in_person == 0)
                            <option value="0" selected>Disable</option>
                            <option value="{{ $in_person->id }}">Active</option>
                            @else
                            <option value="0">Disable</option>
                            <option value="{{ $in_person->id }}" selected>Active</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_transfer">Bank Transfer</label>
                        <select name="bank_transfer" id="bank_transfer" class="form-control">
                            @if($order_price->bank_transfer == 0)
                            <option value="0" selected>Disable</option>
                            <option value="{{ $bank_transfer->id }}">Active</option>
                            @else
                            <option value="0">Disable</option>
                            <option value="{{ $bank_transfer->id }}" selected>Active</option>
                            @endif
                        </select>
                    </div>

                   






                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection