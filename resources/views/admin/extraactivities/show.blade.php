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
                            <h2>View Activity</h2>
                        </div>


                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <table id="notificationTable" class="table table-striped table-bordered mt-5">

                        <tr>
                            <th>Image</th>
                            <td><img src="{{ asset('/storage/'. $activity->image) }}" height="100" width="100" alt=""></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td>{{ $activity->title }}</td>
                        </tr>
                       
                        <tr>
                            <th>Description</th>
                            <td>{!! html_entity_decode($activity->description) !!}</td>
                        </tr>
                        <tr>
                            <th>Max People</th>
                            <td>{{ $activity->max_people }}</td>
                        </tr>
                        <tr>
                            <th>Max Children</th>
                            <td>{{ $activity->max_child }}</td>
                        </tr>
                        <tr>
                            <th>Max Adults</th>
                            <td>{{ $activity->max_adults }}</td>
                        </tr>
                        <tr>
                            <th>Price (€)</th>
                            <td>{{ $activity->price1 }}</td>
                        </tr>
                        <tr>
                            <th>Price (TND)</th>
                            <td>{{ $activity->price1 }}</td>
                        </tr>






                    </table>


                </div>
            </div>

        </div>
    </div>
</div>

@endsection
