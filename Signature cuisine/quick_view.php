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
    <title>quick view</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
    
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->

    <!--quick view start-->

    <section class="quick-view">
        <h1 class="title">Quick view</h1>

        <?php
            $pid = $_GET['pid']; 
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$pid]);
            if($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="POST" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                    <img src="uploaded_img/<?= $fetch_products['image']; ?>" class="image" alt="">
                    <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
                    <div class="name"><?= $fetch_products['name']; ?></div>
                    <div class="flex">
                        <div class="price"><span>LKR</span><?= $fetch_products['price']; ?></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length ==2) return false"> 
                    </div>
                    <button type="submit" name="add_to_cart" class="cart-btn">Add to cart</button>
            
                    </form>
            <?php
        }  
        } else {
            echo '<div class="empty">No products found</div>';
        }
        ?>
        
     </section>


    </section>

    



    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>