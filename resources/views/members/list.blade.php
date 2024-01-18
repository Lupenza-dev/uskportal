@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Members</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Members List</li>
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
                        <h4 class="card-title text-center" >Members</h4>
                        <div style="display: flex; flex-direction: row; justify-content:flex-end; padding: 5px 0px 5px 0px">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal"> <span class="fa fa-user-plus font-size-15"></span> Add Member</button>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reg No</th>
                                    <th>Reg Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->member_reg_id }}</td>
                                        <td>{{ date('d ,M-Y H:i:s',strtotime($member->created_at))}}</td>
                                        <td>{{ $member->first_name.' '.$member->last_name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->phone_number }}</td>
                                        <td>
                                            @if ($member->status == "Active")
                                            <span class="badge badge-pill badge-soft-success font-size-13">Active</span>
                                            @else
                                            <span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-success btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-uuid="{{ $member->uuid}}"
                                            data-first_name="{{ $member->first_name}}"
                                            data-middle_name="{{ $member->middle_name}}"
                                            data-last_name="{{ $member->last_name}}"
                                            data-dob="{{ $member->dob}}"
                                            data-id_type="{{ $member->id_type_id}}"
                                            data-id_number="{{ $member->id_number}}"
                                            data-phone_number="{{ $member->phone_number}}"
                                            data-email="{{ $member->email}}"
                                            > <span class="fa fa-edit"></span></button>
                                             {{-- @if ($member->status == "Active")
                                            <button title="Disable" class="btn btn-warning btn-sm" id="{{ $member->uuid}}" onclick="deactivate_user(id)"><span class="fa fa-times"></span></button>
                                             @else
                                            <button title="Enable" class="btn btn-info btn-sm" id="{{ $member->uuid}}" onclick="enable_user(id)"  ><span class="fa fa-check"></span></button>
                                             @endif --}}
                                             <a href="{{ route('members.show',$member->uuid)}}">
                                              <button title="Profile" class="btn btn-info btn-sm"  ><span class="fa fa-user"></span></button>
                                            </a>
                                            
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
                <h5 class="modal-title" id="myModalLabel">Register Member</h5>
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
                        <label for="Name">DOB</label>
                        <input type="date" class="form-control" max="2000-01-01" name="dob" required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">ID Type</label>
                        <select name="id_type_id" class="form-control">
                            <option value="" selected> Choose ID Type</option>
                            @foreach ($id_types as $item)
                                <option value="{{ $item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">ID Number</label>
                        <input type="number" class="form-control" name="id_number" placeholder="Write Id Number......." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Phone Number</label>
                        <input type="number" class="form-control" name="phone_number" placeholder="Write Phone Number (255*****)....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Email  </label>
                        <input type="email" name="email" class="form-control" placeholder="Write Email ....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Member Type</label>
                        <select name="member_type" id="member_type" class="form-control" required>
                            <option value="" selected> Choose Member Type</option>
                            <option value="1">Original Member</option>
                            <option value="2">Refered Member</option>
                        </select>
                    </div>
                    <div class="col-md-12" id="guarantor_member_div" style="display: none">
                        <label for="Name">Guarantor Member</label>
                        <select name="guarantor_member" id="guarantor_member"  class="form-control">
                            <option value="" selected> Choose Member</option>
                            @foreach ($members as $item)
                                <option value="{{ $item->id}}">{{ $item->member_name }}</option>
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
 <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Member Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <input type="hidden" name="uuid" id="uuid" >
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="Name">First name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Write First Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Middle name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Write Middle Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Last name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Write Last Name....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">DOB</label>
                        <input type="date" class="form-control" id="dob" max="2000-01-01" name="dob" required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">ID Type</label>
                        <select name="id_type_id" id="id_type" class="form-control">
                            <option value="" selected> Choose ID Type</option>
                            @foreach ($id_types as $item)
                                <option value="{{ $item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">ID Number</label>
                        <input type="number" id="id_number" class="form-control" name="id_number" placeholder="Write Id Number......." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Phone Number</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Write Phone Number (255*****)....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Email  </label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Write Email ....." readonly>
                    </div>
                    
                    <div class="col-md-12" style="margin-top: 5px" id="update_alert">
                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 d-grid">
                            <button class="btn btn-primary waves-effect waves-light"  id="update_btn" type="submit"> <span class="fas fa-save"></span> Update</button>
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
      url:"{{ route('members.store')}}",
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
                   $('#reg_btn').html('<i class="fa fa-spinner fa-pulse fa-spin"></i> loading..........');
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
    $('.edit-btn').on('click',function(){
        $('#uuid').val($(this).data('uuid'));
        $('#first_name').val($(this).data('first_name'));
        $('#middle_name').val($(this).data('middle_name'));
        $('#last_name').val($(this).data('last_name'));
        $('#dob').val($(this).data('dob'));
        $('#id_type').val($(this).data('id_type'));
        $('#id_number').val($(this).data('id_number'));
        $('#phone_number').val($(this).data('phone_number'));
        $('#email').val($(this).data('email'));
    })

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
      url:"{{ route('update.member')}}",
      data : new FormData(this),
      contentType: false,
      cache: false,
      processData : false,
      success:function(response){
        console.log(response);
        $('#update_alert').html('<div class="alert alert-success">'+response.message+'</div>');
        setTimeout(function(){
         location.reload();
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
                   $('#update_btn').html('<i class="fa fa-spinner fa-pulse fa-spin"></i> loading..........');
                   $('#update_btn').attr('disabled', true);
              },
              complete : function(){
                $('#update_btn').html('<i class="fa fa-save"></i> Update');
                $('#update_btn').attr('disabled', false);
              }
      });
  });
  });

  $('#member_type').on('change',function(){
    var type =$(this).val();
    if (type == 2) {
        $('#guarantor_member_div').show();
        $('#guarantor_member').attr('required',true);
    } else {
        $('#guarantor_member_div').hide();
        $('#guarantor_member').attr('required',false );

    }

  });
</script>
    
@endpush
