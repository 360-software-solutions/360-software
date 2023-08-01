<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div id="chart_coi"></div>
<div id="chart_oi"></div>

<script>
    google.charts.load('current', {
        packages: ['corechart', 'line']
    });

    google.charts.setOnLoadCallback(() => drawCurveTypes('COI Diff', 'chart_coi', {!! $jsonDataCOI !!}));
    google.charts.setOnLoadCallback(() => drawCurveTypes('PCR', 'chart_oi', {!! $jsonDataOI !!}));

    function drawCurveTypes(label, divId, jsonData) {
        var data = new google.visualization.DataTable();

        data.addColumn('timeofday', 'X');
        data.addColumn('number', label);

        data.addRows(jsonData);

        var options = {
            hAxis: {
                title: 'Time'
            },
            vAxis: {
                title: 'Diff'
            },
            series: {
                1: {
                    curveType: 'function'
                }
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById(divId));
        chart.draw(data, options);
    }
</script>
