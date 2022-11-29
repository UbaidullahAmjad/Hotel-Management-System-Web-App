@extends('layouts.admin-layout')

@section('content')

<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }
</style>

<div class="page" style="margin-top: 100px;">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="container">
                <div class="card">
                    <div class="row mt-5 ml-5">
                        <div class="col-6">
                            <h2>View Room</h2>
                        </div>


                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-6">
                            <img src="{{asset('/storage/'.$room->image)}}" alt="">
                        </div>
                        <div class="col-lg-6">
                        <table id="notificationTable" class="table table-striped table-bordered mt-5">

                            <tr>
                                <!-- <th>Room Name</th> -->
                                <td>{{ $room->name }}</td>
                            </tr>
                            <tr>
                                <!-- <th>Description</th> -->
                                <td>{!! html_entity_decode($room->description) !!}</td>
                            </tr>
                            <tr>
                                <!-- <th>Number of Rooms</th> -->
                                <td>{{ $room->no_of_rooms }}</td>
                            </tr>
                            <tr>
                                <!-- <th>Active</th> -->
                                <td>{{ $room->active }}</td>
                            </tr>
                            <!-- <tr>
                                <th>Status</th>
                                <td>{{ $room->status }}</td>
                            </tr> -->
                            <tr>
                                <!-- <th>Price (€)</th> -->
                                <td>{{ $room->price1 }}</td>
                            </tr>
                            <tr>
                                <!-- <th>Price (TND)</th> -->
                                <td>{{ $room->price1 }}</td>
                            </tr>
                            <!-- <tr>
                                <th>Capacity</th>
                                <td>{{ $room->capacity }}</td>
                            </tr> -->





                            </table>
                        </div>
                    </div>
                    


                </div>
            </div>

        </div>
    </div>
</div>

@endsection