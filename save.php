<meta charset="UTF-8">
<?php
require ("function.php");
$id=$_GET['id'];

header("refresh:600");

pm25::save_data();
?>