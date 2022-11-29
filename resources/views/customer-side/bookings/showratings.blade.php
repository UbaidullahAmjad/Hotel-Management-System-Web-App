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
            <h2 class="heading">Ratings</h2>
                <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Booking Date</th>
                                <th>Room Name</th>
                                <th>Rating</th>
                                <th>Comments</th>




                            </tr>
                        </thead>
                    @if(!empty($ratings))
                        @foreach($ratings as $rating)
                        @php
                        $j=0;
                        $booking = App\Models\Booking::find($rating->rateable_id);
                        $room = App\Models\Room::find($booking->room_id);

                        @endphp
                        <tbody>
                            <tr>
                                <td>{{$j+1}}</td>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->booking_date_from }} - {{ $booking->booking_date_to }} </td>
                                <td>{{ $room->room_no }}</td>
                                <td>
                                @foreach(range(1,5) as $i)
                                    @if($rating->rating >0)
                                        @if($rating->rating >0.5)
                                            <i class="fa fa-star" style="color: yellow;"></i>
                                        @else
                                            <i class="fa fa-star-half" style="color: yellow;"></i>
                                        @endif
                                    @endif
                                    @php $rating->rating--; @endphp
                                @endforeach
                                </td>
                                <td>{{ $rating->comments}}</td>





                            </tr>
                        </tbody>
                        @endforeach
                        @endif
                    </table>
            </div>
        </div>

        </div>
   </div>
</div>

@endsection