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
                    <h2 class="mb-5 ml-5 mt-5">Update Badges</h2>

                    <form id="frm" action="{{ route('badges.update',$badge->id) }}" enctype="multipart/form-data" class="mt-5 ml-5" method="POST">
                        @csrf
                        @Method('PUT')

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{$badge->text}}" placeholder="Badge Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Choose Color</label>
                                    <input type="color" id="color" name="color" class="form-control" value="{{ $badge->color }}" required>
                                </div>
                                <div class="form-group mt-5">
                                    <span><button type="submit" id="su" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Save </button></span>&nbsp;&nbsp;
                                </div>

                            </div>

                        </div>

                        @endsection