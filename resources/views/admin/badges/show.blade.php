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
                            <h2> View Package</h2>
                        </div>


                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    @php $pack_services = App\Models\PackageService::where('package_id',$package->id)->get();

                    @endphp
                    <table id="notificationTable" class="table table-striped table-bordered mt-5">

                        <tr>
                            <th>Name</th>
                            <td>{{ $package->name }}</td>
                        </tr>

                        <tr>
                            <th>Services</th>
                            @if(!empty($pack_services))

                            <td>
                                @foreach ($pack_services as $pack_service)
                                @php
                                $service = App\Models\Service::find($pack_service->service_id);
                                @endphp
                                {{ $service->name }},
                                @endforeach
                            </td>

                            @else
                            <td>No service available</td>
                            @endif
                        </tr>







                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection