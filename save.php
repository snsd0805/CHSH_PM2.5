<meta charset="UTF-8">
<?php
require ("function.php");
$id=$_GET['id'];

header("refresh:600");

$data=new pm25();
$data->save_data();
?>