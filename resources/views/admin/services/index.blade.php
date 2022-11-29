@extends('layouts.admin-layout')

@section('content')

<style>
    .card {
        position: inherit !important;
        padding: 14px;
    }

    .fa .fa-eye{
        color:white !important;
    }
</style>

<div class="page" style="margin-top: 100px;">
    <div class="page-main h-100">
        <div class="app-content">
            <div class="container">
                <div class="card">
                    <div class="row mt-5">
                        <div class="col-6">
                            <h2>Services</h2>
                        </div>
                        <div class="col-6 mb-5">
                            <a href="{{ route('services.create') }}" class="btn btn-success float-right"><i
                                    class="fa fa-plus"></i> Add Service</a>
                        </div>

                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

                    <script>
                        $(document).ready( function () {
                            $('#notificationTable').DataTable();
                        } );
                        function myFunction() {
                                      // Declare variables
                                      var input, filter, table, tr, td, i, txtValue;
                                      input = document.getElementById("myInput");
                                      filter = input.value.toUpperCase();
                                      table = document.getElementById("notificationTable");
                                      tr = table.getElementsByTagName("tr");

                                      // Loop through all table rows, and hide those who don't match the search query
                                      for (i = 0; i < tr.length; i++) {
                                        td = tr[i].getElementsByTagName("td")[0];
                                        if (td) {
                                          txtValue = td.textContent || td.innerText;
                                          if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                            tr[i].style.display = "";
                                          } else {
                                            tr[i].style.display = "none";
                                          }
                                        }
                                      }
                                    }
                    </script>
                    <!-- <input type="text" id="myInput" class="form-control" onkeyup="myFunction()"
                        placeholder="Search for names.." title="Type in a name"> -->
                    <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Name</th>
                                <th>Price Per Person Per Night</th>
                                <th>Price Per Person Per Night</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $i=1; @endphp
                        @if(!empty($services))
                        @foreach($services as $service)

                        <tbody>
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $service->name }}</td>

                                <td>€ {{ $service->price1 }}</td>
                                <td>TND {{ $service->price2 }}</td>

                                <td>
                                    <a href="{{ route('services.edit',$service->id) }}" class="btn btn-primary"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route('services.show',$service->id) }}"
                                        style="background-color: orange;" class="btn"><i class="fa fa-eye"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['services.destroy', $service->id],
                                    'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline']) !!}
                                    {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' =>
                                    'btn btn-danger']) !!}

                                    {{ Form::token() }}
                                    {!! Form::close() !!}

                                </td>



                            </tr>
                        </tbody>
                        @endforeach
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
