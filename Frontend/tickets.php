<?php 
include "includes/config.php";
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
        <link rel="stylesheet" href="css/styles.css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
<body>
<?php include_once('includes/header.php'); ?>
<?php 
// getting specific event details
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
 <div class="row">
<?php
// query to get the available tickets if purchased not show
    $result = $pdo->prepare("SELECT * FROM seats 
    INNER JOIN events ON seats.eventId = events.eventId 
    WHERE events.eventId=:eventId AND seats.seatId NOT IN 
    (SELECT seatId FROM tickets where eventId = :eventId)");
    $result->execute([':eventId' => $id]);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
// if there is no tickets availble to buy
      if(count($result) == 0) {
        echo '<div class="well well-lg">';
        echo '<h1>Tickets Sold Out</h1>';
        echo '</div>';
      }
   foreach($result as $row)
   {
   ?>
    <div class="col-md-3">
        <div class="seat-details">
            <h4 class="text-info"><?php echo $row['seatLocation']; ?> </h4>
            Seat number:  <?php echo $row['seatNumber']; ?>
            <h4 class="text-danger">SEK <?php echo $row['price']; ?> </h4>      
            <input type="hidden" name="quantity" class="form-control" value="1" />
            <input type="hidden" name="hidden_name" value="<?php echo $row['eventName']; ?>" />
            <input type="hidden" name="hidden_seat" value="<?php echo $row['seatNumber']; ?>" />
            <input type="hidden" name="hidden_price" value="<?php echo $row['price']; ?>" />
            <input type="hidden" name="hidden_id" value="<?php echo $row["seatId"]; ?>" />
            <?php
            // if event is expired disable buy
                if(new DateTime() > new DateTime($row['eventDate']))
                {
                  echo '<input type="button" name="add_to_cart"  class="btn btn-success add-to-cart" value="Add to Cart" disabled />';

                }else {
                  echo  '<input type="button" name="add_to_cart"  onclick="addToCart(this)" data-event-id='.$id.' data-event-name="'.$row['eventName'].'" data-event-seatNo='.$row['seatNumber'].' data-seat-id="'.$row['seatId'].'" data-price="'.$row['price'].'" data-seat-location = "'.$row['seatLocation'].'" class="btn btn-success add-to-cart addtocart" value="Add to Cart" />';
                }
          ?>
          <br/>
        </div>
    </div>
<?php
}
 ?>
 </div>
<br/>
<?php
}
?>
<div id= "cart-details">
</div>
<div>
<div style = "padding-left: 20px;">
    <p>
      Name
    </p>
    <input type = "text" id = "name"/>
</div>
<input type="submit" id= "checkout" name="checkout" onclick = "cartHandler.checkoutCart(this)" style="margin:40px;" class="btn btn-success" value="Checkout" />
</a>
</div>
<link>
<script src="js/cart.js"></script>
<?php include_once('includes/footer.php'); ?>
</body>
</html>