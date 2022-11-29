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
            <h2 class="mb-5 ml-5 mt-5">Update Discount Price</h2>

            <form id="frm" action="{{ route('prices.update',$price->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">


            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $price->discount_name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">No of Kids</label>
                        <input type="text" id="noofkids" name="noofkids" class="form-control" value="{{ $price->no_of_kids }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">No of Adults</label>
                        <input type="text" id="no_of_adults" name="no_of_adults" class="form-control" value="{{ $price->no_of_adults }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Minimum Age</label>
                        <input type="text" id="no_of_adults" name="no_of_adults" class="form-control" value="{{ $price->no_of_adults }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Maximum Age</label>
                        <input type="text" id="max_age" name="max_age" class="form-control" value="{{ $price->max_age }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name">Discount (%)</label>
                        <input type="number" min="1" max="100" id="discount" name="discount" class="form-control" value="{{ $price->discount }}">
                    </div>
                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection