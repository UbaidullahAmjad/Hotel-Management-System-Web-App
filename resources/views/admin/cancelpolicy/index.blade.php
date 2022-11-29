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
                    <h2>Cancellation Policy</h2>
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
                                <th>Title</th>
                                <th>Policy</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $i=1; @endphp
                        @foreach($policies as $policy)

                        <tbody>
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $policy->title }}</td>
                                <td>{!! html_entity_decode($policy->policy) !!}</td>



                                <td>
                                    <a href="{{ route('policy.edit',$policy->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>




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