@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Permissions</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Permissions List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body ">
                        <h4 class="card-title text-center" >System Permissions</h4>
                        <div style="display: flex; flex-direction: row; justify-content:flex-end; padding: 5px 0px 5px 0px">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal"> <span class="fa fa-plus font-size-15"></span> Add Permission </button>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reg Date</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d ,M-Y H:i:s',strtotime($permission->created_at))}}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->description }}</td>
                                        <td>{{ $permission->permission_category->name }}</td>
                                    </tr>
                                        
                                    @endforeach
                                </tbody>
                               
                            </table>
                        </div>
                       

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>

 <!-- sample modal content -->
 <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Register Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="registration_form">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Write Role Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Description</label>
                        <textarea name="description" class="form-control" placeholder="Write description....." required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="">Permission Category</label>
                        <select name="category" class="form-control" required>
                            <option value="" selected> Permission category</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id}}">{{ $item->name }}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px" id="alert">

                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 d-grid">
                            <button class="btn btn-primary waves-effect waves-light"  id="reg_btn" type="submit"> <span class="fas fa-save"></span> Register</button>
                        </div>
                    </div>

                </div>
               </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <!-- sample modal content -->
 <div id="myModal-1" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="name" id="name"required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Description</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px" id="update_alert">
                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 d-grid">
                            <button class="btn btn-primary waves-effect waves-light"  id="update_btn" type="submit"> <span class="fas fa-edit"></span> Update</button>
                        </div>
                    </div>
                </div>
               </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
@endsection

@push('scripts')

<script>
    $(document).ready(function(){
      $('#registration_form').on('submit',function(e){ 
          e.preventDefault();

      $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
          });
      $.ajax({
      type:'POST',
      url:"{{ route('permissions.store')}}",
      data : new FormData(this),
      contentType: false,
      cache: false,
      processData : false,
      success:function(response){
        console.log(response);
        $('#alert').html('<div class="alert alert-success">'+response.message+'</div>');
        setTimeout(function(){
         location.reload();
      },500);
      },
      error:function(response){
          console.log(response.responseText);
          if (jQuery.type(response.responseJSON.errors) == "object") {
            $('#alert').html('');
          $.each(response.responseJSON.errors,function(key,value){
              $('#alert').append('<div class="alert alert-danger">'+value+'</div>');
          });
          } else {
             $('#alert').html('<div class="alert alert-danger">'+response.responseJSON.errors+'</div>');
          }
      },
      beforeSend : function(){
                   $('#reg_btn').html('<i class="fa fa-spinner fa-pulse fa-spin"></i> Register .........');
                   $('#reg_btn').attr('disabled', true);
              },
              complete : function(){
                $('#reg_btn').html('<i class="fa fa-save"></i> Register');
                $('#reg_btn').attr('disabled', false);
              }
      });
  });
  });
</script>
<script>
    $(document).ready(function(){
      $('#update_form').on('submit',function(e){ 
          e.preventDefault();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        $.ajax({
        type:'POST',
        url:" {{ route('user.update') }}",
        data : new FormData(this),
        contentType: false,
        cache: false,
        processData : false,
        success:function(response){
            $('#update_alert').html('<div class="alert alert-success">'+response.message+'</div>');
        setTimeout(function(){
         window.location.reload();
      },500);
      },
      error:function(response){
          console.log(response.responseText);
          if (jQuery.type(response.responseJSON.errors) == "object") {
            $('#update_alert').html('');
          $.each(response.responseJSON.errors,function(key,value){
              $('#update_alert').append('<div class="alert alert-danger">'+value+'</div>');
          });
          } else {
             $('#update_alert').html('<div class="alert alert-danger">'+response.responseJSON.errors+'</div>');
          }
      },
      beforeSend : function(){
                   $('#update_btn').html('<i class="fa fa-spinner fa-pulse fa-spin"></i> Updating...........');
                   $('#update_btn').attr('disabled', true);
              },
              complete : function(){
                $('#update_btn').html('<i class="fa fa-edit"></i> Update');
                $('#update_btn').attr('disabled', false);
              }
      });
  });
  });
</script>

<script>
    $('.edit-btn').on('click',function(){

        var uuid  =$(this).data('uuid');
        var name  =$(this).data('name');
        var description =$(this).data('description');

        $('#uuid').val(uuid);
        $('#name').val(name);
        $('#description').val(description);

    });
</script>
    
@endpush