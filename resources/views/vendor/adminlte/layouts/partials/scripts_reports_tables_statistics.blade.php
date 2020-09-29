<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/daterangepicker/moment.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/chartsjs/charts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/chartsjs/utils.js') }}" type="text/javascript"></script>

<script>
    var timeFormat = 'MM/DD/YYYY HH:mm';
    var colorNames = Object.keys(window.chartColors);
    function newDate(days) {
        var m = console.log(moment().add(days, 'd').toDate());
        console.log(m);
        return m;
    }
    function newDateString(days) {
        var m = moment().add(days, 'd').format(timeFormat);
        console.log(m);
        return m;
    }
    function addItems() {
        for (let indexI = 0; indexI < 25; indexI++) {
            var colorName = colorNames[config.data.datasets.length % colorNames.length];
            var newColor = window.chartColors[colorName];
            var newDataset = {
                label: 'Mesa ' + (config.data.datasets.length + 1),
                borderColor: newColor,
                backgroundColor: color(newColor).alpha(0.5).rgbString(),
                data: [],
            };
            for (var index = 0; index < 24; ++index) {
                newDataset.data.push(randomScalingFactor());
            }
            config.data.datasets.push(newDataset);
            window.myLine.update();            
        }
    }
    var color = Chart.helpers.color;
    var config = {
        type: 'line',
        data: {
            labels: [
                newDate(0),
                // newDate(5),
                // newDate(6),
                // newDate(7),
                // newDate(8),
                // newDate(9),
                // newDate(10),
                // newDate(11),
                // newDate(12),
                // newDate(13),
                // newDate(14),
                // newDate(15),
                // newDate(16),
                // newDate(17),
                // newDate(18),
                // newDate(19),
                // newDate(20),
                // newDate(21),
                // newDate(22),
                // newDate(23),
            ],
            datasets: []
        },
        options: {
            title: {
                text: 'Chart.js Time Scale'
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        format: timeFormat,
                        round: 'hour',
                        tooltipFormat: 'HH:mm'
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Fecha'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Cantidad'
                    },
                    ticks: {
                        min: 0,
                        max: 200,
                        stepSize: 10,
                        reverse: false,
                    },
                }]
            },
        }
    };
    window.onload = function() {
        chart.options.scales.xAxes[0].time.unit='week';

        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
        addItems();
    };
    // document.getElementById('randomizeData').addEventListener('click', function() {
    //     config.data.datasets.forEach(function(dataset) {
    //         dataset.data.forEach(function(dataObj, j) {
    //             if (typeof dataObj === 'object') {
    //                 dataObj.y = randomScalingFactor();
    //             } else {
    //                 dataset.data[j] = randomScalingFactor();
    //             }
    //         });
    //     });
    //     window.myLine.update();
    // });
    // document.getElementById('addDataset').addEventListener('click', function() {
    //     addItems();
    // });
    // document.getElementById('addData').addEventListener('click', function() {
    //     if (config.data.datasets.length > 0) {
    //         config.data.labels.push(newDate(config.data.labels.length));
    //         for (var index = 0; index < config.data.datasets.length; ++index) {
    //             if (typeof config.data.datasets[index].data[0] === 'object') {
    //                 config.data.datasets[index].data.push({
    //                     x: newDate(config.data.datasets[index].data.length),
    //                     y: randomScalingFactor(),
    //                 });
    //             } else {
    //                 config.data.datasets[index].data.push(randomScalingFactor());
    //             }
    //         }
    //         window.myLine.update();
    //     }
    // });
    // document.getElementById('removeDataset').addEventListener('click', function() {
    //     config.data.datasets.splice(0, 1);
    //     window.myLine.update();
    // });
    // document.getElementById('removeData').addEventListener('click', function() {
    //     config.data.labels.splice(-1, 1); // remove the label first
    //     config.data.datasets.forEach(function(dataset) {
    //         dataset.data.pop();
    //     });
    //     window.myLine.update();
    // });
</script>