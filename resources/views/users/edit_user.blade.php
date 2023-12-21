@extends('layouts.master')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">User Detail</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">View</a></li>
                            <li class="breadcrumb-item active">User Detail</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title text-center">User Detail</h4>
                        <hr>
                        <form id="registration_form">
                            <input type="hidden" value="{{ $user->uuid}}" name="user_uuid">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for=""> Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for=""> Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for=""> Email / Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" readonly>
                                </div>
                                
                            </div>
                            <div class="form-group row" style="margin-top: 10px;">
                                <div class="col-md-12">
                                    <label for="">Permissions</label>
                                    <div>
                                        {{-- @foreach ($role->permissions as $assigned_permission) --}}
                                        
                                        @foreach ($permissions as $permission)
                                        
                                        <input type="checkbox" id="vehicle1" name="permissions[]" value="{{ $permission->name }}" {{ ($user->hasPermissionTo($permission->name)) ? "checked": " " }} >
                                        <label for="permission"> {{ $permission->name }}</label> <br>   
                                        @endforeach
                                       
                                        {{-- @endforeach --}}
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group row" style="margin-top: 10px">
                                <div id="alert">

                                </div>
                            </div>
                            <div class="form-group row" style="margin-top: 10px;">
                                <div class="text-center">
                                    <button class="btn btn-primary" type="submit" id="reg_btn"><span class="fa fa-plus"> </span> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end select2 -->

            </div>


        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
    
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
      url:"{{ route('user.update')}}",
      data : new FormData(this),
      contentType: false,
      cache: false,
      processData : false,
      success:function(response){
        console.log(response);
        $('#alert').html('<div class="alert alert-success">'+response.message+'</div>');
        setTimeout(function(){
         window.location.reload();
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
                   $('#reg_btn').html('<i class="fa fa-spinner fa-pulse fa-spin"></i> Submiting .........');
                   $('#reg_btn').attr('disabled', true);
              },
              complete : function(){
                $('#reg_btn').html('<i class="fa fa-plus"></i> Add');
                $('#reg_btn').attr('disabled', false);
              }
      });
  });
  });
</script>
    
@endpush