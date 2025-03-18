document.addEventListener("DOMContentLoaded", function() {
    const santriLaki = window.santriLaki;
    const santriPerempuan = window.santriPerempuan;

    // Pie chart
    var options = {
        chart: {
            height: 350,
            type: "donut",
            labels: {
                show: true,
                value: 50
            },
        },
        legend: {
            labels: {
                colors: 'rgb(108, 117, 125)'
            }
        },
        dataLabels: {
            enabled: true
        },
        series: [santriLaki, santriPerempuan],
        labels: ['Laki-Laki', 'Perempuan']
    };

    var chart = new ApexCharts(document.querySelector("#dataSantri"), options);
    chart.render();
});