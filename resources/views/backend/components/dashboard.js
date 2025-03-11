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