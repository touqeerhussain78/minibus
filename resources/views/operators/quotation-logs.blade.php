@extends('layouts.user')
@section('title','Quotation Logs')
@section('content')

<section class="o-payment p-100 o-operator-quot">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Quotation log</h2>
            </div>
        </div> 
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 d-flex">
                <div class="box yellow w-100">
                    <h3>Your Wallet:</h3>
                    <h4>{{ isset(auth()->user()->quotations) ? auth()->user()->quotations : 0 }} Quotations Left</h4>
                </div>
            </div>
        </div>
    <div class="chart-div">
            <div class="row">
                <div class="col-12 text-center">
                    <h4>Total Quotations: <span>{{$payments[0]->quotations }}</span> </h4>
                </div>
            </div>
        <div class="row d-flex align-items-center">
            <div class="col-12 col-xl-2 text-center">
                <div class="card-header">
                    <h4 class="card-title text-xl-right text-center mb-md-0 mb-2">Quotations</h4>
                </div>
            </div>
            <div class="col-xl-9 col-12">
                <div class="card-content collapse show">
                    <div class="card-body p-0">

                       <canvas id="canvas" height="280" width="600"></canvas>
                    </div>
                    <h5 class="text-center">Months</h5>
                </div>
            </div>
        </div>
        </div>

        <div class="table-responsive">
            <div class="maain-tabble">
                <table class="table table-striped table-bordered zero-configuration border-0">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Quotation Request Sent</th>
                            <th>Quotations Accepted</th>
                            <th>Quotations Rejected</th>  
                            <th>Quotations Cancelled</th>  
                            <th>Quotations Completed</th>  
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                        <td>1</td>
                            <td>{{$payments[0]->sent }}</td>
                            <td>{{$payments[0]->accepted }}</td>
                            <td>{{$payments[0]->rejected }}</td>
                            <td>{{$payments[0]->cancelled }}</td>
                            <td>{{$payments[0]->completed }}</td>

                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</section>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script>
    const d = @json($chartData);

    console.log(d.map( m => m.key ))

    // var barChartData = {
    //     labels: months,
    //     datasets: d.map( v => v.value)
    // };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: d.map( m => m.key ),
                datasets: [{
                    label: '',
                    data: d.map( m => m.value ),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Quotations sent per Month'
                }
            }
        });


    };
</script>
@endsection