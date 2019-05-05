<?php
// Allow access control for post API request
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "includes/config.php";
$ticketsData = json_decode($_POST['ticketsData']);
$name = $_POST['name'];

$ticketIds = [];
$seatDetails = [];
$priceDetails = [];
$eventsSeatDetails = [];
$eventsSpriceDetails = [];
$eventIds = [];
 foreach($ticketsData  as $eventId => $value) { 
   $eventsSeatDetails[$eventId] = $value ->seats;
   $eventsSpriceDetails[$eventId] = $value ->price;
   $eventIds[$eventId] = $eventId;
 }
 // query to create ticket after checkout
 $res = $pdo->prepare("INSERT INTO tickets (name, eventId, seatId, paid) VALUES (?, ?, ?, ?)");
 foreach ($eventIds as $eventId) {
     $priceDetails = $eventsSpriceDetails[$eventId];
     $seatDetails = $eventsSeatDetails[$eventId];
     for($index = 0; $index < sizeof($seatDetails); $index++) {
            $seatId = $seatDetails[$index];
            $paid = $priceDetails[$index];
            $data = array($name, $eventId, $seatId, $paid);
            $res->execute($data);
            $last_id =  $pdo->lastInsertId();
            array_push($ticketIds, $last_id);
     }
}
    echo '{';
        echo '"statusCode": 0,';
        echo '"data": {';
            echo '"message": "tickets added successfully.",';
            echo '"data":'.json_encode($ticketsData).',' ;
            echo '"name":"'.$name.'",';
            echo '"ticketIds":'.json_encode($ticketIds).',';
            echo '"events":'.json_encode($eventIds).',';
            echo '"seatssss":'.json_encode($eventsSeatDetails).'';
        echo '}';
    echo '}';
?>