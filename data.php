<meta charset="UTF-8">
<?php
require ("function.php");
$id=$_GET['id'];

pm25::place_data($id);
?>