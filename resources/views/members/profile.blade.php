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
                    <h4 class="mb-sm-0 font-size-18">Member Profile</h4>

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
                            <h4 class="card-title text-center" >Member Profile</h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info">Actions</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#myModal1"> <i class="fa fa-plus"></i> Add Payment</a>
                                </div>
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
                                    <td>{{ $member->member_name}}</td>
                                </tr>
                                <tr>
                                    <th>DOB</th>
                                    <td>{{ $member->dob}}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $member->email}}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $member->phone_number}}</td>
                                </tr>
                                <tr>
                                    <th>ID Type</th>
                                    <td>{{ $member->id_type?->name}}</td>
                                </tr>
                                <tr>
                                    <th>ID Number</th>
                                    <td>{{ $member->id_number}}</td>
                                </tr>
                                <tr>
                                    <th>Member Type</th>
                                    <td>{{ $member->member_types}}</td>
                                </tr>
                                @if ($member->member_refered)
                                   <tr>
                                    <th>Guarantor Member</th>
                                    <td>{{ $member->member_refered->member?->member_name}}</td>
                                </tr> 
                                @endif
                               </tbody>
                            </table>
                        </div>

                        <div class="col-md-12" style="padding: 2px  20px  2px 20px">
                            <h4 class="card-title text-center"> Details</h4>
    
                              <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active rounded-5" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-tab-pane" type="button" role="tab" aria-selected="true"> <span class="nav-text">Member Summary</span> </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link rounded-5" id="repayment-tab" data-bs-toggle="tab" type="button" data-bs-target="#repayment-tab-pane" role="tab" aria-selected="false"> <span class="nav-text">Payments (Stock)</span> </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link rounded-5" id="attachment-tab" data-bs-toggle="tab" data-bs-target="#attachment-tab-pane"  type="button" role="tab" aria-selected="false"><span class="nav-text">Payments (Fees)</span></button>
                                </li>
                              </ul>
                              <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="payment-tab-pane" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
                                    <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                        <h4 class="card-title text-center">Member Summary</h4>
                                        <div class="table-responsive">
                                          <table class="table table-bordered dt-responsive ">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center" colspan="4"><h5>Stock Summary</h5></td>
                                                </tr>
                                                <tr>
                                                    <th>Total Stock</th>
                                                    <td>{{ number_format($member->member_saving?->stock)}}</td>
                                                    <th>Last Purchase Stock</th>
                                                    <td>{{ number_format($member->member_saving?->last_stock_amount)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last Purchase Date</th>
                                                    <td>{{ $member->member_saving?->last_purchase_date}}</td>
                                                    <th>Stock Due Days</th>
                                                    <td>{{ $member->member_saving?->past_due_days}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Stock Penalty</th>
                                                    <td>{{ number_format($member->member_saving?->stock_penalty)}}</td>
                                                    <th>Stock for Month</th>
                                                    <td>{{ $member->member_saving?->stock_for_month}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center" colspan="4"><h5>Fee Summary</h5></td>
                                                </tr>
                                                <tr>
                                                    <th>Total Fee</th>
                                                    <td>{{ number_format($member->member_saving?->fees)}}</td>
                                                    <th>Last Fee Paid</th>
                                                    <td>{{ number_format($member->member_saving?->last_fee_amount)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last Fee Paid Date</th>
                                                    <td>{{ $member->member_saving?->last_fee_purchase_date}}</td>
                                                    <th>Fee Due Days</th>
                                                    <td>{{ $member->member_saving?->fee_past_due_days}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fee Penalty</th>
                                                    <td>{{ number_format($member->member_saving?->fee_penalty)}}</td>
                                                    <th>Fee for Month</th>
                                                    <td>{{ $member->member_saving?->fee_for_month}}</td>
                                                </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="repayment-tab-pane" role="tabpanel" aria-labelledby="repayment-tab" tabindex="0">
                                    <div class="col-md-12" style="padding: 10px 2px 10px 2px">
                                        <h4 class="card-title text-center">Stock Payment History</h4>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-bordered dt-responsive  nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Payment Date</th>
                                                        <th>Payment Reference</th>
                                                        <th>Amount</th>
                                                        <th>Payment Type</th>
                                                        <th>Payment For Month</th>
                                                      </tr>
                                                </thead>
                                                 <tbody>
                                                @foreach ($member->stock_payments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y',strtotime($payment->payment_date ))}}</td>
                                                    <td>{{ $payment->payment_reference }}</td> 
                                                    <td>{{ number_format($payment->amount) }}</td> 
                                                    <td>{{ $payment->payment_type }}</td> 
                                                    <td>{{ $payment->payment_for_month }}</td> 
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
                                                    <th>Payment For Month</th>
                                                  </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member->fee_payments as $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d-m-Y',strtotime($payment->payment_date ))}}</td>
                                                    <td>{{ $payment->payment_reference }}</td> 
                                                    <td>{{ number_format($payment->amount) }}</td> 
                                                    <td>{{ $payment->payment_type }}</td> 
                                                    <td>{{ $payment->payment_for_month }}</td> 
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
                <h5 class="modal-title" id="myModalLabel">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="update_form">
                <input type="hidden" name="member_id" value="{{ $member->id }}" id="">
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
                    <div class="col-md-12">
                        <label for="">Payment Type</label>
                        <select name="payment_type" class="form-control" required>
                            <option value="" selected>choose payment type</option>
                            <option value="stock">Stock Payment</option>
                            <option value="fee">Fee Payment</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>Payment for Month </label>
                        <div class="position-relative" id="datepicker4">
                            <input type="text" name="payment_for_month" class="form-control" data-date-container='#datepicker4' data-provide="datepicker"
                            data-date-format="MM yyyy" data-date-min-view-mode="1" required>
                        </div>
                        
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
                $('#update_btn').html('<i class="fa fa-save"></i> Submit');
                $('#update_btn').attr('disabled', false);
              }
      });
  });
  });
</script>
    
@endpush
