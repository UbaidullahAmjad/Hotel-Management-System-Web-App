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
                    <h2 class="mb-5 ml-5 mt-5">Edit Flat Rate</h2>
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                   
                    <form id="frm" action="{{ route('flatrates.update', $flatrate->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        

                        @csrf



                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="room">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$flatrate->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="room">Discount (%)</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">%</span>
                                        </div>
                                        <input type="number" class="form-control" name="discount" value="{{$flatrate->discount}}" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                
                               

                            </div>




                            <div class="form-group mt-5">
                                <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                            </div>

                        </div>

                </div>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


                @endsection

                <script>
                    function addMoreFields() {
                        var max_fields = 10;
                        var x = 1;
                        var wrapper = $(".input_fields_wrap");
                        if (x < max_fields) {
                            x++;
                            $(wrapper).append('<tr><td><input type="number" min="1" class="form-control" name="min_age[]" id="min_age" required></td><td><input type="number" min="1" class="form-control" name="max_age[]" id="max_age" required></td><td><input type="number" min="1" class="form-control" name="cr_price1[]" id="cr_price1" required></td><td><input type="number" min="1" class="form-control" name="cr_price2[]" id="cr_price2" required></td></tr><br> ');
                        }
                    }
                </script>