@extends('layouts.master')
@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Disbursed Payment</h4>

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
                        <h4 class="card-title text-center" >All Disbursed Payment</h4>
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
                                        <th>Bank Account</th>
                                        <th>Loan Code</th>
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
                                        <td>{{ $payment->bank_account_no }}</td> 
                                        <td>{{ $payment->loan?->contract_code }}</td>
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
