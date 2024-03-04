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
    $pass = sha1($_POST['pass']); 
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
    $select_user->execute([$email, $number]);
    

    if($select_user->rowCount() > 0){
        $message[] = 'email or number is already taken!';
    }else {
        if($pass != $cpass){
            $message[] = 'confirm password not matched!';
        }else {
            $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?) ");
            $insert_user->execute([$name, $email, $number, $cpass]);
            $confirm_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
            $confirm_user->execute([$email, $cpass]);
            $row = $confirm_user->fetch(PDO::FETCH_ASSOC);
            if($confirm_user->rowCount() >0){
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejister</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
     <!--header end-->

     <!--register start-->
     <section class="form-container">
        <form action="" method="POST">
        <h3>Register Now</h3>
        <input type="text" name="name" required placeholder="enter your name"  maxlength="50" required class="box">
        <input type="email" name="email" required placeholder="enter your email"  maxlength="50" required class="box">
        <input type="number" name="number" required placeholder="enter your number"  maxlength="9999999999" required class="box">
        <input type="password" name="pass" required placeholder="enter your password" min="0"  maxlength="10" required class="box">
        <input type="password" name="cpass" required placeholder="confrim your password" min="0"  maxlength="10" required class="box">
        <input type="submit" value="register now" name="submit" class="btn">
        <p>already have an account? <a href="login.php">Login Now</a></p>
        </form>
     </section>

     <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>