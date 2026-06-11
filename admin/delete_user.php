<?php
include('../includes/db.php');

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    mysqli_query($conn, "DELETE FROM users WHERE id=$id");

    header("Location: users.php");
    exit();
} else {
    echo "Invalid Request!";
}
?>