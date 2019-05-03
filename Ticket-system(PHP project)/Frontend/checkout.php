<?php 
include "config.php";
?>

<!DOCTYPE html>
 <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Checkout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>

    <body>
    <div style="background-color:grey; width:100%">
    <a href="index.php">
        <button style="margin: 10px">HOME </button> 
    </a> </div>
<br/>
<?php include "cart.php"; ?>
<div style="margin:8px; background-color: grey; padding:10px;">
    <h1> Your Ticket Details </h1>
    <?php
        if(isset($_COOKIE["shopping_cart"])) {
            foreach($cart_data as $keys => $values)
            {
    ?>
    <div style="background-color:yellow; padding:10px;">
    <div style="overflow: hidden;">
     <h4 style="float:left"> Your Event: </h4> <p style="float:right"><?php echo $values["item_name"]; ?></p>
            </div>
            <div style="overflow: hidden;">
   <h4 style="float:left"> Your seat Number: </h4> <p style="float:right"><?php echo $values["seat_number"]; ?></p>
            </div>
            </div>
    <?php
        }
        ?>
    <?php
    }
    ?>
    </div>
    </body>
</html>