<?php
//Include database connection file
include "../db/config.php";

 
if(isset($_POST['Submit'])) {
     
    $eventName = filter_input(INPUT_POST, 'eventName', FILTER_SANITIZE_STRING);
    $eventDate = filter_input(INPUT_POST, 'eventDate', FILTER_SANITIZE_STRING);
    $vanueName = filter_input(INPUT_POST, 'vanueName', FILTER_SANITIZE_STRING);

          //insert event data to database
        $query = ("INSERT INTO events (eventName, eventDate) VALUES (:eventName, :eventDate)");
        $result =$pdo->prepare($query);
        $result-> execute([
            ':eventName' => $eventName,
            ':eventDate' => $eventDate
        ]);
        $last_id = $pdo->lastInsertId();

        // insert to vanue table as a seprate query
        $query2 = ("INSERT INTO vanue (eventId, vanueName) VALUES (:last_id, :vanueName)");
        $result2 = $pdo->prepare($query2);
        $result2-> execute([
            ':last_id' => $last_id,
            ':vanueName' => $vanueName 
        ]);

        echo "<font color='green'>Eventt added successfully.";
        echo "<br/><a href='index.php'>View Events</a>";
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

        <form action="add_event.php" method="post" name="form1">
            <div class="form-group">
                <table>
                    <tr>
                        <td>Event Name</td>
                        <td><input type="text" name="eventName" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Event Date</td>
                        <td><input type="text" name="eventDate" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Vanue Name</td>
                        <td><input type="text" name="vanueName" class="form-control"></td>
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