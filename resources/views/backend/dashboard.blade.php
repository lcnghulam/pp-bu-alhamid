<x-backend-layout>
    <div class="my-4">
        <h1 class="d-inline align-middle">Selamat Datang di Dashboard!</h1>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pie Chart</h5>
            </div>
            <div class="card-body text-center">
                <div class="chart w-100">
                    <div id="apexcharts-pie" style="max-width: 440px;margin:auto;"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
                // Pie chart
                var options = {
                    chart: {
                        height: 350,
                        type: "donut",
                    },
                    legend: {
                        labels: {
                            colors: 'rgb(108, 117, 125)'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    series: [44, 55, 13, 33]
                };

                var chart = new ApexCharts(document.querySelector("#apexcharts-pie"), options);
                chart.render();
            });
    </script>
</x-backend-layout>