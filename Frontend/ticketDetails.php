<?php 
include "includes/config.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Ticket Details</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/styles.css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
<body>

<?php include_once('includes/header.php'); ?>
<div class = "container">
<?php 
// Getting purchased ticket in search to validate
    $ids = isset($_GET['ticketIds']) ? $_GET['ticketIds'] : null;
    if(!$ids) {
        echo '<div class="well well-lg">';
            echo '<h1>Invalid ticket Id</h1>';
        echo '</div>';
    } else {
       $ids =  explode("_", $ids);
       $ids = '('.join(",", $ids).')';
        $result = $pdo->prepare("SELECT * FROM tickets 
        JOIN events ON events.eventId = tickets.eventId
        LEFT JOIN seats ON  seats.seatId = tickets.seatId
        WHERE tickets.ticketId in ".$ids.";");
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($result) > 0) {
            foreach($result as $row)
            {         
                echo '<div class="well well-lg">';
                    echo '<h1>'.$row["eventName"].'</h1>';
                    echo '<h2>Name: '.$row["name"].'</h2>';
                    echo '<h2>Ticket Id: '.$row["ticketId"].'</h2>';
                    echo '<h2>Seat Id: '.$row["seatId"].'</h2>';
                    echo '<h2>Paid: '.$row["paid"].'</h2>';
                echo '</div>';
                //print_r($row);
            }
        } else {
            echo '<div class="well well-lg">';
                echo '<h1>Invalid ticket Id</h1>';
            echo '</div>';
        }
    }
?>
</div>
<?php include_once('includes/footer.php'); ?>
</body>
</html>