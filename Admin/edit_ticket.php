<?php

// include database connection
include "../db/config.php";
 
if(isset($_POST['update']))
{  
    $seatId = filter_input(INPUT_POST, 'seatId', FILTER_SANITIZE_STRING); 
    $eventId = filter_input(INPUT_POST, 'eventId', FILTER_SANITIZE_STRING);
    $seatNumber = filter_input(INPUT_POST, 'seatNumber', FILTER_SANITIZE_STRING);
    $seatLocation = filter_input(INPUT_POST, 'seatLocation', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);

    // use ticket class and update method to edit tickets data
    if($ticket->update($seatId, $eventId, $seatNumber, $seatLocation, $price)) {
        $message = "<div class='alert alert success'>
        <strong>Sucessfully updated </strong>
        <a href='index.php'> HOME </a></div>";
    } else {
        $message = "<div class='alert alert-warning'>
        <strong>Error while updating </strong>
        </div>";
    }
}
if(isset($_GET['seatId'])) {
    $id = $_GET['seatId'];
    extract($ticket->getID($id));
}
?>
<?php include_once 'includes/header.php'; ?>
<div class="clearfix"></div>
<div class="container">
<?php
    if(isset($message)) {
        echo $message;
    }
?>
</div>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
<body>
    <?php include_once('includes/header.php'); ?>
    <form name="form1" method="post" action="edit_ticket.php">
        <table border="0">
        <tr>
                <td>Seat Id</td>
                <td><input type="text" name="seatId" value="<?php echo $seatId;?>"></td>
            </tr
        <tr>
                <td>Event Id</td>
                <td><input type="text" name="eventId" value="<?php echo $eventId;?>"></td>
            </tr> 
            <tr>
                <td>Seat Number</td>
                <td><input type="text" name="seatNumber" value="<?php echo $seatNumber;?>"></td>
            </tr>
            <tr>
                <td>Seat Location</td>
                <td><input type="text" name="seatLocation" value="<?php echo $seatLocation;?>"></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><input type="text" name="price" value="<?php echo $price;?>"></td>
            </tr>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
<?php include_once('includes/footer.php'); ?>
</body>
</html>