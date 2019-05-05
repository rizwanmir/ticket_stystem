<?php

// include database connection
include "includes/config.php";
 
if(isset($_POST['update']))
{  
    $eventId = filter_input(INPUT_POST, 'eventId', FILTER_SANITIZE_STRING);  
    $eventName = filter_input(INPUT_POST, 'eventName', FILTER_SANITIZE_STRING);
    $eventDate = filter_input(INPUT_POST, 'eventDate', FILTER_SANITIZE_STRING);
    $vanueName = filter_input(INPUT_POST, 'vanueName', FILTER_SANITIZE_STRING);

// use join to update data on both events and vanue table
        $result = $pdo->prepare("UPDATE events 
        INNER JOIN vanue ON events.eventId = vanue.eventId
        SET
        events.eventId=:eventId,
        events.eventName=:eventName,
        events.eventDate=:eventDate,
        vanue.vanueName=:vanueName 
        WHERE events.eventId=:eventId");

        $result->execute([
            ':eventId' => $eventId,
            ':eventName' => $eventName,
            ':eventDate' => $eventDate,
            ':vanueName' => $vanueName
        ]);
        //redirectig to the event list
        header("Location: index.php");
    
}

//getting event id from events
$eventId = $_GET['eventId'];

$result = $pdo->prepare("SELECT * FROM events JOIN vanue
    ON events.eventId = vanue.eventId
    WHERE events.eventId=:eventId");
$result->execute([':eventId' => $eventId]);
$res = $result->fetchAll(PDO::FETCH_ASSOC);

foreach($res as $row)
{    
    $eventName = $row['eventName'];
    $eventDate = $row['eventDate'];
    $vanueName = $row['vanueName'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Edit Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
<body>
<?php include_once('includes/header.php'); ?>
    
    <form name="form1" method="post" action="edit_event.php">
        <table border="0">
        <tr>
                <td>Event Id</td>
                <td><input type="text" name="eventId" value="<?php echo $eventId;?>"></td>
            </tr> 
            <tr>
                <td>Event Name</td>
                <td><input type="text" name="eventName" value="<?php echo $eventName;?>"></td>
            </tr>
            <tr>
                <td>Event Date</td>
                <td><input type="text" name="eventDate" value="<?php echo $eventDate;?>"></td>
            </tr>
            <tr>
                <td>Vanue Name</td>
                <td><input type="text" name="vanueName" value="<?php echo $vanueName;?>"></td>
            </tr>
            
                <td><input type="hidden" name="eventId" value=<?php echo $_GET['eventId'];?>></td>
                <td><input type="submit" name="update" value="Update"></td>
            </tr>
        </table>
    </form>
<?php include_once('includes/footer.php'); ?>
</body>
</html>

