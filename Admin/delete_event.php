
<?php

//include database connection
include "../db/config.php";
 
//getting eventId from event list
$eventId = $_GET['eventId'];
 
//deleting the row from event table
$sql = "DELETE FROM events WHERE eventId=:eventId";
$result = $pdo->prepare($sql);
$result->execute([':eventId' => $eventId]);
 
//redirecting to the event list
header("Location:index.php");

?>
