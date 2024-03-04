<?php

include 'components/conect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_products = filter_var($total_products, FILTER_SANITIZE_STRING);
    $total_price = $_POST['total_price'];
    $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){

        if($address == ''){
            $message[] = 'please enter your address!';
        }else {

            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);
        
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'order placed successfully!';
        
        }

    }else {
        $message[] = 'your cart is empty!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ckeckout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->
    <div class="heading">
        <h3>CheckOut</h3>
        <p><a href="index.php">Home</a>  / CheckOut<span></span></p>
    </div>

    <!--checkout start-->
    <section class="checkout">
        <h1 class="title">Order Summary</h1>
        <form action="" method="post">

        <div class="cart-items">
            <h3>Cart Items</h3>
            <?php
            $grand_total = 0;
            $cart_items[] = ''; 
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].'x'.$fetch_cart['quantity'].') - ';
                $total_products = implode($cart_items);
                $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);        
            ?>
            <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price"> LKR <?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?> </span></p>
            <?php
                    }
                }else{
                    echo '<p class="empty">your cart is empty</p>';
                }
            ?>
            <p class="grand-total"><div class="name">Grand total : </div> <span class="price"> LKR <?= $grand_total;?></span></p>
            <a href="cart.php" class="btn">View cart</a>
        </div>
        <input type="hidden" name="total_products" value="<?= $total_products; ?>">
        <input type="hidden" name="total_price" value="<?= $grand_total; ?> " value="">
        <input type="hidden" name="name" value="<?= $fetch_profile['name']; ?>">
        <input type="hidden" name="email" value="<?= $fetch_profile['email']; ?>">
        <input type="hidden" name="number" value="<?= $fetch_profile['number']; ?>">
        <input type="hidden" name="address" value="<?= $fetch_profile['address']; ?>">

        <div class="user-info">
            <h3>Your info</h3>
            <p><i class="fas fa-user"></i> <span><?= $fetch_profile['name']; ?></span> </p>
            <p><i class="fas fa-envelope"></i> <span><?= $fetch_profile['email']; ?></span> </p>
            <p><i class="fas fa-phone"></i> <span><?= $fetch_profile['number']; ?></span> </p>
            <a href="update_profile.php" class="btn" style="margin-bottom: 1rem">Update info</a>
            <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address!';}else{ echo $fetch_profile['address'];}; ?></span></p>
            <a href="update_address.php" class="btn">Update address</a>
            <select name="method" class="select-box" required>
                <option value="" disabled selected>Select payment method</option>
                <option value="cash on delevary">cash on delevary</option>
                <option value="Credit card">Credit card</option>
                <option value="Master card">Master card</option>
            </select>
            <input type="submit" value="place order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" name="submit"> 
        </div>
            
        </form>
    </section>
    <!--checkout end-->

    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>