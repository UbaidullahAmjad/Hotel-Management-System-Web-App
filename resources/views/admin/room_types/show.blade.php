@extends('layouts.admin-layout')

@section('content')

<style>

    .card{
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
                    <h2>View Room Type</h2>
                </div>


            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table id="notificationTable" class="table table-striped table-bordered mt-5">

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $room_type->name }}</td>
                                </tr>
                                <tr>
                                    <th>Active</th>
                                    <td>{{ $room_type->active }}</td>
                                </tr>

            </table>


            </div>
        </div>

        </div>
   </div>
</div>

@endsection