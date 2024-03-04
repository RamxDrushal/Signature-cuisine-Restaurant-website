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
    <title>Search page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
    <style>
        
    </style>
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->

    <div class="heading">
        <h3>Search</h3>
        <p><a href="index.php">Home</a>  / Search<span></span></p>

    <!--search start-->
    <section class="search-form">
        <form action="" method="POST">
            <input type="text" name="search_box" placeholder="search here.." required maxlength="100" class="box">
            <button type="submit" name="search_btn" class="fas fa-search"></button>
        </form>
    </section>
    <!--search end-->

    <section class="products">
        
            <div class="box-container">
            <?php
            if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
            $search_box = $_POST['search_box'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
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