<?php

include 'components/conect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('Location: home.php');
    exit;
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    if(!empty($name)){
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $message[] = 'username updated!';
    }

    if(!empty($email)){
        $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_email->execute([$email]);
        if($select_email->rowCount() > 0){
            $message[] = 'email already taken!';
        }else {
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $message[] = 'email updated!';
        }
    }

    if(!empty($number)){
        $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ?");
        $select_number->execute([$number]);
        if($select_number->rowCount() > 0){
            $message[] = 'number already taken!';   
        }else {
            $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
            $update_number->execute([$number, $user_id]);
            $message[] = 'number updated!';
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_prev_pass = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if($old_pass != $empty_pass){
        if($old_pass != $prev_pass){
            $message[] = 'old password not matched!'; 
        }elseif($new_pass != $confirm_pass){
            $message[] = 'confirm password not matched!';
        }else{
            if($new_pass != $empty_pass){
              $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
              $update_pass->execute([$confirm_pass, $user_id]);
              $message[] = 'password updated!';
            }else{
                $message[] = 'please enter new password!';
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
    <title>update profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <!--header start-->
    <?php include 'components/user_header.php'
    ?>
    <!--header end-->

    <!--update profile start-->
    <section class="form-container">
        <form action="" method="POST">
            <h3>Update profile</h3>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50" class="box">
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="50" class="box">
            <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>" max="9999999999" min="0" maxlength="10" class="box">
            <input type="password" name="old_pass" placeholder="enter your old password" class="box" maxlength="50">
            <input type="password" name="new_pass" placeholder="enter your new password" class="box" maxlength="50">
            <input type="password" name="confirm_pass" placeholder="Confrim your new password" class="box" maxlength="50">
            <input type="submit" value="update now" name="submit" class="btn">
        </form> 
    </section>

    <!--update profile end-->


    <!--footer start-->
     <?php include 'components/footer.php'  
     ?> 
     
     
 
    <script src="JS/Script.js"></script>
</body>
</html>