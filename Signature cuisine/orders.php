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
    <title>Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->
    <div class="heading">
        <h3>Orders</h3>
        <p><a href="index.html">Home</a>  / Orders<span></span></p>
    </div>

    <!--order start-->
    <section class="orders">
        <h1 class="title">Orders</h1>
        <div class="box-container">
        
        <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            if($select_orders->rowCount() > 0){
                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
        
        ?>
        
            <div class="box">
                <p> Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                <p> Name : <span><?= $fetch_orders['name']; ?></span></p>
                <p> Number : <span><?= $fetch_orders['number']; ?></span></p>
                <p> Email : <span><?= $fetch_orders['email']; ?></span></p>
                <p> Address : <span><?= $fetch_orders['address']; ?></span></p>
                <p> Payment Method : <span><?= $fetch_orders['method']; ?></span></p>
                <p> Order : <span><?= $fetch_orders['total_products']; ?></span></p>
                <p> Total price : <span> LKR <?= $fetch_orders['total_price']; ?></span></p>
                <p> Payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){echo 'red';}else{echo 'green';} ?>"><?= $fetch_orders['payment_status']; ?></span></p>

            </div>

            <?php
                }
                }else {
                    echo '<p class="empty">No orders placed yet!</p>';
                }
                ?>
        </div>
    </section>


    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>