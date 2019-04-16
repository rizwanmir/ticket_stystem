<?php

// include database connection
include "config.php";
 
if(isset($_POST['update']))
{  
    $seatId = $_POST['seatId'];  
    $eventId = $_POST['eventId'];
    $seatNumber = $_POST['seatNumber'];
    $seatLocation = $_POST['seatLocation'];
    $price = $_POST['price'];

        $result = $pdo->prepare("UPDATE seats
        SET
        seatId=:seatId,
        eventId=:eventId,
        seatNumber=:seatNumber,
        seatLocation=:seatLocation,
        price=:price 
        WHERE seatId=:seatId");

        $result->execute([
            'seatId' => $seatId,
            ':eventId' => $eventId,
            ':seatNumber' => $seatNumber,
            ':seatLocation' => $seatLocation,
            ':price' => $price
        ]);
        //redirectig to the product list
        header("Location: index.php");
    
}

//getting product code from product list
$seatId = $_GET['seatId'];

$result = $pdo->prepare("SELECT * FROM seats WHERE seatId=:seatId");
$result->execute([':seatId' => $seatId]);
$res = $result->fetchAll(PDO::FETCH_ASSOC);

foreach($res as $row)
{    
    $eventId = $row['eventId'];
    $seatNumber = $row['seatNumber'];
    $seatLocation = $row['seatLocation'];
    $price = $row['price'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
<body>
    <a href="index.php">Home</a>
    <br/><br/>
    
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
            
                <td><input type="hidden" name="seatId" value=<?php echo $_GET['seatId'];?>></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
</body>
</html>