<meta charset="UTF-8">
<H1>PM2.5總表</H1>
<h1><a href="time_list.php">時間列表</a><br></h1>
<?php
require ("function.php");
$data=new pm25();
$data->data_list();
?>