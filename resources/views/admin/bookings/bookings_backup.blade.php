@extends('layouts.admin-layout')

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
                                <th>Booking #</th>
                                <th>Customer</th>
                                <th>Advance Pay (%)</th>
                                <th>Arrival Pay (%)</th>
                                <th>Full Price</th>
                                <th>Status</th>
                                <th>Date From</th>
                                <th>Date To</th>

                                <th>Action</th>



                            </tr>
                        </thead>
                        @foreach($bookings as $booking)
                        @php $user = App\Models\User::find($booking->user_id);
                            $date = date('Y-m-d');
                        @endphp
                        <tbody>
                            <tr>
                                <td>{{ $booking->booking_no }}</td>
                                <td>{{ $user->name }}</td>
                                @if(!empty($booking->arrivalpay) && !empty($booking->advancepay))
                                <td>{{ $booking->arrivalpay }}</td>
                                <td>{{ $booking->advancepay }}</td>
                                <td>N/A</td>
                                @elseif(empty($booking->advancepay) && empty($booking->arrivalpay))
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>{{ $booking->fullprice }}</td>

                                @endif
                                @if($booking->status == "Confirmed")
                                <td><button class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?php echo $booking->id; ?>" id="status<?php echo $booking->id;?>">{{$booking->status}}</button></td>

                                @else
                                <td><button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo $booking->id; ?>" id="status" >{{$booking->status}}</button></td>
                                @endif
                                <td>{{ $booking->booking_date_from }}</td>
                                <td>{{ $booking->booking_date_to }}</td>

                                <td><a href="{{ route('view-booking',$booking->id) }}" style="background-color: #925F0C;border:none" class="btn btn-primary">View</a></td>





                            </tr>
                        </tbody>


                        <div class="modal fade" id="exampleModal<?php echo $booking->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="{{ route('changestatus',$booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Booking Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <label for="">Change Booking Status</label>
                    <select name="bookingstatus" id="bookingstatus" class="form-control">
                        <option value="Confirmed">Confirmed</option>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="changeStatus()">Save changes</button>
            </div>
    </form>

    </div>
  </div>
</div>
                        @endforeach
                    </table>
            </div>
        </div>

        </div>
   </div>
</div>




<script>

function changeStatus(){
    alert(document.getElementById('id').value);
}
</script>
@endsection