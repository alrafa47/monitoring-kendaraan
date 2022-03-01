@extends('layout.index')
@section('title', 'Dashboard Admin')
@section('content')

    <!-- Small boxes (Stat box) -->
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title ">
                            <span>
                                <i class="fas fa-chart-pie mr-1"></i>
                                Penggunaan Kendaraan Perbulan
                            </span>
                        </h3>
                        <div class="d-flex justify-content-end ">
                            <select id="year" class="form-control mr-1">
                                @foreach ($years as $year)
                                    <option value="{{ $year->year }}"
                                        {{ now()->format('Y') == $year->year ? 'selected' : '' }}>{{ $year->year }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="btn-group">
                                <button type="button" onclick="exportexcel()" class="btn btn-success text-nowrap">Export
                                    Excel</button>
                                <button type="button" onclick="exportpdf()" class="btn btn-danger text-nowrap">
                                    Export PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
    <!-- /.row (main row) -->

@endsection

@push('js')
    <script>
        let year = $('select[id=year] option').filter(':selected').val();

        function exportexcel() {
            var url = "{{ URL::to('/dashboard/export') }}?year=" + year
            window.location = url;
        }

        function exportpdf() {
            var url = "{{ URL::to('/dashboard/exportpdf') }}?year=" + year
            window.location = url;
        }
        $(function() {

            $('.date-own').datepicker({
                minViewMode: 2,
                format: 'yyyy'
            });
            // chart
            const MONTHS = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

            $.ajax({
                url: '/dashboard/chart',
                type: 'GET',
                dataType: 'Json',
                data: {
                    year,
                },
                success: function(data) {
                    var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext(
                        '2d')

                    var salesChartData = {
                        labels: MONTHS,
                        datasets: [{
                            label: 'Pemakaian Kendaraan',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: data
                        }, ]
                    }

                    var salesChartOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    display: false
                                }
                            }]
                        }
                    }
                    // This will get the first returned node in the jQuery collection.
                    // eslint-disable-next-line no-unused-vars
                    var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
                        type: 'bar',
                        data: salesChartData,
                        options: salesChartOptions
                    })
                }
            });



        })
    </script>
@endpush
