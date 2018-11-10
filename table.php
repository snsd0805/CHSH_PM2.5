<?php
include_once "function.php";
$data=new pm25();
$pm25=$data->perhour_data();

?>
<meta charset="UTF-8">
<h3><?php echo date("Y年m月d日")." <BR>彰化地區當日PM2.5濃度分析"; ?></h3>
<p><canvas id="canvas"></canvas></p>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js" integrity="sha256-N2Q5nbMunuogdOHfjiuzPsBMhoB80TFONAfO7MLhac0=" crossorigin="anonymous"></script><script>
    var lineChartData = {
        labels: ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23"], //顯示區間名稱
        datasets: [{
            label: ' PM2.5濃度 (μg/m3) ', // tootip 出現的名稱
            lineTension: 0, // 曲線的彎度，設0 表示直線
            backgroundColor: "#ea464d",
            borderColor: "#ea464d",
            borderWidth: 5,
            data: [<?php for($i=1;$i<24;$i++)
                            if($i!=23) echo $pm25[$i].",";
                            else echo $pm25[$i];
                   ?>], // 資料
            fill: false, // 是否填滿色彩
        },]
    };

    function drawLineCanvas(ctx, data) {
        window.myLine = new Chart(ctx, { //先建立一個 chart
            type: 'line', // 型態
            data: data,
            options: {
                responsive: true,
                legend: { //是否要顯示圖示
                    display: true,
                },
                tooltips: { //是否要顯示 tooltip
                    enabled: true
                },
                scales: { //是否要顯示 x、y 軸
                    xAxes: [{
                        display: true
                    }],
                    yAxes: [{
                        display: true
                    }]
                },
            }
        });
    };
    window.onload = function () {
        var ctx = document.getElementById("canvas").getContext("2d");
        drawLineCanvas(ctx, lineChartData);
    };
</script>
