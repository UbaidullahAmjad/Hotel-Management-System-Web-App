@extends('layouts.admin-layout')

@section('content')
<style>

    .card{
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
            <h2 class="mb-5 ml-5 mt-5">Add New Service</h2>

            <form id="frm" action="{{ route('services.store') }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Servive Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" required class="form-control" id="description" cols="100" rows="4"></textarea>
                                    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

                                    <script>
                                        CKEDITOR.replace('description', {
                                            filebrowserUploadUrl: "",
                                            filebrowserUploadMethod: 'form'
                                        });
                                    </script>
                    </div>

                    <div class="form-group">
                        <label for="price1">Price per person per night (€)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input type="number" class="form-control" name="price1" id="price1"  required>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price2">Price per person per night (TND)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">TND</span>
                            </div>
                            <input type="number" class="form-control" name="price2" id="price2"  required>

                        </div>
                    </div>


                    <div class="form-group">
                        <label for="price1">Price per person (€)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input type="number" class="form-control" name="person_price1" id="p1"  required>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price2">Price per person (TND)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">TND</span>
                            </div>
                            <input type="number" class="form-control" name="person_price2" id="p2"  required>

                        </div>
                    </div>


                    <div class="form-group">
                        <label for="price1">Flat Rate (€)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">€</span>
                            </div>
                            <input type="number" class="form-control" name="flat_price1" id="f1"  required>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price2">Flat Rate (TND)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">TND</span>
                            </div>
                            <input type="number" class="form-control" name="flat_price2" id="f2"  required>

                        </div>
                    </div>


                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection