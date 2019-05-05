<?php
//Include database connection file
include "includes/config.php";
 
// use ticket class and create method to add ticket data
if(isset($_POST['Submit'])) {
     
    $eventId = filter_input(INPUT_POST, 'eventId', FILTER_SANITIZE_STRING);
    $seatNumber = filter_input(INPUT_POST, 'seatNumber', FILTER_SANITIZE_STRING);
    $seatLocation = filter_input(INPUT_POST, 'seatLocation', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);

    if($ticket->create($eventId, $seatNumber, $seatLocation, $price)) {
        header("location:add_ticket.php?inserted");
    } else {
        header("location:add_ticket.php?failure");
    }
}

?>
<?php include_once 'includes/header.php'; ?>
<div class="clearfix"></div>
<?php
if(isset($_GET['inserted'])) {  
?>
<div class="container">
    <div class="alert alert-success">
       Tickets added successfully<a href="index.php">&nbsp;VIEW</a>
    </div>
</div>
<?php 
} else if(isset($_GET['failure'])) {
?>
<div class="container">
    <div class="alert alert-warning">
        <strong>Error while inserting tickets!</strong>
    </div>
</div>
<?php
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Add Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table {
            margin-left: 30px;
            width: 30%;
        }
        
        a {
            margin-left: 10px;
            height: 25px;
        }
    </style>

    <body>
        <?php include_once('includes/header.php'); ?>

        <form action="add_ticket.php" method="post" name="form1">
            <div class="form-group">
                <table>
                    <tr>
                        <td>Event Id</td>
                        <td><input type="text" name="eventId" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Seat Number</td>
                        <td><input type="text" name="seatNumber" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Seat Location</td>
                        <td><input type="text" name="seatLocation" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><input type="text" name="price" class="form-control"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><input type="submit" name="Submit" value="Add" class="btn btn-info" style="margin-top: 10px;"></td>
                    </tr>
                </table>
            </div>
        </form>
    <?php include_once('includes/footer.php'); ?>
    </body>

</html>