
<?php
// include connection file
include "includes/config.php";

// use ticket class and delete method to delete the row from seats table
    $id = $_GET['seatId'];
    $ticket->delete($id);
    //redirecting to the tickets list
    header("Location:index.php");

?>