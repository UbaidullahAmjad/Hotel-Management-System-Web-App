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
                    <h2>Seasons</h2>
                </div>
                <div class="col-6 mb-5">
                    <a href="{{ route('seasons.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Order Price</a>
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


                                <th>Season</th>
                                <th>CC</th>
                                <th>In Person</th>
                                <th>Bank Transfer</th>
                                <th>% UpFront</th>
                                <th>% Arrival</th>


                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($seasons as $season)

                        <tbody>
                            <tr>

                                <td>{{ $season->date1 }} - {{ $season->date2 }}</td>


                                <td>{{ $season->cc }}</td>
                                <td>{{ $season->in_person }}</td>
                                <td>{{ $season->bank_transfer }}</td>
                                <td>{{ $season->percentage_upfront }}</td>
                                <td>{{ $season->percentage_arrival }}</td>


                                <td>
                                    <a href="{{ route('seasons.edit',$season->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['seasons.destroy', $season->id], 'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline;border:none']) !!}
                {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' => 'btn btn-danger']) !!}

                {{ Form::token() }}
                {!! Form::close() !!}



                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                    </table>

                    {{ $seasons->links() }}
            </div>
        </div>

        </div>
   </div>
</div>

@endsection