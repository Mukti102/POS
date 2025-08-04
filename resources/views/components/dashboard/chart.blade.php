<div class="col-lg-7 col-sm-12 col-12 d-flex">
    <div class="card flex-fill">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Omset Dan Profit</h5>
            <div class="graph-sets">

                {{-- <div class="dropdown">
                    <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        2022
                        <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2" />
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item">2022</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item">2021</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item">2020</a>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </div>
        <div class="card-body">
            <div id="s-coli" class="chart-set"></div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            if ($("#s-coli").length > 0) {
                var sCol = {
                    chart: {
                        height: 350,
                        type: "bar",
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "55%",
                            endingShape: "rounded",
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ["transparent"]
                    },
                    series: [{
                            name: "Profit",
                            data: @json($profitData),
                        },
                        {
                            name: "Omset",
                            data: @json($revenueData),
                        }
                    ],
                    xaxis: {
                        categories: [
                            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                        ],
                    },
                    yaxis: {
                        title: {
                            text: "Rp"
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "Rp " + val.toLocaleString('id-ID');
                            },
                        },
                    },
                };

                var chart = new ApexCharts(document.querySelector("#s-coli"), sCol);
                chart.render();
            }
        });
    </script>
@endpush
