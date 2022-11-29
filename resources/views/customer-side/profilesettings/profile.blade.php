@extends('layouts.customer-layout')

@section('content')

<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
    tr th{
        background-color: #a7947a;
        color: white !important;
    }

    .heading{
        background-color: #a7947a;
        color: white;
        padding: 10px;
    }
    .btn-primary:hover{
	background-color: #925F0C !important;
}
</style>

<div class="page" style="margin-top: 100px;">
   <div class="page-main h-100">
		<div class="app-content">
        <div class="container">
            <div class="card">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <h2 class="heading">Update Profile</h2>
                <form action="{{ route('update-profile') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <label for="" class="mt-5">Profile Picture</label><br>
                <img src="{{ asset('/storage/'. auth()->user()->avatar)}}" alt="profile-img" class="avatar avatar-md brround">
                <input type="file" id="profile" class="form-control" name="profile">
                <label for="">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ auth()->user()->name }}">
                <label for="" class="mt-5">Email</label>
                <input type="text" id="email" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly>
                <label for="" class="mt-5">Password</label>
                <input type="password" id="password" class="form-control" name="password">
                <label for="" class="mt-5">Re-Enter Password</label>
                <input type="password" id="repassword" class="form-control" name="repassword">

                <button type="submit" class="btn btn-primary mt-5">Save Profile</button>

                </form>
            </div>
        </div>

        </div>
   </div>
</div>

@endsection