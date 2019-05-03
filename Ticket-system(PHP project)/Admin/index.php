<?php
//including database connection
include "config.php";
 
$result = $pdo->query("SELECT * FROM events JOIN vanue ON events.eventId = vanue.eventId"); 
?>

 <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> HOme Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            margin: 20px;
        }
       .header > form {
            float: right;
            margin-left: 0;
            display: inline-block;
        }     
    </style>
<body>
<div class="header">
    <a href="add_event.html" class="badge badge-primary" style="padding:9px">Add New Event</a> <br/><br/>
    
<!-- <form class="form-group" action="search.php" method="get"> 
<input  type="text" name="keyword" placeholder="Search Product"> 
<input type="submit" name="submit" value="Search" class="btn btn-primary" />
</form> -->
</div>

    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Event ID</th>
            <th scope="col">Event Name</th>
            <th scope="col">Event Date</th>
            <th scope="col">Vanue Name</th>
            <th scope="col">Update</th>
        </tr>
</thead>
<tbody>
        <?php 
        
    $res = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($res as $row)
        {  
            echo "<tr>";
            echo "<td>".$row['eventId']."</td>";
            echo "<td>".$row['eventName']."</td>";
            echo "<td>".$row['eventDate']."</td>";
            echo "<td>".$row['vanueName']."</td>";
            echo "<td><a href=\"edit_event.php?eventId=$row[eventId]\">Edit</a> | <a href=\"delete_event.php?eventId=$row[eventId]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";        
        }
        ?>
        </tbody>
    </table>
    <br/>

    <div class="header">
    <a href="add_ticket.html" class="badge badge-primary" style="padding:9px">Add New Tickets</a> <br/><br/>
</div>
<?php
$result2 = $pdo->query("SELECT * FROM seats JOIN events ON events.eventId = seats.eventId");
?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Event ID</th>
            <th scope="col">Event Name</th>
            <th scope="col">Seat Number</th>
            <th scope="col">Seat Location</th>
            <th scope="col">Price</th>
            <th scope="col">Update</th>
        </tr>
</thead>
<tbody>
        <?php 
        
        $res = $result2->fetchAll(PDO::FETCH_ASSOC);
        foreach($res as $row)
        {         
            echo "<tr>";
            echo "<td>".$row['eventId']."</td>";
            echo "<td>".$row['eventName']."</td>";
            echo "<td>".$row['seatNumber']."</td>";
            echo "<td>".$row['seatLocation']."</td>";
            echo "<td>".$row['price']."</td>";

          echo "<td><a href=\"edit_ticket.php?seatId=$row[seatId]\">Edit</a> | <a href=\"delete_ticket.php?seatId=$row[seatId]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";        
        }
        ?>
        </tbody>
    </table>
</body>
</html>