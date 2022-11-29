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
            <h2 class="mb-5 ml-5 mt-5">Edit Room Type</h2>

            <form id="frm" action="{{ route('room_types.update',$room_type->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
            @method('PUT')
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" value="{{ $room_type->name }}" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="active">Active</label>
                        <select name="active" id="active" class="form-control" required>
                            <option value="{{ $room_type->active }}">{{ $room_type->active }}</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                    </div>

                    <div class="form-group">
                    <label for="capacity">Select Package</label>
                    <select name="package_id" id="package_id" class="form-control">
                        @foreach($packages as $p)
                        @if(!in_array($p->id,$package_ids))
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endif

                        @endforeach
                    </select>

                    </div>




                    @if(!empty($pack_rooms))
                    @foreach ($pack_rooms as $pack_room)

                    <div class="form-group">
                        <label for="onarrival">Pay on Arrival</label>
                        <select name="onarrival" id="onarrival" class="form-control">
                            @if($pack_room->onarrival == 0)
                            <option value="0" selected>0</option>
                            <option value="1">1</option>
                            @else
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                            @endif
                        </select>



                    </div>
                    <div class="form-group">
                        <label for="advance_price">Pay Advance (%)</label>
                        <input type="number" class="form-control" value="{{ $pack_room->advance_price }}" min="1" max="80" name="advance_price" id="advance_price">


                    </div>
                    <div class="form-group">
                        <label for="fullprice">Full Price</label>
                        <select name="fullprice" id="fullprice" class="form-control">
                        @if($pack_room->fullprice == 0)
                            <option value="0" selected>0</option>
                            <option value="1">1</option>
                        @else
                            <option value="0" >0</option>
                            <option value="1" selected>1</option>
                        @endif
                        </select>


                    </div>


                    <div class="form-group">
                        <label for="price1">Package Price per person per night (€)</label>
                        <input type="text" class="form-control"  name="package_price2[]" value="{{ $pack_room->package_price1 }}" id="package_price1"  >
                    </div>
                    <div class="form-group">
                        <label for="price2">Package Price per person per night (TND)</label>
                        <input type="text" class="form-control" value="{{ $pack_room->package_price2 }}" name="package_price2[]" id="package_price2"  >
                    </div>
                    <div class="form-group">
                        <label for="price1">Price per person per night (€)</label>
                        <input type="text" class="form-control"  name="price1[]" value="{{ $pack_room->normal_price1 }}" id="price1"  >
                    </div>
                    <div class="form-group">
                        <label for="price2">Price per person per night (TND)</label>
                        <input type="text" class="form-control" value="{{ $pack_room->normal_price2 }}" name="price2[]" id="price2"  >
                    </div>
                    <hr>
                    @endforeach
                    @endif
                    @if(!empty($range_prices))
                    <label for="">Range Prices</label>
                    @foreach ($range_prices as $range_price)

                    <div class="form-group">
                    <div class="mt-5">
                        <input class="mt-5" type="date" name="datefrom[]" value="{{ $range_price->datefrom }}"/>
                    </div>
                    <div>
                        <input class="mt-5" type="date" name="dateto[]" value="{{ $range_price->dateto }}"/>
                    </div>
                    <div>
                        <input class="mt-5" type="text" placeholder="Price per person per night (€)" name="rangeprice1[]" value="{{ $range_price->price1 }}"/>
                    </div>
                    <div>
                        <input class="mt-5" type="text" placeholder="Price per person per night (TND)" name="rangeprice2[]" value="{{ $range_price->price2 }}"/>
                    </div>
                    </div>
                    @endforeach
                    @endif

                    <div class="form-group mt-5 input_fields_wrap">
                        <button onclick="addPrice()" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add Package</button>
                    </div>
                    <div class="form-group" style="display: none;" id="display_packages">
                    <label for="capacity" >Select Package</label>
                    <select name="package_id[]" id="package_id" class="form-control">
                        @foreach($packages as $p)
                        @if(!in_array($p->id,$package_ids))
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endif

                        @endforeach
                    </select>

                    </div>

                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection