<?php 
include "config.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Tickets</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
function myFunction() {
  document.getElementById("btnSubmit").disabled = true;
}
</script>
  </head>
<body>
<div style="background-color:grey; width:100%">
<a href="index.php">
<button style="margin: 10px">HOME </button> 
</a> </div> 
<br/>
<?php 
$id = isset($_GET['eventId']) ? $_GET['eventId'] : '';

$result = $pdo->prepare("SELECT * FROM events 
JOIN vanue ON events.eventId = vanue.eventId
WHERE events.eventId=:eventId");
$result->execute([':eventId' => $id]);
$result = $result->fetchAll(PDO::FETCH_ASSOC);
  foreach($result as $row)
  {
?>
 <div style="width:100%; text-align:center">
  <h4 class="text-info"><?php echo $row['eventName']; ?> </h4>
    <p>Date and Time: <?php echo $row['eventDate']; ?> </p>
     <h4 class="text-info">Vanue: <?php echo $row['vanueName']; ?> </h4>
  </div>
 <br/>
<?php

$result = $pdo->prepare("SELECT * FROM seats
JOIN events ON seats.eventId = events.eventId
WHERE events.eventId=:eventId");
$result->execute([':eventId' => $id]);
$result = $result->fetchAll(PDO::FETCH_ASSOC);

   foreach($result as $row)
   {
   ?>
    <div class="col-md-3">
    <form method="POST">
        <div style="border:1px solid #333; border-radius:5px; margin-left:15px; padding:8px; text-align:center">
        <h4 class="text-info"><?php echo $row['seatLocation']; ?> </h4>
        Seat number:  <?php echo $row['seatNumber']; ?>
        <h4 class="text-danger">SEK <?php echo $row['price']; ?> </h4>
            
        <input type="hidden" name="quantity" class="form-control" value="1" />
        <input type="hidden" name="hidden_name" value="<?php echo $row['eventName']; ?>" />
        <input type="hidden" name="hidden_seat" value="<?php echo $row['seatNumber']; ?>" />
        <input type="hidden" name="hidden_price" value="<?php echo $row['price']; ?>" />
        <input type="hidden" name="hidden_id" value="<?php echo $row["seatId"]; ?>" />
        <a href="tickets.php?seatId=$row['seatId']">
        <?php
      if(new DateTime() > new DateTime($row['eventDate']))
      {
        ?>
        <input type="submit" name="add_to_cart" id="btnSubmit" style="margin-top:5px;" class="btn btn-success" 
      value="Add to Cart" disabled />
      <?php
      }else {
        ?>
      <input type="submit" name="add_to_cart" id="btnSubmit" style="margin-top:5px;" class="btn btn-success" 
      value="Add to Cart" />
      <?php
      }
      ?>
      </a>
        </div>
    </form>
    </div>
<?php
}
 ?>
<br/>
<?php
}
?>
<div style="clear:both"></div>
   <br />
   <?php include "cart.php"; ?>
</div>
<div>
<a href="checkout.php">
<input type="submit" name="checkout" style="margin:12px;" class="btn btn-success" value="Checkout" />
</a>
</div>
</body>
</html>