@extends('layouts.admin-layout')
@section('title', 'All Roles')
@section('content')
<!--App-Content-->
<div class="app-content">
    <div class="side-app">
        {{-- Alert --}}
        <div class="page-header">
            <h4 class="page-title">Discount</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Role</li>
            </ol>
        </div>
        <!--/Page-Header-->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Dicount</div>
                    </div>
                    <div class="col-md-12 text-right pt-2 px-5">
                        <button type="button" data-toggle="modal" class="btn btn-success"
                            data-target="#RoleModalCreate"><i class="fa fa-plus">Add Discount</i></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">#</th>
                                        <th class="wd-20p">3 day</th>
                                        <th class="wd-10p">4 day</th>
                                        <th class="wd-10p">Date From</th>
                                        <th class="wd-15p">Date To</th>
                                        <th class="wd-25p">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($discounts as $discount)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $discount->discount1 }}</td>
                                        <td>{{ $discount->discount2 }}</td>
                                        <td>{{ $discount->datefrom }}</td>
                                        <td>{{ $discount->dateto }}</td>
                                        <td>
                                            <button onclick="editFunction({{ $discount->id }})"
                                                class="btn btn-primary m-1 text-white"><i
                                                    class="fa fa-edit"></i>Edit</button>
                                            <form action="{{ route('admin.discount.destroy',$discount->id) }}"
                                                method="POST" style="display: inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger m-1 text-white"><i
                                                        class="fa fa-trash"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div><!-- table-wrapper -->
                </div><!-- section-wrapper -->
            </div>
        </div>
    </div>
</div>
<!-- /App-Content-->


{{-- Modal Create --}}
<div class="modal" id="RoleModalCreate" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Create Discount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.discount') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-control-label">3 day Discount:</label>
                        <input type="text" class="form-control" placeholder="Role Name..." name="discount1">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">4 day Discount:</label>
                        <input type="text" class="form-control" placeholder="Role Name..." name="discount2">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">From:</label>
                        <input type="date" class="form-control" placeholder="Role Name..." name="datefrom">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">To:</label>
                        <input type="date" class="form-control" placeholder="Role Name..." name="dateto">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success form-control" value="CREATE">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{{-- End Modal create --}}
{{-- Modal edit --}}
<div class="modal" id="RoleModalEdit" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.discount.update','1') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">3 day Discount:</label>
                        <input type="text" class="form-control" id="dis1" placeholder="Role Name..." name="discount1">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">4 day Discount:</label>
                        <input type="text" class="form-control" id="dis2" placeholder="Role Name..." name="discount2">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">From:</label>
                        <input type="date" class="form-control" id="df" placeholder="Role Name..." name="datefrom">
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-control-label">To:</label>
                        <input type="date" class="form-control" id="dt" placeholder="Role Name..." name="dateto">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success form-control" value="UPDATE">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{{-- End Modal edit --}}
<script>
    function editFunction(id){
    var _token= $("input[name=_token]").val();
    $.ajax({
    url : `discount/${id}/edit`,
    type : 'GET',
    data : {_token:_token},
    dataType:'json',
    success : function(data) {
        $('#RoleModalEdit').modal('show');
        $('#dis1').val(data.discount1);
        $('#df').val(data.datefrom);
        $('#dt').val(data.dateto);
        $('#dis2').val(data.discount2);
        $('#id').val(data.id);
    },
    error : function(request,error)
    {
    alert("Request: "+JSON.stringify(request));
    }
    });
}
</script>
@endsection
