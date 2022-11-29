@extends('welcome')

@section('content')

<style>

    @media(max-width: 500px){
        .card{
            padding: 25px !important;
        }

        .margint {
        margin-top: 30px !important;
    }
    }
    .card {
        /* background-color: #a7947a; */
        border-radius: 10px;
        border: 1px solid grey;
        color: black;
    }

    tr th {
        background-color: #a29b91;
        color: white;
    }

    tr td {
        background-color: white;
        color: black;
    }

    h1 h2 h3 h4 h5 h6 {
        color: white !important;
    }

    .padding {
        padding: 15px;
    }

    label {
        color: black;
    }

    .col-lg-6.pay-info label {
        color: white;
    }

    .margint {
        margin-top: 100px;
    }

    .margint1 {
        margin-top: 20px;
    }
</style>
<div class="container">

    <div class="row margint">
        <form action="{{ route('complete-booking') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @php $all_data = session()->get('all_booking_data');

            $data = session()->get('array_data');
            $dat = session()->get('latlong');
            $str="";
            $response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');

$str = $response->json()['features'][0]['properties']['address']['country_code'];

            @endphp
            <div class="col-lg-7 card">
                <h2 class="mt-5 margint1">{{$setting->s_service}}</h2>
                <table class="table">
                    <thead>
                        <tr>
                        @if($str == "tn")
                            <th>{{$setting->s_name}}</th>
                            <th>{{$setting->s_des}}</th>
                            @if($str == "tn")
                            <th>{{ $setting->s_price ." (TND)"}}</th>
                            @else
                            <th>{{$setting->s_price. " (€)"}}</th>
                            @endif
                            <th>{{$setting->s_avail}}</th>
                        @else
                        <th>{{$setting->s_name1}}</th>
                            <th>{{$setting->s_des1}}</th>
                            @if($str == "tn")
                            <th>{{ $setting->s_price1 ." (TND)"}}</th>
                            @else
                            <th>{{$setting->s_price1. " (€)"}}</th>
                            @endif
                            <th>{{$setting->s_avail1}}</th>
                        @endif
                        </tr>
                    </thead>

                    <tbody>

                        @php $serv_array = $all_data['serv_array']; @endphp

                        @if(!empty($serv_array))

                        @for($i = 0 ; $i < count($serv_array); $i++) @php
                            $service=App\Models\Service::find($serv_array[$i]); @endphp <tr>
                            <td>{{$service->name}}</td>
                            <td>{{$service->description}}</td>

                            <td>{{$service->price2}}</td>
                            <td><input type="checkbox" name="avail[]"
                                    onclick="availService(<?php echo $service->id. ','.$service->price2 ?>)"
                                    id="avail<?php echo $service->id ?>"></td>
                            </tr>
                    </tbody>
                    <input type="hidden" id="pricewithservice<?php echo $i; ?>" name="pricewithservice[]"
                        value="{{ $service->price2 }}">


                    @endfor
                    <input type="hidden" name="count" id="count" value="{{ count($serv_array) }}">
                    @endif
                </table>
                <hr>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        @if($str == "tn")
                        <h3>{{ $setting->coupon }}</h3>
                        @if(!empty(session()->get('coupon_name')))
                        <input type="text" id="addcoupon" name="addcoupon" value="{{session()->get('coupon_name')}}"
                            class="form-control mb-5" readonly>

                        @else
                        <input type="text" id="addcoupon" name="addcoupon" class="form-control mb-5">

                        @endif
                        <button id="applycoupon" class=" payment-buttons mt-5" style="margin-top: 10px;" type="button"
                            onclick="applyCoupon()">{{$setting->a_coupon}}</button>
                        <button id="deapplycoupon" class=" payment-buttons mt-5" style="margin-top: 10px;display: none;" type="button"
                            onclick="deapplyCoupon()"  disabled>{{$setting->d_coupon}}</button>
                        @else
                        <h3>{{ $setting->coupon1 }}</h3>
                        @if(!empty(session()->get('coupon_name')))
                        <input type="text" id="addcoupon" name="addcoupon" value="{{session()->get('coupon_name')}}"
                            class="form-control mb-5" readonly>

                        @else
                        <input type="text" id="addcoupon" name="addcoupon" class="form-control mb-5">

                        @endif
                        <button id="applycoupon" class=" payment-buttons mt-5" style="margin-top: 10px;" type="button"
                            onclick="applyCoupon()">{{$setting->a_coupon1}}</button>
                        <button id="deapplycoupon" class=" payment-buttons mt-5" style="margin-top: 10px;display: none;" type="button"
                            onclick="deapplyCoupon()"  disabled>{{$setting->d_coupon1}}</button>
                        @endif
                    </div>
                </div>

                <hr>
            @if($str == "tn")
                @if(auth()->user())
                <div class="row mt-5 padding">
                    <h2>{{ $setting->c_info }}</h2>
                    <div class="col-md-6">
                        <label for="fname">{{$setting->f_name}}</label>
                        <input type="text" name="fname" id="fname" value="{{ auth()->user()->fname }}"  class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lname">{{$setting->l_name}}</label>
                        <input type="text" name="lname" id="lname" value="{{ auth()->user()->lname }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <p id="message" style="color: red;display:none">Email Already Exist</p>
                        </div>
                        <div>
                            <p id="message1" style="color: green;display:none">Email Available</p>
                        </div>
                        <label for="email">{{$setting->email}}</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="form-control" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label for="mobno">{{$setting->mob}}</label>
                        <input type="text" name="mobno" id="mobno" value="{{ auth()->user()->mobno }}" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label for="request">{{$setting->s_req}}</label>
                        <textarea name="request" id="request" cols="40" rows="5" class="form-control">{{ auth()->user()->request }}</textarea>
                    </div>

                </div>

                @else
                <div class="row mt-5 padding">
                    <h2>{{ $setting->c_info }}</h2>
                    <div class="col-md-6">
                        <label for="fname">{{$setting->f_name}}</label>
                        <input type="text" name="fname" id="fname"   class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lname">{{$setting->l_name}}</label>
                        <input type="text" name="lname" id="lname"  class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <p id="message" style="color: red;display:none">Email Already Exist</p>
                        </div>
                        <div>
                            <p id="message1" style="color: green;display:none">Email Available</p>
                        </div>
                        <label for="email">{{$setting->email}}</label>
                        <input type="email" name="email" id="email"  class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="mobno">{{$setting->mob}}</label>
                        <input type="text" name="mobno" id="mobno"  class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label for="request">{{$setting->s_req}}</label>
                        <textarea name="request" id="request" cols="40" rows="5" class="form-control"></textarea>
                    </div>

                </div>
                @endif
            @else

            @if(auth()->user())
                <div class="row mt-5 padding">
                    <h2>{{ $setting->c_info1 }}</h2>
                    <div class="col-md-6">
                        <label for="fname">{{$setting->f_name1}}</label>
                        <input type="text" name="fname" id="fname" value="{{ auth()->user()->fname }}"  class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lname">{{$setting->l_name1}}</label>
                        <input type="text" name="lname" id="lname" value="{{ auth()->user()->lname }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <p id="message" style="color: red;display:none">Email Already Exist</p>
                        </div>
                        <div>
                            <p id="message1" style="color: green;display:none">Email Available</p>
                        </div>
                        <label for="email">{{$setting->email1}}</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="form-control" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label for="mobno">{{$setting->mob1}}</label>
                        <input type="text" name="mobno" id="mobno" value="{{ auth()->user()->mobno }}" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label for="request">{{$setting->s_req1}}</label>
                        <textarea name="request" id="request" cols="40" rows="5" class="form-control">{{ auth()->user()->request }}</textarea>
                    </div>

                </div>

                @else
                <div class="row mt-5 padding">
                    <h2>{{ $setting->c_info1 }}</h2>
                    <div class="col-md-6">
                        <label for="fname">{{$setting->f_name1}}</label>
                        <input type="text" name="fname" id="fname"   class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lname">{{$setting->l_name1}}</label>
                        <input type="text" name="lname" id="lname"  class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <p id="message" style="color: red;display:none">Email Already Exist</p>
                        </div>
                        <div>
                            <p id="message1" style="color: green;display:none">Email Available</p>
                        </div>
                        <label for="email">{{$setting->email1}}</label>
                        <input type="email" name="email" id="email"  class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="mobno">{{$setting->mob1}}</label>
                        <input type="text" name="mobno" id="mobno"  class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label for="request">{{$setting->s_req1}}</label>
                        <textarea name="request" id="request" cols="40" rows="5" class="form-control"></textarea>
                    </div>

                </div>
                @endif
            @endif
                <hr>
                <div class="row mt-5 padding">
                @if($str == "tn")
                    <h2>{{$setting->c_p_method}}</h2>

                    <input type="hidden" id="totalprice" name="totalprice" value="0">
                    @php $result = $all_data['result'];
                    $cc = $all_data['cc'];
                    $bt = $all_data['bt'];
                    $in_person = $all_data['in_person'];
                    @endphp
                    @if($cc->enable == 1)

                    @php $country =
                    App\Models\PMCountry::where('country_code',$str)->where('cc','!=',0)->first();
                    $order_price = App\Models\PMOrderPrice::first();

                    @endphp
                    @if(!empty($country))
                    @if($country->country_code == "TN")

                    <div class="col-md-4">
                        <input type="radio" onclick="methodSelection()" name="paymentmethod" value="paybycreditcard"
                            id="payment1">&nbsp;&nbsp;<span class="">{{$setting->cc}}</span>
                    </div>
                    @else
                    <div class="col-md-4">
                        <input type="radio" onclick="methodSelection()" name="paymentmethod" value="paybycreditcard"
                            id="payment1">&nbsp;&nbsp;<span class="">{{$setting->cc}}</span>
                    </div>
                    @endif
                    @endif


                    @endif



                    @if($bt->enable == 1)
                    @php $country =
                    App\Models\PMCountry::where('country_code',$str)->where('bank_transfer','!=',0)->first();
                    @endphp

                    @if($country)
                    <div class="col-md-4">
                        <input type="radio" onclick="methodSelection()" name="paymentmethod" value="paybybank"
                            id="payment2">&nbsp;&nbsp;<span class="">{{$setting->bt}}</span>
                    </div>

                    @endif
                    @endif







                    @if($in_person->enable == 1)
                    {{-- @dd($str) --}}
                    @php $country =
                    App\Models\PMCountry::where('country_code','TN')->where('in_person','!=',0)->first();
                    @endphp
                    @if($country)
                    <div class="col-md-4">
                        <input type="radio" onclick="methodSelection()" name="paymentmethod" value="payinperson"
                            id="payment3">&nbsp;&nbsp;<span class="">{{$setting->in_person}}</span>
                    </div>

                    @endif
                    @endif


                @else
                <h2>{{$setting->c_p_method1}}</h2>

                        <input type="hidden" id="totalprice" name="totalprice" value="0">
                        @php $result = $all_data['result'];
                        $cc = $all_data['cc'];
                        $bt = $all_data['bt'];
                        $in_person = $all_data['in_person'];
                        @endphp
                        @if($cc->enable == 1)

                        @php $country =
                        App\Models\PMCountry::where('country_code',$str)->where('cc','!=',0)->first();
                        $order_price = App\Models\PMOrderPrice::first();

                        @endphp
                        @if(!empty($country))
                        @if($str == "tn")

                        <div class="col-md-4">
                            <input type="radio" onclick="methodSelection()" name="paymentmethod" value="paybycreditcard"
                                id="payment1">&nbsp;&nbsp;<span class="">{{$setting->cc1}}</span>
                        </div>
                        @else
                        <div class="col-md-4">
                            <input type="radio" onclick="methodSelection()" name="paymentmethod" value="paybycreditcard"
                                id="payment1">&nbsp;&nbsp;<span class="">{{$setting->cc1}}</span>
                        </div>
                        @endif
                        @endif


                        @endif



                        @if($bt->enable == 1)
                        @php $country =
                        App\Models\PMCountry::where('country_code',$str)->where('bank_transfer','!=',0)->first();
                        @endphp

                        @if($country)
                        <div class="col-md-4">
                            <input type="radio" onclick="methodSelection()" name="paymentmethod" value="paybybank"
                                id="payment2">&nbsp;&nbsp;<span class="">{{$setting->bt1}}</span>
                        </div>

                        @endif
                        @endif







                        @if($in_person->enable == 1)
                        {{-- @dd($str) --}}
                        @php $country =
                        App\Models\PMCountry::where('country_code','TN')->where('in_person','!=',0)->first();
                        @endphp
                        @if($country)
                        <div class="col-md-4">
                            <input type="radio" onclick="methodSelection()" name="paymentmethod" value="payinperson"
                                id="payment3">&nbsp;&nbsp;<span class="">{{$setting->in_person1}}</span>
                        </div>

                        @endif
                        @endif
                @endif





                </div>
                @if($str == "tn")
                <div class="mt-5 padding">
                    <input type="checkbox" onclick="isChecked()" id="terms"> &nbsp; {{$setting->term}}<br>
                    <input type="checkbox" onclick="isChecked()" id="policy"> &nbsp; {{$setting->policy}} <br>


                </div>

                @else
                <div class="mt-5 padding">
                    <input type="checkbox" onclick="isChecked()" id="terms"> &nbsp; {{$setting->term1}}<br>
                    <input type="checkbox" onclick="isChecked()" id="policy"> &nbsp; {{$setting->policy1}} <br>


                </div>
                @endif
                <!-- <a class="mt-5 cancel-policy" onclick="openWin()" style="margin-top: 40px;"> Cancellation Policy</a> -->
                @if($str == "tn")
                            <div class="card" style="padding: 10px;">
                                <h2>{{$setting->c_policy}}</h2>
                                @php $policy = App\Models\CancelPolicy::all() @endphp
                                {!! html_entity_decode($policy[0]->policy) !!}
                            </div>
                <div class="row mt-5 padding">
                    <div class="button-style-1">
                        <p class="text-center"><button class="payment-buttons" id="complete-booking" type="submit"
                                disabled>{{$setting->c_book}}</button></p>
                    </div>
                </div>
                @else
                <div class="card" style="padding: 10px;">
                                <h2>{{$setting->c_policy1}}</h2>
                                @php $policy = App\Models\CancelPolicy::all() @endphp
                                {!! html_entity_decode($policy[0]->policy) !!}
                            </div>
                <div class="row mt-5 padding">
                    <div class="button-style-1">
                        <p class="text-center"><button class="payment-buttons" id="complete-booking" type="submit"
                                disabled>{{$setting->c_book1}}</button></p>
                    </div>
                </div>
                @endif

                <input type="hidden" id="room_id" name="room_id" value="{{ $all_data['room_id'] }}">
                @php $package = $all_data['package']; @endphp
                <input type="hidden" id="room_id" name="package_id" value="{{ $package->id }}">

            </div>
            <input type="hidden" name="order_no" id="order_no" value="{{ $all_data['order_no'] }}">
            <input type="hidden" name="noofrooms" id="noofrooms" value="0">
            <div class="col-lg-1"></div>
            <div class="col-lg-4 card" style="background-color: #f2f2f2;">
                <div class="row mt-5 padding">
                    <h2 style="margin-bottom: 33px;">{{$setting->order_sum}}</h2>
                    <p><b>{{ $setting->o_number }}: </b>{{ $all_data['order_no'] }}</p>
                    @if($str == "tn")
                    @if(empty(session()->get('coupon-value')))
                    <p><b>{{$setting->o_price}}: </b> TND <input type="text" size="10"
                            style="color:black;border-radius: 5px;background:transparent;border:none;" id="pricee"
                            name="pricee" value="{{ $all_data['room_price'] }}" readonly> </p>
                    @else
                    <p><b>{{$setting->o_price}}: </b> TND <input type="text" size="10"
                            style="color:black;border-radius: 5px;background:transparent;border:none;" id="pricee"
                            name="pricee" value="{{session()->get('coupon-value') }}" readonly> </p>

                    @endif
                    @else
                    @if(empty(session()->get('coupon-value')))
                    <p><b>{{$setting->o_price1}}:</b> € <input type="text" size="10"
                            style="color:black;border-radius: 5px;background:transparent;border:none;" id="pricee"
                            name="pricee" value="{{ $all_data['room_price'] }}" readonly> </p>
                    @else

                    <p><b>{{$setting->o_price1}}: </b> € <input type="text" size="10"
                            style="color:black;border-radius: 5px;background:transparent;border:none;" id="pricee"
                            name="pricee" value="{{session()->get('coupon-value') }}" readonly> </p>

                    @endif
                    @endif
                    @if($str == "tn")
                    <p><b>{{$setting->d_range}}:</b> {{$data['datefrom']}} {{ $setting->to }} {{$data['dateto']}}</p>
                    @else
                    <p><b>{{$setting->d_range1}}:</b> {{$data['datefrom']}} {{ $setting->to1 }} {{$data['dateto']}}</p>

                    @endif
                </div>
                <input type="hidden" id="tprice" name="tprice" value="">
            </div>
        </form>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$("#email1").focusout(function(){

    var email = document.getElementById('email1').value;
// console.log(email);

    $.ajax('/checkemail',
                {
                    method: 'GET',
                    dataType: 'json', // type of response data
                    data: {"email": email},
                    success: function (data) {   // success callback function
                        console.log('success: '+data);
                        if(data.message == "Email Already Exist"){
                            $('#message').css('display','block');
                            $('#message1').css('display','none');
                        }else{
                            $('#message1').css('display','block');
                            $('#message').css('display','none');
                        }
                        console.log('hi');
                    },
                    error: function (data) { // error callback
                       var errors = data.responseJSON;
                       console.log(errors);
                    }
                });


});


$("#email").focusout(function(){

    var email = document.getElementById('email').value;
// console.log(email);

    $.ajax('/checkemail',
                {
                    method: 'GET',
                    dataType: 'json', // type of response data
                    data: {"email": email},
                    success: function (data) {   // success callback function
                        console.log('success: '+data);
                        if(data.message == "Email Already Exist"){
                            $('#message').css('display','block');
                            $('#message1').css('display','none');
                        }else{
                            $('#message1').css('display','block');
                            $('#message').css('display','none');
                        }
                        console.log('hi');
                    },
                    error: function (data) { // error callback
                       var errors = data.responseJSON;
                       console.log(errors);
                    }
                });


});



</script>

@endsection
