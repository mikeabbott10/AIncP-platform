// source https://www.highcharts.com/demo/stock/lazy-loading

/**
 * Load new data depending on the selected min and max
 */
function afterSetExtremes(e) {
    const { chart } = e.target;
    chart.showLoading('Loading data from server...');
    console.log(`${dataURL}/${Math.round(e.min)}/${Math.round(e.max)}`)
    $('input[name=start_time]').val(Math.round(e.min));
    $('input[name=end_time]').val(Math.round(e.max));
    fetch(`${dataURL}/${Math.round(e.min)}/${Math.round(e.max)}`)
    .then(res => res.ok && res.json())
    .then(data => {
        //console.log(data)
        chart.series[0].setData(data);
        chart.hideLoading();
    }).catch(error => console.error(error.message));
}

fetch(dataURL)
.then(res => res.ok && res.json())
.then(data => {
    // create the chart
    Highcharts.stockChart('container', {
        chart: {
            zoomType: 'x'
        },

        navigator: {
            adaptToUpdatedData: false,
            series: {
                data: data
            }
        },

        scrollbar: {
            liveRedraw: false
        },

        title: {
            text: 'Asymmetry index in time',
            align: 'left'
        },

        subtitle: {
            text: 'Select the range, fill the form and save a new session',
            align: 'left'
        },

        rangeSelector: {
            buttons: [{
                type: 'minute',
                count: 1,
                text: '1min'
            }, {
                type: 'hour',
                count: 1,
                text: '1h'
            }, {
                type: 'day',
                count: 1,
                text: '1d'
            }, {
                type: 'all',
                text: 'All'
            }],
            inputEnabled: false, // it supports only days
            selected: 4 // all
        },

        xAxis: {
            events: {
                afterSetExtremes: afterSetExtremes
            },
            minRange: 60 * 1000 // one minute
        },

        yAxis: {
            ceiling: 120,
            floor: -120
        },

        series: [{
            data: data,
            dataGrouping: {
                enabled: false
            }
        }]
    });
}).catch(error => console.error(error.message));