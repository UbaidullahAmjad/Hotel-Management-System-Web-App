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
            <h2 class="mb-5 ml-5 mt-5">Update Countries</h2>

            <form id="frm" action="{{ route('countries.update',$country->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">

            @Method('PUT')
            @csrf
            <div class="row">
                <div class="col-12">

                <div class="form-group">
                        <label for="cc">CC</label>
                        <select name="cc" id="cc" class="form-control">

                            <option value="0">Disable</option>
                            <option value="{{ $cc->id }}">Active</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cc">In Person</label>
                        <select name="in_person" id="in_person" class="form-control">

                            <option value="0">Disable</option>
                            <option value="{{ $in_person->id }}">Active</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_transfer">Bank Transfer</label>
                        <select name="bank_transfer" id="bank_transfer" class="form-control">

                            <option value="0">Disable</option>
                            <option value="{{ $bank_transfer->id }}">Active</option>

                        </select>
                    </div>

                






                    <div class="form-group mt-5">
                            <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                    </div>

                </div>

            </div>

@endsection