<?php
include('koneksi.php');
$data = mysqli_query($koneksi,"select * from data");
while($row = mysqli_fetch_array($data)){
	$nama_negara[] = $row['Country'];
	
	// $query = mysqli_query($koneksi,"select Total_cases from data");
	// $row = $query->fetch_array();
	$jumlah_kasus[] = $row['Total_cases'];
}
	$querytotal = mysqli_query($koneksi, "select sum(Total_cases) as total from data");
	$row = $querytotal->fetch_array();
	$total = $row['total']
?>
<!doctype html>
<html>

<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>

<body>
	<center>
	<h1>Total Cases 10 Country</h1>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($jumlah_kasus); ?>,
					backgroundColor: [
					'rgb(0, 0, 205)',
					'rgb(252, 165, 3)',
					'rgb(178, 34, 33)',
					'rgb(34, 139, 35)',
					'rgb(253, 215, 3)',
					'rgb(135, 206, 250)',
					'rgb(128, 0, 128)',
					'rgb(64, 224, 208)',
					'rgb(127, 255, 1)',
					'rgb(255, 0, 0)'
					],
					label: 'Persentase Total Kasus 10 Negara'
				}],
				labels: <?php echo json_encode($nama_negara); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>