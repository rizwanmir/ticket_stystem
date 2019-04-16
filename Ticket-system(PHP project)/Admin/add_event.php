<?php
//Include database connection file
include "config.php";
 
if(isset($_POST['Submit'])) {
     
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $vanueName = $_POST['vanueName'];

          //insert product data to database
        $query = ("INSERT INTO events (eventName, eventDate) VALUES (:eventName, :eventDate)");
        $result =$pdo->prepare($query);
        $result-> execute([
            ':eventName' => $eventName,
            ':eventDate' => $eventDate
        ]);
        $last_id = $pdo->lastInsertId();

        $query2 = ("INSERT INTO vanue (eventId, vanueName) VALUES (:last_id, :vanueName)");
        $result2 = $pdo->prepare($query2);
        $result2-> execute([
            ':last_id' => $last_id,
            ':vanueName' => $vanueName 
        ]);

        echo "<font color='green'>Product added successfully.";
        echo "<br/><a href='index.php'>View Products</a>";
    }

?>