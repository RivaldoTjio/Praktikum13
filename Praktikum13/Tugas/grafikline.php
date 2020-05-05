<?php
include('koneksi.php');
// $label = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
$data = mysqli_query($koneksi, "select * from data");
while ($row = mysqli_fetch_array($data)) 
{
  $country[] = $row['Country']; 
  $jumlah_kasus[] = $row['New_Deaths'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script type="text/javascript" src="Chart.js"></script>
</head>
<body>
  <div style="width: 800px;height: 800px">
    <canvas id="myChart"></canvas>
  </div>


  <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($country); ?>,
        datasets: [{
          label: 'Grafik Kasus Kematian Baru',
          data: <?php echo json_encode($jumlah_kasus); ?>,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });
  </script>
</body>
</html>