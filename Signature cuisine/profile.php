<?php

include 'components/conect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
      
      
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->

    <!--Profile start-->
    <section class="user-profile">
        <div class="box">       
            <img src="images/person.png" alt="">
            <p><i class="fas fa-user"></i> <span><?= $fetch_profile['name']; ?></span> </p>
            <p><i class="fas fa-envelope"></i> <span><?= $fetch_profile['email']; ?></span> </p>
            <p><i class="fas fa-phone"></i> <span><?= $fetch_profile['number']; ?></span> </p>
            <a href="update_profile.php" class="btn" style="margin-bottom: 1rem">Update info</a>
            <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address!';}else{ echo $fetch_profile['address'];}; ?></span></p>
            <a href="update_address.php" class="btn">Update address</a>
        </div>
    </section>
    

    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>