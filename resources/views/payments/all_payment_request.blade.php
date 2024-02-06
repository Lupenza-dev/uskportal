@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Payment Requests</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Payment List</li>
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
                        <h4 class="card-title text-center" >All Payment Requests</h4>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Member</th>
                                        <th>Phone Number</th>
                                        <th>Payment Date</th>
                                        <th>Payment Reference</th>
                                        <th>Amount</th>
                                        <th>Payment Type</th>
                                        <th>Payment For Month</th>
                                        <th>Status</th>
                                        @if (in_array(Auth::user()->id,[1,4,8]))
                                        <th>Action</th>
                                        @endif
                                      </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->member?->member_name}}</td>
                                        <td>{{ $payment->member?->phone_number}}</td>
                                        <td>{{ date('d-m-Y',strtotime($payment->payment_date ))}}</td>
                                        <td>{{ $payment->payment_reference }}</td> 
                                        <td>{{ number_format($payment->amount) }}</td> 
                                        <td>{{ $payment->payment_type }}</td> 
                                        <td>{{ $payment->payment_for_month }}</td> 
                                        <td>{!! $payment->status_format !!} <br>
                                            {{ $payment->comment}}

                                        </td>
                                        @if (in_array(Auth::user()->id,[1,4,8]))
                                        <td>
                                            <button class="btn btn-primary btn-sm" id="{{ $payment->id}}" onclick="approvePayment(id)" title="Approve"><i class="fa fa-check"></i></button>
                                            <button class="btn btn-warning btn-sm edit-btn" data-uuid="{{ $payment->id}}"  data-bs-toggle="modal" data-bs-target="#myModal1" > <span class="fa fa-times"></span></button>

                                        </td>   
                                        @endif
                                       
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
                <h5 class="modal-title" id="myModalLabel">Reject Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <input type="hidden" id="uuid" name="uuid" id="">
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
    function approvePayment(id){
      var csrf_tokken =$('meta[name="csrf-token"]').attr('content');
      swal({
      title: "Approve Payment",
      text: "Are you sure you want to Approve this Payment?",
      type: "success",
      showCancelButton: true,
      confirmButtonColor: "#0D6855",
      confirmButtonText: "Yes, Approve",
      closeOnConfirmation: false
    },
    function(){
      $.ajax({
            url: "{{ route('approve.payment')}}", 
            method: "POST",
            data: {id:id,'_token':csrf_tokken,action:'activate'},
            success: function(response)
           { 
            console.log(response);
            $.notify(response.message, "success");
            setTimeout(function(){
                location.reload();
            },500);
            },
            error: function(response){
               // console.log(response.responseText);
                $.notify(response.responseJSON.errors,'error');  

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
      url:"{{ route('reject.payment.request')}}",
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
          setTimeout(function(){
                location.reload();
        },500);
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
