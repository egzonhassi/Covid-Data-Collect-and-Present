var globalData = "";


$(document).ready(function () {

    $("#states").on("change", function () {

        changeChartData($(this).val());
    })

    var chart = "";

    $.ajax({
        type: "GET",
        url: url + "cases/122",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            initializeHighChart(data);

        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });




})

function changeChartData(state){
    $.ajax({
        type: "GET",
        url: url + "cases/"+state,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            chart.setTitle({text: "Covid Data Chart for "+ data.stateName});
            for(i=0;i < data.data.length; i++){

                chart.series[i].update({
                    pointStart: Date.UTC(data.startdate.year, data.startdate.month, data.startdate.day)
                })

                for(var j = 0 ; j<data.data[i]['data'].length ; j++)
                {
                    chart.series[i].data[j].update(data.data[i]['data'][j])
                }
            }


        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
    
}

function initializeHighChart(graphData) {


    chart = Highcharts.chart('container', {

        title: {
            text: "Covid Data Chart for "+ graphData.stateName
        },

        yAxis: {
            title: {
                text: 'Number of People'
            }
        },

        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%e / %b'
            },
            title: {
                text: 'Date'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    rotation: 0
                },
                pointStart: Date.UTC(graphData.startdate.year, graphData.startdate.month, graphData.startdate.day),
                pointInterval: 24 * 3600 * 1000, // one day
                type: 'datetime',
            }
        },

        series: graphData.data,

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
}