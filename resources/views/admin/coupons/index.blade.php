@extends('layouts.admin-layout')

@section('content')

<style>

    .card{
        position: inherit !important;
        padding: 14px;
    }
</style>

<div class="page" style="margin-top: 100px;">
   <div class="page-main h-100">
		<div class="app-content">
        <div class="container">
            <div class="card">
            <div class="row mt-5">
                <div class="col-6">
                    <h2>Coupons</h2>
                </div>
                <div class="col-6 mb-5">
                    <a href="{{ route('coupons.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Coupon</a>
                </div>


            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

                <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>Coupon</th>


                                <th>Enable</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($coupons as $coupon)

                        <tbody>
                            <tr>
                                <td>{{ $coupon->coupon }}</td>

                                <td>{{ $coupon->enable }}</td>
                                <td>
                                    <a href="{{ route('coupons.edit',$coupon->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('coupons.delete',$coupon->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>




                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                    </table>
            </div>
        </div>

        </div>
   </div>
</div>

@endsection