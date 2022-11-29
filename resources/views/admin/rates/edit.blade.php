@extends('layouts.admin-layout')

@section('content')
<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }
</style>
<div class="page">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="error-message">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>

            <div class="container" style="margin-top: 50px;">
                <div class="card">
                    <h2 class="mb-5 ml-5 mt-5">Edit Rate</h2>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    <div class="form-group package" style="display: none;">
                        <label for="package">Package</label>
                        <select name="package[]" id="package" class="form-control">
                            @foreach($packages as $package)
                            <option value="{{$package->id}}">{{$package->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <form id="frm" action="{{ route('rates.update', $roomrate->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        {{ method_field('PUT') }}

                        @csrf



                        <div class="row">
                            <div class="col-12">
                                @if(!empty($room))
                                  <div class="form-group">
                                    <label for="room">Room</label>
                                    <select name="room" id="room" class="form-control">
                                        <option value="{{$room->id}}" selected>{{$room->name}}</option>
                                       
                                    </select>
                                    @endif
                                @foreach($rates as $ratee)
                                
                                @php
                                
                                $room = App\Models\Room::find($ratee->room_id);
                                $package = App\Models\Package::find($ratee->package_id);
                                $rate = App\Models\Rate::find($ratee->id);
                                $discount_rooms = App\Models\DiscountRoom::where('room_id', $room->id)->get();

                                @endphp
                                   
                                </div>
                                @if(!empty($rate))
                                <div class="form-group">
                                    <label for="start_date">Start date</label>
                                    <input type="date" class="form-control" name="start_date1[]" id="start_date" value="{{$rate->start_date}}" required>
                                </div>

                                <div class="form-group">
                                    <label for="end_date">End date</label>
                                    <input type="date" class="form-control" name="end_date1[]" id="end_date" value="{{$rate->end_date}}" required>
                                </div>

                                <div class="form-group package1">
                                    <label for="package">Package</label>
                                    <select name="package1[]" id="package1" class="form-control">
                                        @foreach($packages as $packagee)
                                        @if($packagee->id == $package->id)
                                        <option value="{{$packagee->id}}" selected>{{$packagee->name}}</option>
                                        @else
                                        <option value="{{$packagee->id}}">{{$packagee->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="">
                                    <label for="">Pricing</label> <br>
                                    <div class="form-group">
                                        <label for="price_per_night1">Price per night (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="price_per_night11[]" id="price_per_night1" value="{{$rate->price_per_night1}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price_per_night2">Price per night (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="price_per_night22[]" id="price_per_night2" value="{{$rate->price_per_night2}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="non_refundable1">Non refundable (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="non_refundable11[]" id="non_refundable1" value="{{$rate->non_refundable1}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="non_refundable2">Non refundable (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="non_refundable22[]" id="non_refundable2" value="{{$rate->non_refundable2}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="modifiable1">Modifiable (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="modifiable11[]" id="modifiable1" value="{{$rate->modifiable1}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="modifiable2">Modifiable (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="modifiable22[]" id="modifiable2" value="{{$rate->modifiable2}}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="prepayment1">Prepayment (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="prepayment11[]" id="prepayment1" value="{{$rate->prepayment1}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="prepayment2">Prepayment (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="prepayment22[]" id="prepayment2" value="{{$rate->prepayment2}}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="no_advance1">No advance (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="no_advance11[]" id="no_advance1" value="{{$rate->no_advance1}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_advance2">No advance (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="no_advance22[]" id="no_advance2" value="{{$rate->no_advance2}}" required>
                                        </div>
                                    </div>
                                    <br><br><br><br><br><br>
                                    @endif
                                    @endforeach


                                    <div class="form-group mt-5">
                                        <button onclick="addDateRange()" id="firstbutton" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add Date Range</button>
                                    </div>

                                </div>

                                <div class="" style="display: none;" id="new">

                                    <div class="form-group mt-5 input_fields_wrap">

                                    </div>
                                </div>





                                <div class="form-group ">
                                    <label for="">Apply Discounts (%)</label><br>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            1. Discount (1 child & 2 adults with age 0-3.99)<br><br><br>
                                            2. Discount (1 child & 2 adults with age 4-11.99)<br><br><br>
                                            3. Discount (1 or 2 child & 1 adults with age 11.99)<br><br><br>
                                            4. Discount (1,2 or 3 child)
                                        </div>
                                        <div class="col-lg-6">

                                            @if(count($discount_rooms) > 0)
                                            @foreach($discount_rooms as $discount_room)
                                            <input type="number" min="1" max="100" value="{{ $discount_room->discount }}" name="discounts[]"><br><br><br>
                                            @endforeach
                                            @else

                                            <input type="number" min="1" max="100" name="discounts[]"><br><br><br>
                                            <input type="number" min="1" max="100" name="discounts[]"><br><br><br>
                                            <input type="number" min="1" max="100" name="discounts[]"><br><br><br>
                                            <input type="number" min="1" max="100" name="discounts[]">
                                            @endif
                                        </div>
                                    </div>


                                </div>


                            </div>




                            <div class="form-group mt-5">
                                <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                            </div>

                        </div>

                </div>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


                @endsection

                <script>
                    function addMoreFields() {
                        var max_fields = 10;
                        var x = 1;
                        var wrapper = $(".input_fields_wrap");
                        if (x < max_fields) {
                            x++;
                            $(wrapper).append('<tr><td><input type="number" min="1" class="form-control" name="min_age[]" id="min_age" required></td><td><input type="number" min="1" class="form-control" name="max_age[]" id="max_age" required></td><td><input type="number" min="1" class="form-control" name="cr_price1[]" id="cr_price1" required></td><td><input type="number" min="1" class="form-control" name="cr_price2[]" id="cr_price2" required></td></tr><br> ');
                        }
                    }
                </script>
