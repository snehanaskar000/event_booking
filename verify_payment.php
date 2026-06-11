<?php
session_start();
include('includes/db.php');

$user_id = $_SESSION['user_id'];

$event_id = $_GET['event_id'];
$quantity = $_GET['qty'];
$total = $_GET['total'];
$payment_id = $_GET['payment_id'];

// INSERT BOOKING
$query = "INSERT INTO bookings 
(user_id, event_id, quantity, total_price, payment_id, booking_status) 
VALUES 
('$user_id', '$event_id', '$quantity', '$total', '$payment_id', 'confirmed')";

if(mysqli_query($conn, $query)){
    echo "<script>alert('Booking Successful'); window.location='index.php';</script>";
}else{
    echo "Error: " . mysqli_error($conn);
}
?>