<?php

include 'components/conect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('Location: home.php');
    exit;
}

if(isset($_POST['submit'])){
    $address = $_POST['no'].','.$_POST['street'].','.$_POST['city'].','.$_POST['country'].' - '.$_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);

    $update_address = $conn->prepare("UPDATE `users` SET address = ? WHERE id = ?");
    $update_address->execute([$address, $user_id]);

    $message[] = 'address updated!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update address</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->

    <!--update address start-->
    
    <section class="form-container">
        <form action="" method="post">
            <h3>Your Address</h3>
            <input type="text" name="no" maxlength="50" required placeholder="No" class="box">
            <input type="text" name="street" maxlength="50" required placeholder="street name" class="box">
            <input type="text" name="city" maxlength="50" required placeholder="city name" class="box">
            <input type="text" name="country" maxlength="50" required placeholder="country name" class="box">
            <input type="number" name="pin_code" required class="box" placeholder="enter your pin code" maxlength="6" min="0" max="999999" class="box" >
            <input type="submit" value="save address" name="submit" class="btn">
        </form>
    </section>



    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>