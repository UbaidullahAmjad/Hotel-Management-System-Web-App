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
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
            </div>

            <div class="container" style="margin-top: 50px;">
                <div class="card">
                    <h2 class="mb-5 ml-5 mt-5">Edit Facility</h2>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                    <form id="frm" action="{{ route('facilities.update', $facility->id) }}" enctype="multipart/form-data" class="mt-5 ml-5"
                        method="POST">
                        {{ method_field('PUT') }} 
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="room_no">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{$facility->title}}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="dropify" data-default-file="{{asset('/storage/'.$facility->image)}}" data-height="180" name="image" id="image" />
                                </div>
                               
                                
                        
                                <div class="form-group">
                        <label for="price1">Standard Price (€)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input type="text" class="form-control" value="{{$facility->price1}}"  name="price1" id="price1"  required>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price2">Standard Price (TND)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">TND</span>
                            </div>
                            <input type="text" class="form-control" value="{{$facility->price2}}" name="price2" id="price2"  required>

                        </div>
                    </div>

                                <div class="form-group mt-5">
                                    <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i
                                                class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                                </div>

                            </div>

                        </div>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                      

                        @endsection
