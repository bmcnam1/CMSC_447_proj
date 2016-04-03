<html>
<head>
	<title>Pie chart</title>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	  google.charts.load('current', {packages: ['corechart']});
	</script>
	<script>

		chart = function(json){
			array = JSON.parse(json);
			
			var counts = {};
			for(var i in array){
				var nam = array[i]['crimeType'];
				if(counts.hasOwnProperty(nam)){
					counts[nam] ++;
				}else{
					counts[nam] = 1;
				}
			}

			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Crime type');
        	data.addColumn('number', 'count');

        	for(var prop in counts){
        		data.addRow([prop,counts[prop]]);
        	}

        	var options = {'title':'Pie Chart of Baltimoere Crimes with Desired Filters',
        					'width':800,
        					'height':700};
        	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        	chart.draw(data, options);

		};

		var data = new XMLHttpRequest();
		data.onload= function(){
			var json = this.responseText;
			chart(json)
		};

		var url = window.location.href;
		var par = url.indexOf("?");
		var datalocation =  "Data.php";
		if(par > 0){
			datalocation += url.substr(par);
		}
		data.open("get", datalocation , true);
		data.send();


	</script>
</head>

<body>
<div id="chart_div"></div>
</body>
</html>