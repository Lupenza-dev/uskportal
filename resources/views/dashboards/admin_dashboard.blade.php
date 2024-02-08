@extends('layouts.master')
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Members</p>
                                            <h4 class="mb-0">{{ $members}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-user font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Fee</p>
                                            <h4 class="mb-0">{{ number_format($member_savings->sum('fees'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Stock</p>
                                            <h4 class="mb-0">{{ number_format($member_savings->sum('stock'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-data font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Expected Balance</p>
                                            <h4 class="mb-0">0</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Stock Penalty</p>
                                            <h4 class="mb-0">{{ number_format($stock->sum('penalty'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Stock Penalty Paid</p>
                                            <h4 class="mb-0">{{ number_format($stock->sum('penalty_paid'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Fee penalty</p>
                                            <h4 class="mb-0">{{ number_format($fee->sum('penalty'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Fee Penalty Paid</p>
                                            <h4 class="mb-0">{{ number_format($fee->sum('penalty_paid'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">No of Loans</p>
                                            <h4 class="mb-0">{{ number_format($loans->count())}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Loan Size</p>
                                            <h4 class="mb-0">{{ number_format($loans->sum('total_loan_amount'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Total Paid</p>
                                            <h4 class="mb-0">{{ number_format($loans->sum('current_balance'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Outstanding</p>
                                            <h4 class="mb-0">{{ number_format($loans->sum('outstanding_amount'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Loan Penalty</p>
                                            <h4 class="mb-0">{{ number_format($installments->sum('penalt_amount') + $installments->sum('penalt_amount_paid'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Penalty Paid</p>
                                            <h4 class="mb-0">{{ number_format($installments->sum('penalt_amount_paid'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Expected Interest</p>
                                            <h4 class="mb-0">{{ number_format($loans->sum('interest_amount'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Collected Interest</p>
                                            <h4 class="mb-0">{{ number_format($loans->where('status','CLOSED')->sum('interest_amount'))}}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-money font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                   
                </div>
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Chart of Stock Purchase Vs Loan Disbursed {{ date('Y')}}</h4>
                            
                            <div id="column_chart" data-colors='["--bs-success","--bs-primary", "--bs-danger"]' class="apex-charts" dir="ltr"></div>                                      
                        </div>
                    </div><!--end card-->
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Granted Vs Closed Vs Past Due Loans</h4>
                            
                            <div id="pie_chart" data-colors='["--bs-success","--bs-primary", "--bs-danger","--bs-info", "--bs-warning"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    
@endsection
@push('scripts')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>


<!-- apexcharts init -->
{{-- <script src="{{ asset('assets/js/pages/apexcharts.init.js')}}"></script> --}}
<script>
    $(document).ready(function(){
        pieChart(); 
        
        var promise=  ajaxCall().done(function(response) {
            columChart(response.stock,response.loan); 
        }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error(errorThrown);
        });
    })
</script>

<script>
    
    function getChartColorsArray(e) {
        if (null !== document.getElementById(e)) {
            var t = document.getElementById(e).getAttribute("data-colors");
            if (t)
                return (t = JSON.parse(t)).map(function (e) {
                    var t = e.replace(" ", "");
                    if (-1 === t.indexOf(",")) {
                        var r = getComputedStyle(document.documentElement).getPropertyValue(t);
                        return r || t;
                    }
                    var o = e.split(",");
                    return 2 != o.length ? t : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(o[0]) + "," + o[1] + ")";
                });
            console.warn("data-colors Attribute not found on:", e);
        }
    }

    function columChart(stock,loan){
        var columnChartColors = getChartColorsArray("column_chart");
        columnChartColors &&
        ((options = {
            chart: { height: 350, type: "bar", toolbar: { show: !1 } },
            plotOptions: { bar: { horizontal: !1, columnWidth: "45%", endingShape: "rounded" } },
            dataLabels: { enabled: !1 },
            stroke: { show: !0, width: 2, colors: ["transparent"] },
            series: [
                { name: "Stock Purchased", data: JSON.parse(stock)},
                { name: "Loan Disbursed", data: JSON.parse(loan)}
            ],
            colors: columnChartColors,
            xaxis: { categories: ["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"] },
            yaxis: { title: { text: "Tsh", style: { fontWeight: "500" } } },
            labels: {
               formatter: function (value) {
                   return formatNumber(value);
               }
            },
            grid: { borderColor: "#f1f1f1" },
            fill: { opacity: 1 },
            tooltip: {
                y: {
                    formatter: function (e) {
                        return  $.number(e);
                    },
                },
            },
        }),
        (chart = new ApexCharts(document.querySelector("#column_chart"), options)).render());

    }

    function pieChart(){
        var open_loan     =@json($loans->where('status','GRANTED')->count());
        var closed_loan   =@json($loans->where('status','CLOSED')->count());
        var past_loan  =@json($loans->where('status','PAST')->count());

        var pieChartColors = getChartColorsArray("pie_chart");
        pieChartColors &&
        ((options = {
            chart: { height: 320, type: "pie" },
            series: [open_loan, closed_loan, past_loan],
            labels: ["Granted Loans", "Closed Loans", "Past Due Loans"],
            colors: pieChartColors,
            legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0 },
            responsive: [{ breakpoint: 600, options: { chart: { height: 350 }, legend: { show: !1 } } }],
        }),
        (chart = new ApexCharts(document.querySelector("#pie_chart"), options)).render());

    }


    function ajaxCall() { 
        return $.ajax({
            type:'GET',
            url:" {{ route('column.chart') }}",
            contentType: false,
            cache: false,
            processData : false,
            success:function(response){
                // Handle the response inside the success function if needed
            },
            error:function(response){
                console.log(response.responseText);
            },
            beforeSend : function(){
               
            },
            complete : function(){
              }
        }); 
    }

    function formatNumber(number) {
        const suffixes = ['', 'k', 'M', 'B', 'T']; // Add more suffixes as needed
        const suffixNum = Math.floor(('' + number).length / 3);
        let shortNumber = parseFloat((suffixNum !== 0 ? (number / Math.pow(1000, suffixNum)) : number).toPrecision(3));
        if (shortNumber % 1 !== 0) {
            shortNumber = shortNumber.toFixed(1);
        }
        return shortNumber + suffixes[suffixNum];
    }

   

    
</script>
    
@endpush