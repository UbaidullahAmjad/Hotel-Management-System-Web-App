@extends('layouts.admin-layout')

@section('content')

<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }

    .color {
        height: 50px;
        width: 50px;
    }
</style>

<div class="page" style="margin-top: 100px;">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="container">
                <div class="card">
                    <div class="row mt-5">
                        <div class="col-6">
                            <h2>Badges</h2>
                        </div>
                        <div class="col-6 mb-5">
                            <a href="{{ route('badges.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Badge</a>
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
                                <th>Text</th>


                                <th>Color</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $i=1; @endphp
                        @if(count($badges) > 0)
                        @foreach($badges as $badge)

                        <tbody>
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$badge->text}}</td>
                                <td><input type="color" value="{{$badge->color}}" size="2" readonly disabled></td>
                                <td>
                                    <a href="{{ route('badges.edit',$badge->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['badges.destroy', $badge->id], 'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline']) !!}
                                    {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' => 'btn btn-danger']) !!}

                                    {{ Form::token() }}
                                    {!! Form::close() !!}

                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                        @else
                        <tr>
                            <p style="color:red" class="text-center">No Record</p>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection