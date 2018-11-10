<?php
include_once "function.php";
$data=new pm25();
$pm25=$data->perhour_data();
$site_select=array("富貴角","麥寮","關山","馬公","金門","馬祖","埔里","復興","永和","竹山","中壢","三重","冬山","宜蘭","陽明","花蓮","臺東","恆春","潮州","屏東","小港","前鎮","前金","左營","楠梓","林園","大寮","鳳山","仁武","橋頭","美濃","臺南","安南","善化","新營","嘉義","臺西","朴子","新港","測站（試運轉）","斗六","南投","二林","線西","彰化","西屯","忠明","大里","沙鹿","豐原","三義","苗栗","頭份","新竹","竹東","湖口","龍潭","平鎮","觀音","大園","桃園","大同","松山","古亭","萬華","中山","士林","淡水","林口","菜寮","新莊","板橋","土城","新店","萬里","汐止","基隆");
date_default_timezone_set('Asia/Taipei');

if(empty($_GET['site'])){
    $site="彰化";

}else{
    $site=$_GET['site'];
}

if(empty($_GET['date'])){
    $date=date("Y-m-d");

}else{
    $date=$_GET['date'];
}
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<meta charset="UTF-8">

    <br>
    <div class="row">
        <div class="col">
        </div>
        <div class="col">
            <div class="alert alert-primary" role="alert">
                <?php echo $date."<span class=\"badge badge-secondary\">$site</span><BR>當日PM2.5濃度分析<br>（資料來自國家發展委員會政府資料開放平台）"; ?>
            </div>
        </div>
        <div class="col">
        </div>
    </div>
    <br>
</div>
<p><canvas id="canvas"></canvas></p>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js" integrity="sha256-N2Q5nbMunuogdOHfjiuzPsBMhoB80TFONAfO7MLhac0=" crossorigin="anonymous"></script><script>
    var lineChartData = {
        labels: ["0:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00","22:00","23:00"], //顯示區間名稱
        datasets: [{
            label: ' PM2.5濃度 (μg/m3) ', // tootip 出現的名稱
            lineTension: 0, // 曲線的彎度，設0 表示直線
            backgroundColor: "#ea464d",
            borderColor: "#ea464d",
            borderWidth: 5,
            data: [<?php for($i=0;$i<24;$i++)
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

<!--
<div class="row">
    <div class="col">
    </div>
    <div class="col">
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">查詢地點</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">以本系統已有資料為準</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">查詢日期</label>
                <input type="date" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
    <div class="col">
    </div>
</div>
<br>

</div>
-->
<br>
<br>


<div class="row">
    <div class="col">
    </div>
    <div class="col">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-primary btn-lg btn-block" data-toggle="modal" data-target="#exampleModalCenter">
            查詢特定地點及位置
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">選擇查詢參數</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="table.php" method="get">
                            <div class="form-group">
                                <label for="exampleInputEmail1">查詢地點</label>
                                <select class="custom-select custom-select-lg mb-3" name="site">
                                    <option selected>選擇地區</option>
                                    <?php
                                        foreach ($site_select as $row){
                                            echo "<option value=\"".$row."\">".$row."</option>";
                                        }
                                    ?>

                                </select>                                <small id="emailHelp" class="form-text text-muted">以本系統已有資料為準</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">查詢日期</label>
                                <input type="date" value="<?php echo date("Y-m-d"); ?>" name="date" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>

                                                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
    </div>
</div>
<br>
<br>