@extends('layouts.app')

@section('content')

<div class="container justify-content-center content">
   <h3>Grafik</h3>
   <div id="chartContainer" style="height: 100%; width: 100%;"></div>
   

</div>
<script>

 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Data Perbandingan Harga"
	},
	toolTip:{   
			content: "{namabarang}: {y}"      
	},
	axisY: {
		title: "Range Harga",
		interval: {{$average}}
	},
	axisX:{
		valueFormatString: "DD-MMM-YYYY" ,
		interval: 1,
        intervalType: "day",
	},
	legend: {
		cursor: "pointer",
		itemclick: function (e) {
			if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			} else {
				e.dataSeries.visible = true;
			}

			e.chart.render();
		}
	},
	data: [
	{
		type: "line",
      	showInLegend: true,
		xValueType: "dateTime",
		legendText: '{{ $shop_name_array[0] }}',
		dataPoints: <?php echo json_encode($dataPoints[0], JSON_NUMERIC_CHECK); ?>
	},]
});
chart.render();
var counter = {{$productcount}}
if(counter>1){
	<?php for($x=1;$x<$productcount;$x++) { ?>
		var newSeries = {
			type: "line",
			showInLegend: true,
			xValueFormatString: "dateTime",
			legendText: '{{ $shop_name_array[$x] }}',
			dataPoints: <?php echo json_encode($dataPoints[$x], JSON_NUMERIC_CHECK); ?>
		};
		chart.options.data.push(newSeries);
	<?php } ?>
	chart.render();
}
</script>
@endsection

