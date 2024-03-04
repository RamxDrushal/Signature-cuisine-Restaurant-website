<?php

include 'components/conect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['date']) && isset($_POST['time'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO `reservation` (name, phone, email, date, time) VALUES ('$name', '$phone', '$email', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "Reservation saved successfully!";
    } 
}
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
    <style>
        form {
    max-width: 30rem;
    margin: 0 auto;
    background: #f9f9f9;
    padding: 2rem;
    border: 1px solid #c9c9c9;
    }

    label {
    font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"] {
        width: 100%;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
    }

    input[type="submit"] {
        width: 100%;
        background: #4CAF50;
        color: white;
        padding: 1rem;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background: #45a049;
    }
    .res-offer {
        text-align: center;
        margin-top: 2rem;
        font-size: 2rem;
        color: blueviolet;
    }

    </style>
    
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->
    <div class="heading">
        <h3>Reservation</h3>
        <p><a href="index.php">Home</a>  / Reservation<span></span></p>
    </div>

    <!--reservation start-->
    <form action="reservation.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone"><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date"><br>

        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time"><br><br>

        <input type="submit" value="Submit">
    </form>

    <p class="res-offer">10% off for the Early Reservation <br>
    Offer valid untill 30th of December <br>
    </p>
    <!--reservation end-->

    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>