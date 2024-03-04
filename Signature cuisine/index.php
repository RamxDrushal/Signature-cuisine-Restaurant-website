<?php

include 'components/conect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

include 'components/addcart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
    <style>
    </style>
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php' ?>
    
     <!--header end-->

     <!--home section start-->
     <section class="hero">
        <div class="swiper hero-slider"> 
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <div class="content">
                        
                        <h3>Delicious Pizza</h3>
                        <a href="menu.php" class="btn">See more</a>
                    </div>
                    <div class="image">
                        <img src="Images/pizza.png" alt="">
                    </div>
                </div>

                <div class="swiper-slide slide">
                    <div class="content">
                        
                        <h3>Main Dishes</h3>
                        <a href="menu.php" class="btn">See menus</a>
                    </div>
                    <div class="image">
                        <img src="Images/nasi.png" alt="">
                    </div>
                </div>

                <div class="swiper-slide slide">
                        <div class="content">
                        
                        <h3>Burgers</h3>
                        <a href="menu.php" class="btn">See menus</a>
                    </div>
                    <div class="image">
                        <img src="Images/burger.png" alt="">
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
     </section>
     <!--home section end-->

     <!--category start-->
     <section class="category">
        <h1 class="title">Category of Signature Cuisine Restaurant</h1>
        <div class="box-container">
            <a href="category.php?category=fast food" class="box">
            <img src="Images/fast food.png" alt="">
            <h3>Fast Food</h3>
            </a>

            <a href="category.php?category=main dish" class="box">
            <img src="Images/main dishes.png" alt="">
            <h3>Main Dishes</h3>
            </a>

            <a href="category.php?category=drinks" class="box">
            <img src="Images/Drinks.png" alt="">
            <h3>Drinks</h3>
            </a>

            <a href="category.php?category=desserts" class="box">
            <img src="Images/desserts.png" alt="">
            <h3>Desserts</h3>
            </a>

        </div>
     </section>
     <!--category end-->

     <!--Prouducts start-->

    <section class="products">
        <h1 class="title">Latest Foods</h1>
            <div class="box-container">
            <?php 
            $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
            $select_products->execute();
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="POST" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                    <button type="submit" name="add_to_cart" class="fas fa-shopping-cart"></button>
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>" class="image" alt="">
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="flex">
                        <div class="price"><span>LKR</span><?= $fetch_products['price']; ?></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length ==2) return false"> 
                    </div>
            
                    </form>
            <?php
        }  
        } else {
            echo '<div class="empty">No products added yet</div>';
        }
        ?>
        </div>
        <div class="more-btn">
            <a href="menu.php" class="btn">More Foods</a>
        </div>
     </section>

     <!--Prouducts end-->

     <!--footer start-->
     <?php include 'components/footer.php' ?>   
     
     
     
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="JS/Script.js"></script>

    <script>
           var swiper = new Swiper(".hero-slider", {
             loop:true,
             grabCursor: true,
             effect: "flip",
             pagination: {
             el: ".swiper-pagination",
             clickable:true,
             },
             });
     </script>
</body>
</html>