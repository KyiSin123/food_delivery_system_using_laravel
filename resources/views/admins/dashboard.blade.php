@extends('admins.adminLte')

@section('content')
<div class="container-fluid py-4">
    <h2 class="text-muted"> Monthly Records that Users Who use Our Website </h2>
    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var xValues = {{ Js::from($labels) }};
var yValues = {{ Js::from($datas) }};
var barColors = ["red", "green","blue","orange","brown","yellow","black","purple","gray","violet","gold","pink"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
        label: "Monthly Record of Users in 2023",
        backgroundColor: barColors,
        data: yValues
    }]
  },

  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Users who use Delicious Food"
    }
  }
});
</script>
@endsection