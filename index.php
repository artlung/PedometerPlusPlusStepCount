<!DOCTYPE html>
<html>
  <head>
  	<title>Step History / Joe Crawford</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    // https://developers.google.com/chart/interactive/docs/gallery/trendlines
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(/*[
          ['Age', 'Weight'],
          [ 8,      12],
          [ 4,      5.5],
          [ 11,     14],
          [ 4,      5],
          [ 3,      3.5],
          [ 6.5,    7]
        ]*/<?php include 'Export.php'; ?>.map(function(elem){
        	return [new Date(elem[0]), elem[1]];
        }));

        var options = {
          title: 'Step History / Joe Crawford',
          hAxis: {
          		title: 'Date',
          		ticks: [new Date(2014,0,1), new Date(2015,0,1), new Date(2016,0,1)]	
          	},
          vAxis: { 
          		title: 'Steps',
          		minValue: 0,
          		maxValue: 30000,
          		ticks: [0, 5000, 10000, 15000, 20000, 25000, 30000]
          	},
          pointShape: 'star',
		    pointSize: 2,
		    curveType: 'function',
          legend: 'none',
          explorer: { 
          	actions: ['dragToZoom', 'rightClickToReset'],
          	axis: 'horizontal'
          }
        };

        var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body style="margin: 0;padding: 0;background-color: #ccc;">
    <div id="chart_div" style="width: 100%; height: 600px;"></div>
  </body>
</html>