<!DOCTYPE html>
<html>
<head>
<title>Header</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
       <a href="index.php" style = "display:inline;">
           <button style="margin: 10px">HOME </button> 
        </a> </div>
    <div style = "position: absolute; left: 94px; top: 11px;">
        <form method = "GET" action = "ticketDetails.php">
            <span style= "color:white;">Verify Ticket (By ID): </span>
            <input type = "text" name="ticketIds" id= "ticketIds" />
            <input type = "submit" name = "sub" id = "sub"/>
        </form>
    </div>
   
</nav>

</body>
</html>