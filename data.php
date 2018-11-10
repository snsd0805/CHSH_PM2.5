<meta charset="UTF-8">
<?php
require ("function.php");
$id=$_GET['id'];
$data=new pm25();
$data->place_data($id);
?>