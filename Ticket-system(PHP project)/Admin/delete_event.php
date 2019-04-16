
<?php

//include database connection
include "config.php";
 
//getting product code from product list
$eventId = $_GET['eventId'];
 
//deleting the row from products table
$sql = "DELETE FROM events WHERE eventId=:eventId";
$result = $pdo->prepare($sql);
$result->execute([':eventId' => $eventId]);
 
//redirecting to the product list
header("Location:index.php");

?>
