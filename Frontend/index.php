<?php
// database connection
include "config.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Events</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div style="background-color:grey; width:100%">
       <a href="index.php">
           <button style="margin: 10px">HOME </button> 
        </a> </div>
<br/>
<div class="container">
<?php
$query = "SELECT * FROM events";
$statement = $pdo->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
   foreach($result as $row)
   {
   ?>
<div class="col-md-3">
    <div style="border:1px solid #333; border-radius:5px; padding:16px; text-align:center">
        <h4 class="text-info"><?php echo $row['eventName']; ?> </h4>
        <?php echo $row['eventDate'];
          $id = $row['eventId'];
          echo '<a href="tickets.php?eventId='.$id.'">
          <input type="submit" name="see_tickets" style="margin-top:5px;" class="btn btn-success" value="See Tickets" />
           </a>';
        ?>
        <br/>
<?php
if (new DateTime() > new DateTime($row['eventDate'])) {
    echo  "Event expired";
} else
{
    echo "Available";
}
?>
        </div>
    </div>
    <?php
} 
?>
</body>
</html>