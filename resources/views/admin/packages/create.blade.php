@extends('layouts.admin-layout')

@section('content')
<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }

    #price {
        border: 1px solid lightgrey;
        font-weight: 400;
        font-size: 16px;
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
                    <h2 class="mb-5 ml-5 mt-5">Add New Package</h2>

                    <form id="frm" action="{{ route('packages.store') }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Package Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Package Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="detail" required class="form-control" id="description" cols="100" rows="4"></textarea>
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

                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="services">Badges</label><br>
                                    <select class="form-control select2" name="badges[]" data-placeholder="Choose Badges" multiple>
                                        @foreach ($badges as $badge)
                                        <option value="{{ $badge->id }}" style="background-color: red;color:white">{{ $badge->text }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="services">Services</label><br>
                                    @foreach($services as $service)
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" id="services"><span> &nbsp;{{$service->name}}</span>
                                    @endforeach
                                </div>



                                <div class="form-group mt-5">
                                    <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                                </div>

                            </div>

                        </div>

                        @endsection