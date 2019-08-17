@extends('layouts.app')

@section('content')



<div class="container justify-content-center content">
<form action="/graph/{{$section_id}}" method="POST">
@csrf
<label class="label-filter">Filter Waktu</label>
<table>
<tr>
	<td>
	<div class="form-check form-check-inline">
		<select name="time" class="form-control filter-limit filter-input">
			<option value="hari">Hari</option>
			<option value="bulan">Bulan</option>
		</select>
	</div>
	</td>
	<td><button class="btn btn-default btn-filter-graph">Submit</button></td>
</tr>
</table>
</form>
	<div class="graph" id="chartContainer">

	</div>          
</div>

<script>

var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "Data Perbandingan Harga"
	},
	width: 720,
	toolTip:{   
		content: "{namabarang}: {y}"      
	},
	axisY: {
		title: "Range Harga",
		interval: {{$average}}
	},

	<?php if ($filter==0) { ?>
	axisX:{
		valueFormatString: "D-M-YY" ,
		<?php if ($onedata==1) { ?>
		interval: 1,
		<?php } ?>
		<?php if ($onedata==0) { ?>
		interval: 0,
		<?php } ?>
        intervalType: "day",
	},
	<?php } ?>

	<?php	if ($filter==1) { ?>
	axisX:{
		valueFormatString: "M-YY" ,
		<?php if ($onedata==1) { ?>
		interval: 1,
		<?php } ?>
		<?php if ($onedata==0) { ?>
		interval: 0,
		<?php } ?>
        intervalType: "day",
	},
	<?php } ?>

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

