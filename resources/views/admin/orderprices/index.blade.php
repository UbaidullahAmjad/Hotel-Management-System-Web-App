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
                    <h2>Order Prices</h2>
                </div>
                <!-- <div class="col-6 mb-5">
                    <a href="{{ route('order_prices.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Order Price</a>
                </div> -->


            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

                <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>

                                <th>Order Price Range (€)</th>
                                <th>Order Price Range (TND)</th>
                                <th>CC</th>
                                <th>In Person</th>
                                <th>Bank Transfer</th>
                               


                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($order_prices as $order_price)

                        <tbody>
                            <tr>

                                <td>{{ $order_price->euro_price_1 }} - {{ $order_price->euro_price_2 }}</td>
                                <td>{{ $order_price->tnd_price_1 }} - {{ $order_price->tnd_price_2 }}</td>
                                @if($order_price->cc != 0)
                                <td>Active</td>
                                @else
                                <td>Disable</td>
                                @endif
                                @if($order_price->in_person != 0)
                                <td>Active</td>
                                @else
                                <td>Disable</td>
                                @endif
                                @if($order_price->bank_transfer != 0)
                                <td>Active</td>
                                @else
                                <td>Disable</td>
                                @endif
                                
                                


                                <td>
                                    <a href="{{ route('order_prices.edit',$order_price->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['order_prices.destroy', $order_price->id], 'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline;border:none']) !!}
                {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' => 'btn btn-danger']) !!}

                {{ Form::token() }}
                {!! Form::close() !!}



                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                    </table>

                    {{ $order_prices->links() }}
            </div>
        </div>

        </div>
   </div>
</div>

@endsection