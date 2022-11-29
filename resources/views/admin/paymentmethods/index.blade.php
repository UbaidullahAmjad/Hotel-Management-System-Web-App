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
                    <h2>Payment Methods</h2>
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
                                <th>#</th>
                                <th>Payment Method</th>


                                <th>Enable</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($payment_methods as $payment_method)

                        <tbody>
                        @php $i=1; @endphp
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $payment_method->payment_method }}</td>

                                @if($payment_method->enable == 0)
                                <td><span class="badge badge-danger">Disabled</span></td>
                                @else
                                <td><span class="badge badge-success">Enabled</span></td>
                                @endif
                                <td>
                                    <a href="{{ route('payment_methods.edit',$payment_method->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>




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