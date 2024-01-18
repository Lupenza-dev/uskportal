@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Loan Application Request</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Loan Application Request List</li>
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
                        <h4 class="card-title text-center" >Loan Application Request</h4>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Total Loan </th>
                                    <th>Installment </th>
                                    <th>Plan </th>
                                    <th>Interest </th>
                                    <th>Loan Type </th>
                                    <th>Request Status</th>
                                    <th>Loan Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d ,M-Y H:i:s',strtotime($request->loan->created_at))}}</td>
                                        <td>{{ $request->loan->member->member_name }}</td>
                                        <td>{{ number_format($request->loan->amount) }}</td>
                                        <td>{{ number_format($request->loan->total_loan_amount) }}</td>
                                        <td>{{ number_format($request->loan->installment_amount) }}</td>
                                        <td>{{ number_format($request->loan->plan) }}</td>
                                        <td>{{ number_format($request->loan->interest_amount) }}</td>
                                        <td>{{ $request->loan->loan_type->name ?? "N/A"}}</td>
                                        <td>{!! $request->status_format !!}
                                            <br>
                                            {{ $request->comment}}
                                        </td>
                                        <td>{!! $request->loan->status_format !!} 
                                          
                                        </td>
                                        <td>
                                            @if ($request->loan->level == "initiated")
                                            <button class="btn btn-success btn-sm" id="{{ $request->uuid }}" onclick="approveApplication(id)" > <span class="fa fa-check"></span></button>
                                            <button class="btn btn-warning btn-sm edit-btn" data-uuid="{{ $request->uuid}}"  data-bs-toggle="modal" data-bs-target="#myModal1" > <span class="fa fa-times"></span></button>
                                            @else
                                            <button class="btn btn-success btn-sm edit-btn" onclick="alert('Loan Application Already Disbursed')" > <span class="fa fa-info"></span></button>
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
 <div id="myModal1" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <input type="text" id="uuid" name="uuid" id="">
                <input type="hidden" id="action" name="action" value="reject">
                <div class="form-group row">
                    <div class="col-md-12 mt-1">
                        <label for="Name">Comment</label>
                        <textarea name="comment" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px" id="update_alert">
                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 d-grid">
                            <button class="btn btn-warning waves-effect waves-light"  id="update_btn" type="submit"> <span class="fas fa-times"></span> Reject</button>
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
function approveApplication(id){
      var csrf_tokken =$('meta[name="csrf-token"]').attr('content');
      swal({
      title: "Approve Application",
      text: "Are you sure you want to Approve this Application?",
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#0D6855",
      confirmButtonText: "Yes, Approve",
      closeOnConfirmation: false
    },
    function(){
      $.ajax({
            url: "{{ route('loan.request')}}", 
            method: "POST",
            data: {uuid:id,'_token':csrf_tokken,action:'approve'},
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
<script>
    $('.edit-btn').on('click',function(){
        var uuid =$(this).attr('data-uuid');
        $('#uuid').val(uuid);
    })
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
      url:"{{ route('loan.request')}}",
      data : new FormData(this),
      contentType: false,
      cache: false,
      processData : false,
      success:function(response){
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
                $('#update_btn').html('<i class="fa fa-save"></i> Grant');
                $('#update_btn').attr('disabled', false);
              }
      });
  });
  });
</script>

    
@endpush
