@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">System Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">System Users List</li>
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
                        <h4 class="card-title text-center" >System Users</h4>
                        <div style="display: flex; flex-direction: row; justify-content:flex-end; padding: 5px 0px 5px 0px">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal"> <span class="fa fa-user-plus font-size-15"></span> Add User </button>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reg Date</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>User Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d ,M-Y H:i:s',strtotime($user->created_at))}}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>
                                          @foreach ($user->roles as $role)
                                                {{ $role->name.' ,' }}
                                          @endforeach
                                        </td>
                                        <td>
                                            @if ($user->status == "Active")
                                            <span class="badge badge-pill badge-soft-success font-size-13">Active</span>
                                            @else
                                            <span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('users.show',$user->uuid)}}">
                                                <button class="btn btn-success btn-sm"> <span class="fa fa-edit"></span></button>
                                            </a>
                                             @if ($user->status == "Active")
                                            <button title="Disable" class="btn btn-warning btn-sm" id="{{ $user->uuid}}" onclick="deactivate_user(id)"><span class="fa fa-times"></span></button>
                                             @else
                                            <button title="Enable" class="btn btn-info btn-sm" id="{{ $user->uuid}}" onclick="enable_user(id)"  ><span class="fa fa-check"></span></button>
                                             @endif
                                            
                                        </td>
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
                <h5 class="modal-title" id="myModalLabel">Register User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="registration_form">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="Name">First name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Write First Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Middle name</label>
                        <input type="text" class="form-control" name="middle_name" placeholder="Write Middle Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Last name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Write Last Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Phone Number</label>
                        <input type="number" class="form-control" name="phone_number" placeholder="Write Phone Number....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Email / Username </label>
                        <input type="text" name="username" class="form-control" placeholder="Write Email / Username ....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">User role </label>
                        <select name="user_role" class="form-select" required>
                            <option value="" selected>Please choose User role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name}}">{{ $role->name }}</option>
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
      url:"{{ route('users.store')}}",
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
      function enable_user(id){
      var csrf_tokken =$('meta[name="csrf-token"]').attr('content');
      swal({
      title: "Activate User",
      text: "Are you sure you want to Activate this User?",
      type: "success",
      showCancelButton: true,
      confirmButtonColor: "#0D6855",
      confirmButtonText: "Yes, Activate",
      closeOnConfirmation: false
    },
    function(){
      $.ajax({
            url: "{{ route('user.status')}}", 
            method: "POST",
            data: {uuid:id,'_token':csrf_tokken,action:'activate'},
            success: function(response)
           { 
           // console.log(response); 
            $.notify(response.message, "success");
            setTimeout(function(){
                location.reload();
            },500);
            },
            error: function(response){
               // console.log(response.responseText);
                $.notify(response.responseJson.errors,'error');  
            }
        });
    }
    );
  }

      function deactivate_user(id){
      var csrf_tokken =$('meta[name="csrf-token"]').attr('content');
      swal({
      title: "Deactivate User",
      text: "Are you sure you want to Deactivate this User?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#0D6855",
      confirmButtonText: "Yes, Deactivate",
      closeOnConfirmation: false
    },
    function(){
      $.ajax({
            url: "{{ route('user.status')}}", 
            method: "POST",
            data: {uuid:id,'_token':csrf_tokken,action:'deactivate'},
            success: function(response)
           { 
           // console.log(response); 
            $.notify(response.message, "success");
            setTimeout(function(){
                location.reload();
            },500);
            },
            error: function(response){
               // console.log(response.responseText);
                $.notify(response.responseJson.errors,'error');  
            }
        });
    }
    );
  }
</script>
    
@endpush