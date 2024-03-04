<?php

include '../components/conect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

$sql = "SELECT * FROM `reservation`";
$stmt = $conn->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reservations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <?php include '../components/admin_header.php' ?>
    <h1 class="reservation-title">Admin Reservations</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <?php
        if (count($reservations) > 0) {

            foreach ($reservations as $row) {
                echo "<tr><td>" . $row["name"] . "</td><td>" . $row["phone"] . "</td><td>" . $row["email"] . "</td><td>" . $row["date"] . "</td><td>" . $row["time"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 results</td></tr>";
        }
        ?>
    </table>

    <?php
    if (count($reservations) === 0) {
        echo '<p class="empty">No orders placed yet!</p>';
    }
    ?>

</body>
</html>