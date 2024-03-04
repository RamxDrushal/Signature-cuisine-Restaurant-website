<?php

include 'components/conect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if(isset($_POST['update_qty'])){
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
    $message[] = 'cart quantity updated!';
}

if(isset($_POST['delete_cart'])){
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart->execute([$cart_id]);
    $message[] = 'cart item deleted!'; 
}

if(isset($_POST['delete_all'])){
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);
    $message[] = 'deleted all from cart!'; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">

</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->
    <div class="heading">
        <h3>Shopping Cart</h3>
        <p><a href="index.php">Home</a>  / Cart<span></span></p>
    </div>


    <!--cart start-->
    <section class="products">
        <h1 class="title">Your cart</h1>
        <div class="box-container">
        <?php
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
                while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){

               
        ?>
        <form action="" method="POST" class="box">
            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
            <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
            <button type="submit" name="delete_cart" class="fas fa-times" onclick="return confirm('delete this item form cart?');"></button>
            <img src="uploaded_img/<?= $fetch_cart['image']; ?>" class="image" alt="">
            <div class="name"><?= $fetch_cart['name']; ?></div>
            <div class="flex">
                <div class="price"><span>LKR</span><?= $fetch_cart['price']; ?></div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" onkeypress="if(this.value.length ==2) return false">
                <button type="submit" name="update_qty" class="fas fa-edit"></button> 
            </div>
            <div class="sub-total">sub total : <span>LKR <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></div>
        </form>
        <?php
            $grand_total += $sub_total;
                    }
                }else{
                    echo '<p class="empty">your cart is empty</p>';
                }
        
        ?>
        </div>
        <div class="cart-total">
            <p class="grand-total">Grand total : <span>LKR <?= $grand_total; ?></span></p>
            <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled' ?>">Proceed to checkout</a>
        </div>        

        <div class="more-btn">
            <form action="" method="post">
                <button type="submit" class="delete-btn" name="delete_all">Delete All</button>
            </form>
        </div>
    </section>

    <!--cart end-->

    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>