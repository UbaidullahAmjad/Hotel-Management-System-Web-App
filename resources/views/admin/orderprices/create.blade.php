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
            <h2 class="mb-5 ml-5 mt-5">Add Order Price</h2>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
				@endif

            <form id="frm" action="{{ route('order_prices.store') }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="eprice1">Price1 (€)</label>
                        <input type="text" class="form-control" name="euro_price_1" id="euro_price_1" required>

                    </div>
                    <div class="form-group">
                        <label for="eprice2">Price2 (€)</label>
                        <input type="text" class="form-control" name="euro_price_2" id="euro_price_2" required>

                    </div>
                    <div class="form-group">
                        <label for="tprice1">Price1 (TND)</label>
                        <input type="text" class="form-control" name="tnd_price_1" id="tnd_price_1" required>

                    </div>
                    <div class="form-group">
                        <label for="tprice2">Price2 (TND)</label>
                        <input type="text" class="form-control" name="tnd_price_2" id="tnd_price_2" required>

                    </div>


                    <div class="form-group">
                        <label for="cc">CC</label>
                        <select name="cc" id="cc" class="form-control">

                            <option value="0">Disable</option>
                            <option value="{{ $cc->id }}">Active</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cc">In Person</label>
                        <select name="in_person" id="in_person" class="form-control">

                            <option value="0">Disable</option>
                            <option value="{{ $in_person->id }}">Active</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_transfer">Bank Transfer</label>
                        <select name="bank_transfer" id="bank_transfer" class="form-control">

                            <option value="0">Disable</option>
                            <option value="{{ $bank_transfer->id }}">Active</option>

                        </select>
                    </div>

                   






                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection