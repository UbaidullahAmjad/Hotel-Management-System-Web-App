@extends('layouts.admin-layout')

@section('content')
<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }
</style>
<div class="page">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="error-message">
                @if($errors->any())
                {{ implode('', $errors->all(':message')) }}
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>

            <div class="container" style="margin-top: 50px;">
                <div class="card">
                    <h2 class="mb-5 ml-5 mt-5">Update Package</h2>

                    <form id="frm" action="{{ route('packages.update',$package->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">

                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Package Name</label>
                                    <input type="text" class="form-control" value="{{ $package->name }}" name="name" id="name" placeholder="Package Name" required>
                                </div>
                                <div class="form-group">
                                <label for="description">Description</label>
                                    <textarea name="detail" required class="form-control" id="description" cols="100" rows="4">{!! html_entity_decode($package->name) !!}</textarea>
                                    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('detail', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                                </div>

                                <div class="form-group">
                                    <label for="active">Active</label>
                                    <select name="active" id="active" class="form-control" required>
                                        @if($package->active == 0)
                                        <option value="0" selected>No</option>
                                        <option value="1">Yes</option>
                                        @else
                                        <option value="0">No</option>
                                        <option value="1" selected>Yes</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="services">Badges</label><br>
                                    <select class="form-control select2" name="badges[]" data-placeholder="Choose Badges" multiple>
                                        @foreach ($badges as $badge)
                                        @php $badge_package = App\Models\BadgePackage::where('package_id',$package->id)
                                        ->where('badge_id',$badge->id)->first();
                                        @endphp
                                        @if(!empty($badge_package))
                                        <option value="{{ $badge->id }}" selected>{{ $badge->text }}</option>
                                        @else
                                        <option value="{{ $badge->id }}">{{ $badge->text }}</option>

                                        @endif
                                        @endforeach


                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="services">Services</label><br>
                                    @foreach($services as $service)
                                    @php
                                    $package_service = App\Models\PackageService::where('package_id',$package->id)
                                    ->where('service_id',$service->id)->first();

                                    @endphp
                                    @if($package_service)
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" onclick="disattachService(<?php echo $service->id; ?>,<?php echo $package->id; ?>)" id="checkedservices" checked><span> &nbsp;{{$service->name}}</span>
                                    @else
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" id="services"><span> &nbsp;{{$service->name}}</span>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="form-group mt-5">
                                    <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                                </div>

                            </div>

                        </div>


                        <script>
                            function disattachService(serv_id, pack_id) {
                                var serv_id = serv_id;
                                var pack_id = pack_id;
                                console.log(serv_id_id);
                                if (document.getElementById('checkedservices').checked == false) {
                                    $.ajax('/removeservice', {
                                        method: 'GET',
                                        dataType: 'json', // type of response data
                                        data: {
                                            serv_id: serv_id,
                                            pack_id: pack_id
                                        },
                                        success: function(data) { // success callback function


                                        },
                                        error: function(data) { // error callback
                                            var errors = data.responseJSON;
                                            console.log('yahan mar raha h');
                                        }
                                    });
                                }
                            }
                        </script>
                        @endsection