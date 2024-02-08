@extends('layouts.master')
@section('content')
<style>
    th{
        background-color: aliceblue !important;
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Loan Application Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="display: flex;flex-direction: row; justify-content: space-between; margin: 10px">
                            <div></div>
                            <h4 class="card-title text-center" >Loan Application Profile</h4>
                            <div class="btn-group">
                                @if ($loan->level == "initiated")
                                <button class="btn btn-success btn-sm edit-btn" data-uuid="{{ $loan->uuid}}" data-amount ="{{ $loan->amount }}" data-bs-toggle="modal" data-bs-target="#myModal1" > <span class="fa fa-plus"></span> Add Loan</button>
                                @else
                                    <button class="btn btn-success btn-sm" onclick="alert('Loan Application Already Disbursed')" > <span class="fa fa-plus"></span></button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                               <tbody>
                                <tr class="text-center">
                                    <td colspan="2"> <b>Member Kyc</b></td>
                                </tr>
                                <tr>
                                    <th>Member Name</th>
                                    <td>{{ $loan->member?->member_name}}</td>
                                </tr>
                                <tr>
                                    <th>DOB</th>
                                    <td>{{ $loan->member?->dob}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $loan->member?->email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $loan->member?->phone_number}}</td>
                                </tr>
                                <tr>
                                    <th>ID Type</th>
                                    <td>{{ $loan->member?->id_type?->name}}</td>
                                </tr>
                                <tr>
                                    <th>ID Number</th>
                                    <td>{{ $loan->member?->id_number}}</td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="2"><b>Guarantors</b></td>
                                </tr>
                                @foreach ($loan->guarantors as $guarantor)
                                <tr>
                                    <th>{{ $guarantor->member?->member_name }} </th>
                                    <td> {!! $guarantor->status_format !!}  <br>
                                        {{ $guarantor->comment }}
                                     </td>
                                </tr> 
                                @endforeach
                                <tr class="text-center">
                                    <td colspan="2"><b>Loan Application Details</b></td>
                                </tr>
                                <tr>
                                    <th>Loan Status</th>
                                    <td>{!! $loan->status_format !!}</td>
                                </tr>
                                <tr>
                                    <th>Loan Type</th>
                                    <td>{{ $loan->loan_type?->name}}</td>
                                </tr>
                                <tr>
                                    <th>Request Amount</th>
                                    <td>{{ number_format($loan->amount )}}</td>
                                </tr>
                                <tr>
                                    <th>Total Loan Amount</th>
                                    <td>{{ number_format($loan->total_loan_amount )}}</td>
                                </tr>
                                <tr>
                                    <th>Plan</th>
                                    <td>{{ number_format($loan->plan )}}</td>
                                </tr>
                                <tr>
                                    <th>Installment Amount</th>
                                    <td>{{ number_format($loan->installment_amount )}}</td>
                                </tr>
                                <tr>
                                    <th>Interest Amount</th>
                                    <td>{{ number_format($loan->interest_amount )}}</td>
                                </tr>
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
                <h5 class="modal-title" id="myModalLabel">Grant Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <input type="hidden" id="uuid" name="uuid" id="">
                <div class="form-group row">
                    <div class="col-md-12 mt-1">
                        <label for="Name">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Requested loan amount....." required readonly>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Member Account</label>
                        <input type="number" class="form-control" name="bank_account_no" placeholder="Write bank account no....." required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Payment Reference</label>
                        <input type="text" class="form-control" name="payment_reference" placeholder="Write payment reference" required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Payment date</label>
                        <input type="date" class="form-control" max="{{ date('Y-m-d')}}" name="payment_date"  required>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px" id="update_alert">
                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 d-grid">
                            <button class="btn btn-primary waves-effect waves-light"  id="update_btn" type="submit"> <span class="fas fa-save"></span> Grant</button>
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
    $('.edit-btn').on('click',function(){
        var uuid =$(this).attr('data-uuid');
        var amount =$(this).attr('data-amount');
        $('#uuid').val(uuid);
        $('#amount').val(amount);
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
      url:"{{ route('loan.store')}}",
      data : new FormData(this),
      contentType: false,
      cache: false,
      processData : false,
      success:function(response){
        $('#update_alert').html('<div class="alert alert-success">'+response.message+'</div>');
        setTimeout(function(){
         window.location="{{ route('loan.index')}}"
      },500);
      },
      error:function(response){
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
