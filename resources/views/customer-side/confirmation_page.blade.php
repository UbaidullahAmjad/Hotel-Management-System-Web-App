@extends('welcome')

@section('content')
<style>
    .card {
        background-color: #f2f2f2;
        padding: 26px;
        color: black;
    }

    h2 {
        color: black;
    }

    .padding {
        padding: 15px;
    }

    label {
        color: black;
    }

    .margint {
        margin-top: 100px;
    }

    .line {
        border-bottom: 2px solid cadetblue;
        color: cadetblue;
        font-size: 17px;
    }

    .invoice-title h2,
    .invoice-title h3 {
        display: inline-block;
    }

    .table>tbody>tr>.no-line {
        border-top: none;
    }

    .table>thead>tr>.no-line {
        border-bottom: none;
    }

    .table>tbody>tr>.thick-line {
        border-top: 2px solid;
    }
</style>






<div class="container">
<button class="btn btn-primary mt-5 mb-5" style="margin: 10px;" onclick="printDiv()" ><i class="fa fa-print"></i>imprimer </button>
<button class="btn btn-success mt-5 mb-5" onclick="goBack()"><i class=""></i>Retourner </button>


@php
$dat = session()->get('latlong');
$response = Http::get('https://nominatim.openstreetmap.org/reverse?format=geojson&lat=36.7394816&lon=10.2039552');
    $str = $response->json()['features'][0]['properties']['address']['country_code'];
@endphp
</div>

