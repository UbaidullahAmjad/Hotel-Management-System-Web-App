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
                            <h2>Countries</h2>
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()"
                        placeholder="Search for names.." title="Type in a name">


                    <table id="notificationTable" class="table table-striped table-bordered mt-5">
                        <thead>
                            <tr>
                                <th>Country Name</th>
                                <th>Country Code</th>
                                <th>CC</th>
                                <th>In Person</th>
                                <th>Bank Transfer</th>
                               


                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($countries as $country)

                        <tbody>
                            <tr>
                                <td>{{ $country->country_name }}</td>
                                <td>{{ $country->country_code }}</td>
                               
                                @if($country->cc != 0)
                                <td>Active</td>
                                @else
                                <td>Disable</td>
                                @endif
                                @if($country->in_person != 0)
                                <td>Active</td>
                                @else
                                <td>Disable</td>
                                @endif
                                @if($country->bank_transfer != 0)
                                <td>Active</td>
                                @else
                                <td>Disable</td>
                                @endif


                                <td>
                                    <a href="{{ route('countries.edit',$country->id) }}" class="btn btn-primary"><i
                                            class="fa fa-edit"></i></a>




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
