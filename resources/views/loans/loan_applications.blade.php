@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Loan Application</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">List</a></li>
                            <li class="breadcrumb-item active">Loan Application List</li>
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
                        <h4 class="card-title text-center" >Loan Application</h4>
                        <div style="display: flex; flex-direction: row; justify-content:flex-end; padding: 5px 0px 5px 0px">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal"> <span class="fa fa-plus font-size-15"></span> Add Application</button>
                        </div>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ date('d ,M-Y H:i:s',strtotime($loan->created_at))}}</td>
                                        <td>{{ $loan->member->first_name.' '.$loan->member->last_name }}</td>
                                        <td>{{ number_format($loan->amount) }}</td>
                                        <td>{{ number_format($loan->total_loan_amount) }}</td>
                                        <td>{{ number_format($loan->installment_amount) }}</td>
                                        <td>{{ number_format($loan->plan) }}</td>
                                        <td>{{ number_format($loan->interest_amount) }}</td>
                                        <td>{{ $loan->loan_type->name ?? "N/A"}}</td>
                                        <td>{!! $loan->status_format !!}</td>
                                        <td>
                                            @if ($loan->level == "initiated")
                                              <button class="btn btn-success btn-sm edit-btn" data-uuid="{{ $loan->uuid}}" data-amount ="{{ $loan->amount }}" data-bs-toggle="modal" data-bs-target="#myModal1" > <span class="fa fa-edit"></span></button>
                                            @else
                                              <button class="btn btn-success btn-sm edit-btn" onclick="alert('Loan Application Already Disbursed')" > <span class="fa fa-edit"></span></button>
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
                <h5 class="modal-title" id="myModalLabel">Loan Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="registration_form">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="Name">Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Requested loan amount....." required>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="Name">Loan Type</label>
                        <select name="loan_type" id="loan_type" class="form-control">
                            <option value="" selected> Loan Type</option>
                            @foreach ($loan_types as $item)
                                <option value="{{ $item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-1" id="plan" style="display: none">
                        <label for="Name">Plan</label>
                        <input type="number" class="form-control" name="plan" placeholder="Repayment plan.....">
                    </div>
                     <div class="col-md-12 mt-1">
                        <label for="">Guarantors</label>
                        <div>
                            @foreach ($members as $member)
                            <input type="checkbox" id="vehicle1" name="guarantors[]" value="{{ $member->id }}">
                            <label for="member"> {{ $member->first_name.' '.$member->last_name }}</label> <br>
                            @endforeach
                        </div>
                    </div> 
                    <div class="col-md-12 mt-1" style="margin-top: 5px" id="alert">
                    </div>
                    <div class="col-md-12 mt-1">
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
      url:"{{ route('applications.store')}}",
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
<script>
    $('#loan_type').on('change',function(){
        var value =$(this).val();

        if (value == 2) {
            $('#plan').show();
        } else {
            $('#plan').hide();
        }
    })
</script>
    
@endpush
