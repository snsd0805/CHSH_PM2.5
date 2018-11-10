<meta charset="UTF-8">
<?php
require ("function.php");
$time=$_GET['time'];

$data=new pm25();
$data->time_data($time);
?>