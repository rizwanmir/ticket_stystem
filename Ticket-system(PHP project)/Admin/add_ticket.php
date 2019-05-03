<?php
//Include database connection file
include "config.php";
 
if(isset($_POST['Submit'])) {
     
    $eventId = $_POST['eventId'];
    $seatNumber = $_POST['seatNumber'];
    $seatLocation = $_POST['seatLocation'];
    $price = $_POST['price'];

          //insert product data to database
        $query = ("INSERT INTO seats (eventid, seatNumber, seatLocation, price) 
        VALUES (:eventId, :seatNumber, :seatLocation, :price)");
        $result =$pdo->prepare($query);
        $result-> execute([
            ':eventId' => $eventId,
            ':seatNumber' => $seatNumber,
            ':seatLocation' => $seatLocation,
            ':price' => $price
        ]);

        /*
        $last_id = $pdo->lastInsertId();

        $query2 = ("INSERT INTO vanue (eventId, vanueName) VALUES (:last_id, :vanueName)");
        $result2 = $pdo->prepare($query2);
        $result2-> execute([
            ':last_id' => $last_id,
            ':vanueName' => $vanueName 
        ]);

        */

        echo "<font color='green'>Product added successfully.";
        echo "<br/><a href='index.php'>View Products</a>";
    }

?>