@extends('layouts.customer-layout')

@section('content')

<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
    tr th{
        background-color: #a7947a;
        color: white !important;
    }

    .heading{
        background-color: #a7947a;
        color: white;
        padding: 10px;
    }
    .btn-primary:hover{
	background-color: #925F0C !important;
}
</style>

<div class="page" style="margin-top: 100px;">
   <div class="page-main h-100">
		<div class="app-content">
        <div class="container">
            <div class="card">
            <div class="row mt-5 ml-5">



            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <h2 class="heading">Bookings</h2>
                <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Room</th>
                                <th>Package</th>
                                <th>Room Price</th>
                                <th>Activity</th>




                            </tr>
                        </thead>
                        @foreach($bookings as $booking)
                        @php
                                $r_data = App\Models\RoomData::where('booking_no',$booking->booking_no)
                                                            ->where('user_id',auth()->user()->id)->get();
                                $r_s_data = App\Models\RoomServiceData::where('booking_no',$booking->booking_no)
                                                            ->where('user_id',auth()->user()->id)->get();
                                $r_a_data = App\Models\RoomActivityData::where('booking_no',$booking->booking_no)
                                                            ->where('user_id',auth()->user()->id)->get();
                                                            $k = 1;
                            @endphp
                        <tbody>
                            <tr>
                                    <h3>Booking#: {{$booking->booking_no}}</h3>
                                </tr>
                            
                            @for($i = 0;$i < count($r_data); $i++)
                                    @php $package = App\Models\Package::find($r_data[$i]->package_id); @endphp
                                    <tr>
                                        <td>{{$k++}}</td>
                                        <td><img src="{{asset('storage/'.$r_data[$i]->image)}}" alt="" height="100" width="100"></td>
                                        <td>{{$r_data[$i]->room_name}}</td>
                                        <td>{{$package->name}}</td>
                                        
                                        <td>{{$r_data[$i]->price}}</td>
                                        <td>{{$r_a_data[$i]->title}}</td>
                                        

                                    </tr>
                                @endfor
                                


                                
                                
                                <td><a href="{{ route('customer-view-booking',$booking->id) }}" style="background-color: #925F0C;border:none" class="btn btn-primary">View</a></td>





                            </tr>
                        </tbody>
                        @endforeach
                    </table>
            </div>
        </div>

        </div>
   </div>
</div>


</script>

@endsection