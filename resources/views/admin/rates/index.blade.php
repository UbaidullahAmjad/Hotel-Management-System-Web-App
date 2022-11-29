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
                    <div class="row mt-5">
                        <div class="col-6">
                            <h2>Rates</h2>
                        </div>

                        <div class="col-6 mb-5">
                            <a href="{{ route('rates.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Rate</a>
                        </div>

                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>

                                <th>#</th>
                                
                                <th>Room</th>
                                <th>Packages</th>
                                <th>Start Dates</th>
                                <th>End Dates</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $i = 1; @endphp
                        @foreach($rates as $rate)
                        
                        @php
                        $rat = App\Models\Rate::
                        where('rate_id',$rate->id)->first();
                        
                        $rat1 = App\Models\Rate::
                        where('rate_id',$rate->id)->get();
                        if(!empty($rat)){
                            $room = App\Models\Room::find($rat->room_id);
                            
                        }


                        @endphp
                        @if(!empty($rat) && !empty($room))
                        <tbody>

                            <tr>
                                <td>{{$i++}}</td>
                               
                                <td>{{$room->name}}</td>
                                <td>
                                    @foreach($rat1 as $r)
                                    @php $pack = App\Models\Package::find($r->package_id); @endphp
                                    @if(!empty($pack))
                                    <u>{{ $pack->name }}</u><br>
                                    @else
                                     <u>No Package</u><br>
                                    @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($rat1 as $r)
                                    <u>{{ $r->start_date }}</u><br>

                                    @endforeach
                                </td>
                                <td>
                                    @foreach($rat1 as $r)
                                    <u>{{ $r->end_date }}</u><br>

                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{route('rates.edit',$rate->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                    <a href="{{route('rates.destroy',$rate->id)}}" class="btn btn-primary"><i class="fa fa-trash"></i></a>

                                </td>



                            </tr>
                        </tbody>
                        @endif
                        @endforeach
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
