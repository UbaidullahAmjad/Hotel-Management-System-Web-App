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
                    <h2>Services</h2>
                </div>


            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <table id="notificationTable" class="table table-striped table-bordered mt-5">

                                <tr>
                                    <th>Service Name</th>
                                    <td>{{ $service->name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{!!  html_entity_decode($service->description) !!}</td>
                                </tr>
                                <tr>
                                    <th>Price (€)</th>
                                    <td>{{ $service->price1 }} €</td>
                                </tr>
                                <tr>
                                    <th>Price (TND)</th>
                                    <td>{{ $service->price2 }} TND</td>
                                </tr>

                                <tr>
                                    <th>Price per Person (€)</th>
                                    <td>{{ $service->person_price1 }} €</td>
                                </tr>
                                <tr>
                                    <th>Price per Person (TND)</th>
                                    <td>{{ $service->person_price2 }}TND</td>
                                </tr>

                                <tr>
                                    <th>Flat Price (€)</th>
                                    <td>{{ $service->flat_price1 }} €</td>
                                </tr>
                                <tr>
                                    <th>Flat (TND)</th>
                                    <td>{{ $service->flat_price2 }} TND</td>
                                </tr>






            </table>


            </div>
        </div>

        </div>
   </div>
</div>

@endsection