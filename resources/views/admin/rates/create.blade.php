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
                    <h2 class="mb-5 ml-5 mt-5">Add New Rate</h2>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    <form id="frm" action="{{ route('rates.store') }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="room">Room</label>
                                    <select name="room" id="room" class="form-control">
                                        <option value="">{{'-'}}</option>
                                        @foreach($rooms as $room)
                                        @php 
                                        $room_rate = App\Models\RoomRate::join('rates', 'rates.rate_id', 'room_rates.id')
                                                    ->where('room_rates.deleted_at',NULL)
                                                    ->where('rates.room_id',$room->id)->first();
                                        @endphp
                                        @if(empty($room_rate))
                                        <option value="{{$room->id}}">{{$room->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_date">Start date</label>
                                    <input type="date" class="form-control" name="start_date[]" id="start_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="end_date">End date</label>
                                    <input type="date" class="form-control" name="end_date[]" id="end_date" required>
                                </div>

                                <div class="form-group package">
                                    <label for="package">Package</label>
                                    <select name="package[]" id="package" class="form-control">
                                        <option value="">{{'-'}}</option>
                                        @foreach($packages as $package)
                                        <option value="{{$package->id}}">{{$package->name}}</option>
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
                                            <input type="number" min="1" class="form-control" name="price_per_night1[]" id="price_per_night1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price_per_night1">Price per night (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="price_per_night2[]" id="price_per_night1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="non_refundable1">Non refundable (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="non_refundable1[]" id="non_refundable1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="non_refundable2">Non refundable (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="non_refundable2[]" id="non_refundable2" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="modifiable1">Modifiable (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="modifiable1[]" id="modifiable1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="modifiable2">Modifiable (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="modifiable2[]" id="modifiable2" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="prepayment1">Prepayment (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="prepayment1[]" id="prepayment1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="prepayment2">Prepayment (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="prepayment2[]" id="prepayment2" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="no_advance1">No advance (€)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">€</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="no_advance1[]" id="no_advance1" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_advance2">No advance (TND)</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">TND</span>
                                            </div>
                                            <input type="number" min="1" class="form-control" name="no_advance2[]" id="no_advance2" required>
                                        </div>
                                    </div>

                                    <div class="form-group mt-5">
                                        <button onclick="addDateRange1()" id="firstbutton" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add Date Range</button>
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
                                            <input type="number" min="1" max="100" name="discounts[]"><br><br><br>
                                            <input type="number" min="1" max="100" name="discounts[]"><br><br><br>
                                            <input type="number" min="1" max="100" name="discounts[]"><br><br><br>
                                            <input type="number" min="1" max="100" name="discounts[]">
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
                            // function feature(){
                            //     $($('#slot_template').html()).appendTo('#active_slots')
                            //     }
                        </script>
