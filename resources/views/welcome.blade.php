<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div id="chart_div"></div>

<script>
    google.charts.load('current', {
        packages: ['corechart', 'line']
    });

    google.charts.setOnLoadCallback(drawCurveTypes);

    function drawCurveTypes() {
        var data = new google.visualization.DataTable();

        data.addColumn('timeofday', 'X');
        data.addColumn('number', 'COI Diff');
        data.addColumn('number', 'OI Diff');

        data.addRows({!! $jsonData !!});

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

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
