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
                    <h2>Discount Prices</h2>
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
                                <th>Name</th>


                                <th># of Kids</th>

                                <th># of Adults</th>
                                <th>Minimum Age</th>
                                <th>Maximum Age</th>
                                <th>Discount (%)</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        @foreach($prices as $price)

                        <tbody>
                            <tr>
                                <td>{{ $price->discount_name }}</td>

                                <td>{{ $price->no_of_kids }}</td>
                                <td>{{ $price->no_of_adults }}</td>
                                <td>{{ $price->min_age }}</td>
                                <td>{{ $price->max_age }}</td>
                                <td>{{ $price->discount }}</td>
                                <td>
                                    <a href="{{ route('prices.edit',$price->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>




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