<div class="container card" id="printdiv">
    <div class="row">
        <div class="col-xs-12">
        @if($str == "tn")
            <div class="invoice-title">
                <h2>{{$setting->invoice}}</h2>
                <h3 class="pull-right">{{$setting->ordr}} # {{ $booking->booking_no }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>

                        <strong>{{$setting->u_info}}</strong><br>
                        {{ auth()->user()->name }}<br>

                        {{$setting->u_email}} {{ auth()->user()->email }}<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
    				<address>
        			<strong>{{$setting->frm}}</strong>
    					{{ $booking->booking_date_from }}<br>
    					<strong>{{$setting->too}}</strong>
    					{{ $booking->booking_date_to }}<br>
    				</address>
    			</div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>{{$setting->p_m}}</strong><br>
                        {{$method}}<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>{{$setting->o_date}}</strong><br>
                        {{ date('Y-m-d')  }}<br><br>
                    </address>
                </div>
            </div>
            @else
            <div class="invoice-title">
                <h2>{{$setting->invoice1}}</h2>
                <h3 class="pull-right">{{$setting->ordr1}} # {{ $booking->booking_no }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>

                        <strong>{{$setting->u_info1}}</strong><br>
                        {{ auth()->user()->name }}<br>

                        {{$setting->u_email1}} {{ auth()->user()->email }}<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
    				<address>
        			<strong>{{$setting->frm1}}</strong>
    					{{ $booking->booking_date_from }}<br>
    					<strong>{{$setting->too1}}</strong>
    					{{ $booking->booking_date_to }}<br>
    				</address>
    			</div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>{{$setting->p_m1}}</strong><br>
                        {{$method}}<br>

                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>{{$setting->o_date1}}</strong><br>
                        {{ date('Y-m-d')
                          }}<br><br>
                    </address>
                </div>
            </div>

            @endif
        </div>
    </div>
    @php
                                    $key = 'bdELPYQYzlqCYrKewn0cwN9tTOjxXvVK';

                                    $qualityScore = new IPQualityScore\IPQualityScore($key);
                                    $ip_address = \Request::ip();
                                    $result1 = $qualityScore->IPAddressVerification->getResponse($ip_address);
                                    // dd($result1);
                                    $result =$result1->data;
                                    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                @if($str == "tn")
                    <h3 class="panel-title"><strong>{{$setting->o_sum}}</strong></h3>
                    @else
                    <h3 class="panel-title"><strong>{{$setting->o_sum1}}</strong></h3>

                    @endif
                </div>
                <div style="padding: 31px;">
                @if($str == "tn")
                    <b>{{$setting->total}} </b>{{ $Total_price }} TND<br>
                    <b>{{$setting->tax}} </b>{{ $tax }} TND<br>
                    <b>{{$setting->t_amount}} </b>{{ $tax + $Total_price }} TND<br>
                @else
                    <b>{{$setting->total1}} </b>{{ $Total_price }} €<br>
                    <b>{{$setting->tax1}} </b>{{ $tax }} €<br>
                    <b>{{$setting->t_amount1}} </b>{{ $tax + $Total_price }} €<br>
                @endif


                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    @php $data = session()->get('array_data'); @endphp
                                    <!-- <td><strong>Item</strong></td> -->
                                    @if($str == "tn")
                                    <td class="text-center"><strong>{{$setting->price}}</strong></td>
                                    <td class="text-center"><strong>{{$setting->a_pay}}</strong></td>
                                    <td class="text-center"><strong>{{$setting->p_on_arival}}</strong></td>
                                    <td class="text-center"><strong>{{$setting->adult}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->child1}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->child2}}</strong></td>

                                    @else
                                    <td class="text-center"><strong>{{$setting->price1}}</strong></td>
                                    <td class="text-center"><strong>{{$setting->a_pay1}}</strong></td>
                                    <td class="text-center"><strong>{{$setting->p_on_arival1}}</strong></td>
                                    <td class="text-center"><strong>{{$setting->adult1}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->child11}}</strong></td>
                                    <td class="text-right"><strong>{{$setting->child22}}</strong></td>
                                    @endif


                                </tr>
                            </thead>
                            <tbody>
                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                <tr>
                                    <!-- <td>BS-200</td> -->

                                    @if($str == "tn")
                                    <td class="text-center">{{ $booking->price }} TND</td>
                                    @else
                                    <td class="text-center">{{ $booking->price }} €</td>
                                    @endif
                                @if($method != "Pay on Arrival")
                                    @if($booking->advancepay != null)
                                    <td class="text-center">{{ $booking->advancepay }} %</td>
                                    @else
                                    <td class="text-center">0 %</td>

                                    @endif
                                    @if($booking->arrivalpay != null)
                                    <td class="text-center">{{ $booking->arrivalpay }} %</td>
                                    @else
                                    <td class="text-center">0 %</td>
                                    @endif
                                @else
                                <td class="text-center">0 %</td>
                                    <td class="text-center">100 %</td>
                                @endif


                                    <td class="text-center">{{ $data['adults'] }}</td>
                                    <td class="text-right">{{ $data['kid1'] }}</td>
                                    <td class="text-right">{{ $data['kid2'] }}</td>

                                </tr>
                                <!-- <tr>
        							<td>BS-400</td>
    								<td class="text-center">$20.00</td>
    								<td class="text-center">3</td>
    								<td class="text-right">$60.00</td>
    							</tr>
                                <tr>
            						<td>BS-1000</td>
    								<td class="text-center">$600.00</td>
    								<td class="text-center">1</td>
    								<td class="text-right">$600.00</td>
    							</tr>
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">$670.99</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">$15</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">$685.99</td>
    							</tr> -->
                            </tbody>
                        </table>

                        @if(isset($details))
                        @php $detail = explode("<p>Re",$details->details); @endphp

                            <p>{!! html_entity_decode($detail[0]) !!}
                            Reference No: {{ $booking->booking_no }}
                            </p>
                            @endif
                            <hr>
                            <input type="hidden" is="pass" value="{{ $password }}">
                            @if($str == "tn")
                            <div class="card">
                                <h1>{{$setting->c_policy}}</h1>
                                @php $policy = App\Models\CancelPolicy::all() @endphp
                                {!! html_entity_decode($policy[0]->policy) !!}
                            </div>
                            <p style="margin-top: 28px">{{ $setting->thank_msg }}</p>
                            @else
                            <div class="card">
                                <h1>{{$setting->c_policy1}}</h1>
                                @php $policy = App\Models\CancelPolicy::all() @endphp
                                {!! html_entity_decode($policy[0]->policy) !!}
                            </div>
                            <p style="margin-top: 28px">{{ $setting->thank_msg1 }}</p>
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
function printDiv() {
            var divContents = document.getElementById("printdiv").innerHTML;
            var a = window.open('', '');
            a.document.write('<html>');
            a.document.write('<body >');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }

function goBack(){
    window.location.href = '/';
}

</script>

@endsection
