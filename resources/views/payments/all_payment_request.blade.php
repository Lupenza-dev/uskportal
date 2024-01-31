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
                                        <td>{!! $payment->status_format !!}</td>
                                        @if (in_array(Auth::user()->id,[1,4,8]))
                                        <td>
                                            <button class="btn btn-primary btn-sm" id="{{ $payment->id}}" onclick="approvePayment(id)" title="Approve"><i class="fa fa-check"></i></button>
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
    
@endpush
