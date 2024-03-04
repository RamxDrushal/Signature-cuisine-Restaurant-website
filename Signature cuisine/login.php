<?php

include 'components/conect.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if(isset($_POST['submit'])){

    $email = $_POST['email']; 
    $email = filter_var($email, FILTER_SANITIZE_STRING); 
    $pass = sha1($_POST['pass']); 
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){  
        $_SESSION['user_id'] = $row['id']; 
        header('location:index.php');  
    }else { 
        $message[] = 'incorrect email or password!'; 
    } 
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end--> 

    <!--Login start-->
        <section class="form-container">
        <form action="" method="POST">
        <h3>Login Now</h3>
        <input type="email" name="email" required placeholder="enter your email"  maxlength="50" required class="box">
        <input type="password" name="pass" required placeholder="enter your password" min="0"  maxlength="10" required class="box">
        <input type="submit" value="login now" name="submit" class="btn"> 
        <p>don't have an account? <a href="register.php">Register Now</a></p>
        <p class="admin-Lgin">Admin login Only</p>
        <a href="admin/admin_login.php" class="btn">Admin</a>
        </form>
        </section>
        


    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>