
<?php

//include database connection
include "config.php";
 
//getting product code from product list
$seatId = $_GET['seatId'];
 
//deleting the row from products table
$sql = "DELETE FROM seats WHERE seatId=:seatId";
$result = $pdo->prepare($sql);
$result->execute([':seatId' => $seatId]);
 
//redirecting to the product list
header("Location:index.php");

?>
