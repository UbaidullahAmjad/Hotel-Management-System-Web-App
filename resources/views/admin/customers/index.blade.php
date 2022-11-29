@extends('layouts.admin-layout')

@section('content')

<style>
    .card {
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
                            <h2>Customers</h2>
                        </div>
                        <div class="col-6 mb-5">
                            <a href="{{ route('customers.create') }}" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Customer</a>
                        </div>

                    </div>
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <script>
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">


                    <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>#</th>

                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <!-- <th>Price per person per night (€)</th> -->

                                <th>Action</th>

                            </tr>
                        </thead>
                        @php $i=1;@endphp
                        @if(!empty($customers))
                        @foreach($customers as $customer)
                        @if(!$customer->hasRole('Admin'))
                        <tbody>
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>

                                <td>{{ $customer->mobno }}</td>
                                <td>
                                    
                                    <label class="badge badge-success">{{ $customer->roles[0]->name }}</label>
                                    
                                </td>


                                <td>
                                    <a href="{{ route('customers.edit',$customer->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('customers.show',$customer->id) }}" style="background:orange" class="btn"><i class="fa fa-eye text-white"></i></a>

                                    {!! Form::open(['method' => 'DELETE','route' => ['customers.destroy', $customer->id],
                                    'onsubmit' => 'return ConfirmDelete()','style'=>'display:inline']) !!}
                                    {!! Form::button('<a class="fa fa-trash-o"></a>', ['type' => 'submit','class' =>
                                    'btn btn-danger']) !!}

                                    {{ Form::token() }}
                                    {!! Form::close() !!}

                                </td>



                            </tr>
                        </tbody>
                        @endif
                        @endforeach
                       
                        @endif
                    </table>
                    {{$customers->links()}}
                </div>
                
            </div>

        </div>
    </div>
</div>


@endsection