@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Loan Profile</h4>

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
                            <h4 class="card-title text-center" >Loan Contract Profile</h4>
                            <div class="btn-group">
                                @if (Auth::user()->member_id == $loan->member?->id)
                                <button type="button" class="btn btn-info">Actions</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myModal1"> <i class="fa fa-plus"></i> Add Repayment</a>
                                </div>     
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
                                    <th>Guarantor {{ $loop->iteration }} </th>
                                    <td>{{ $guarantor->member?->member_name }}</td>
                                </tr> 
                                @endforeach
                               </tbody>
                            </table>
                        </div>

                        <div class="col-md-12" style="padding: 2px  20px  2px 20px">
                            <h4 class="card-title text-center"> Details</h4>
    
                              <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active rounded-5" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-tab-pane" type="button" role="tab" aria-selected="true"> <span class="nav-text">Loan Details</span> </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link rounded-5" id="repayment-tab" data-bs-toggle="tab" type="button" data-bs-target="#repayment-tab-pane" role="tab" aria-selected="false"> <span class="nav-text">Repayment Schedule</span> </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link rounded-5" id="attachment-tab" data-bs-toggle="tab" data-bs-target="#attachment-tab-pane"  type="button" role="tab" aria-selected="false"><span class="nav-text">Repayments</span></button>
                                </li>
                              </ul>
                              <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="payment-tab-pane" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
                                    <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                        <h4 class="card-title text-center">Loan Details</h4>
                                        <div class="table-responsive">
                                          <table class="table table-bordered dt-responsive ">
                                            <tbody>
                                                <tr>
                                                    <th>Loan Type</th>
                                                    <td>{{ $loan->loan_type?->name }}</td>
                                                    <th>Status</th>
                                                    <td>{!! $loan->status_format !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>Start Date</th>
                                                    <td>{{ ($loan->start_date ) }}</td>
                                                    <th>End Date</th>
                                                    <td>{{ ($loan->expected_end_date ) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Amount</th>
                                                    <td>{{ number_format($loan->total_amount)}}</td>
                                                    <th>Total Loan Amount</th>
                                                    <td>{{ number_format($loan->total_loan_amount)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Plan</th>
                                                    <td>{{ number_format($loan->plan)}}</td>
                                                    <th>Installment Amount</th>
                                                    <td>{{ number_format($loan->installment_amount)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Interest Amount</th>
                                                    <td>{{ number_format($loan->interest_amount)}}</td>
                                                    <th>Interest Rate</th>
                                                    <td>{{ ($loan->interest_rate)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Paid In</th>
                                                    <td>{{ number_format($loan->current_balance)}}</td>
                                                    <th>Outstanding Amount</th>
                                                    <td>{{ number_format($loan->outstanding_amount)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Past Due Days </th>
                                                    <td>{{ number_format($loan->past_due_days)}}</td>
                                                    <th>Past Due Amount</th>
                                                    <td>{{ number_format($loan->past_due_amount)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Penalt Amount </th>
                                                    <td>{{ number_format($loan->penalt_amount)}}</td>
                                                    <th>Penalt Amount Paid</th>
                                                    <td>{{ number_format($loan->penalt_amount_paid)}}</td>
                                                </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="repayment-tab-pane" role="tabpanel" aria-labelledby="repayment-tab" tabindex="0">
                                    <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                        <h4 class="card-title text-center">Repayment Schedule</h4>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Payment Date</th>
                                                        <th>Installment Amount</th>
                                                        <th>Paid Amount</th>
                                                        <th>Outstanding Amount</th> 
                                                        <th>PDD</th>
                                                        <th>Penalt</th>
                                                        <th>Status</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($loan->installments as $installment)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ date('d, M-Y',strtotime($installment->payment_date ))}}</td>
                                                        <td>{{ number_format($installment->installment_amount) }}</td> 
                                                        <td>{{ number_format($installment->current_balance) }}</td> 
                                                        <td>{{ number_format($installment->outstanding_amount) }}</td> 
                                                        <td>{{ $installment->past_due_days }}</td> 
                                                        <td>PA ={{ number_format($installment->penalt_amount) }} 
                                                            <br>PAP ={{ number_format($installment->penalt_amount_paid)}}
                                                         </td> 
                                                        <td>{!! $installment->status_format !!}</td> 
                                                    </tr>
                                                    @endforeach
                                                 </tbody> 
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="attachment-tab-pane" role="tabpanel" aria-labelledby="attachment-tab" tabindex="0">
                                    <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Payment Date</th>
                                                    <th>Payment Reference</th>
                                                    <th>Amount</th>
                                                    <th>Payment Type</th>
                                                  </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($loan->payments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y',strtotime($payment->payment_date ))}}</td>
                                                    <td>{{ $payment->payment_reference }}</td> 
                                                    <td>{{ number_format($payment->amount) }}</td> 
                                                    <td>{{ $payment->payment_type }}</td> 
                                                </tr>
                                                @endforeach
                                             </tbody> 
                                           
                                        </table>
                                    </div>
                                </div>
                              </div>
    
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
                <h5 class="modal-title" id="myModalLabel">Add Repayment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <input type="hidden"  name="loan_id" value="{{ $loan->id }}">
                <input type="hidden"  name="member_id" value="{{ $loan->member?->id }}">
                <input type="hidden"  name="payment_type" value="loan">
                <div class="form-group row">
                    <div class="col-md-12 mt-1">
                        <label for="Name">Amount Paid</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Paid amount....." required >
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Payment Reference</label>
                        <input type="text" class="form-control" name="payment_reference" placeholder="Write payment reference" required>
                    </div>
                    <div class="col-md-12">
                        <label for="Name">Payment date</label>
                        <input type="date" class="form-control" name="payment_date" max="{{ date('Y-m-d')}}" required>
                    </div>
                    <div class="col-md-12" style="margin-top: 5px" id="update_alert">
                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 d-grid">
                            <button class="btn btn-primary waves-effect waves-light"  id="update_btn" type="submit"> <span class="fas fa-save"></span> Submit</button>
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
        $('#datatable1').DataTable();
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
      url:"{{ route('payment.request')}}",
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
