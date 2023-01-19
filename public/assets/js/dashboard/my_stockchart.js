let options = {
    exportEnabled: true,
    title: {
        text:"AI / time"
    },
    subtitles: [{
        text:"Asymmetry index per time"
    }],
    charts: [{
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true,
                valueFormatString: "DD-MM-YYYY hh:mm:ss"
            }
        },
        axisY: {
            title: "AI",
            prefix: "",
            suffix: "",
            crosshair: {
                enabled: true,
                snapToDataPoint: true,
                valueFormatString: "###",
            }
        },
        data: [{
            type: "line",
            xValueFormatString: "MMM YYYY",
            yValueFormatString: "###",
            dataPoints : dataPoints
        }]
    }],
    /*navigator: {
        slider: {
            minimum: new Date(2010, 00, 01),
            maximum: new Date(2018, 00, 01)
        }
    }*/
}

$(window).on('load', () => {
    var stockChart = new CanvasJS.StockChart("stockChartContainer", options);
    stockChart.render();
})