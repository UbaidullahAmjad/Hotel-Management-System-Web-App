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
            <h2 class="mb-5 ml-5 mt-5">Add New Room Type</h2>

            <form id="frm" action="{{ route('room_types.store') }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="active">Active</label>
                        <select name="active" id="active" class="form-control" required>
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>



                    <!-- new code -->
                    <div class="form-group">
                        <label for="packages">Select Package</label>
                        <select name="package_id[]" id="packages" class="form-control">

                            @foreach($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>


                            @endforeach
                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="price1">Price per person per night (€)</label>
                        <input type="text" class="form-control" name="price1" id="price1">
                    </div>
                    <div class="form-group">
                        <label for="price2">Price per person per night (TND)</label>
                        <input type="text" class="form-control" name="price2" id="price2">
                    </div> -->

                    <div class="form-group">
                        <label for="onarrival">Pay on Arrival</label>
                        <select name="onarrival" id="onarrival" class="form-control">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>



                    </div>
                    <div class="form-group">
                        <label for="advance_price">Pay Advance (%)</label>
                        <input type="number" class="form-control" min="1" max="80" name="advance_price" id="advance_price">


                    </div>
                    <div class="form-group">
                        <label for="fullprice">Full Price</label>
                        <select name="fullprice" id="fullprice" class="form-control">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>


                    </div>
                    <div class="form-group mt-5 input_fields_wrap">
                        <!-- <button onclick="addPrice()" type="button" class="btn btn-success"><i class="fa fa-plus"></i>Add Package</button> -->
                    </div>

                    <div class="form-group" id="display_packages" style="display: none;">
                        <label for="packages">Select Package</label>
                        <select name="package_id[]" id="packages" class="form-control">

                            @foreach($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>


                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection