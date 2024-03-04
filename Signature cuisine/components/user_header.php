<?php
if(isset($message)){
    foreach($message as $msg) {
        echo '
        <div class="message">
        <span>'.$msg.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>
        ';
    }   
}
?>

<header class="header">
    <section class="flex">
        <a href="index.php" class="logo">Signature cuisine</a>
        <nav class="navbar">
           <a href="index.php">Home</a>
           <a href="about.html">About</a>
           <a href="menu.php">Menu</a>
           <a href="orders.php">Orders</a>
           <a href="facilites.html">Facility</a>
           <a href="reservation.php">Reservation</a>
           <a href="reservation.php"></a>
        </nav>

        <div class="icons">
            <?php
               $count_user_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
               $count_user_cart_items->execute([$user_id]);
               $total_user_cart_items = $count_user_cart_items->rowCount();
            ?>
           <a href="search.php"><i class="fas fa-search"></i></a>
           <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?=$total_user_cart_items; ?>)</span></a>
           <div id="user-btn" class="fas fa-user"></div>
           
           <div id="menu-btn" class="fas fa-bars"></div>
           
        </div>
        
        <div class="profile">
        <?php 
           $select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
           $select_profile->execute([$user_id]);
           if($select_profile->rowCount() >0){
             $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p class="name"><?= $fetch_profile['name']; ?></p>
        <div class="flex">
            <a href="profile.php" class="btn">Profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">Logout</a>
        </div>
        <p class="account"><a href="register.php">Register</a> or <a href="login.php">Login</a> </p>
        <?php
        }
        else{
        ?>
            <p class="name">Please login first</p>
            <a href="login.php" class="btn">Login</a>
        <?php
        }
        ?>
        </div>
        
    </section>

</header>
