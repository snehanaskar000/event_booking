<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* 1. DATABASE CONNECTION */
$host = "localhost";
$user = "root";
$pass = "";
$db   = "event_platform"; 
$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Database Failed: ".$conn->connect_error);
}

/* 2. BLOCK DIRECT ACCESS */
// Ensures user is logged in and coming from a POST request
if(!isset($_SESSION['user_id']) || !isset($_POST['confirm_booking'])){
    header("Location: index.php");
    exit();
}

$bookingSuccess = false;

/* 3. BOOKING SUBMIT LOGIC */
if(isset($_POST['confirm_booking'])){

    $user_id = $_SESSION['user_id'];
    $event_id = intval($_POST['event_id']);
    $quantity = intval($_POST['quantity']);
    
    // Safety check: Quantity must be at least 1
    if($quantity < 1) { $quantity = 1; }

    /* 4. RE-CALCULATE TOTAL (ANTI-PRICE HACK) */
    // Just like your chef logic, we fetch the price directly from the DB 
    // instead of trusting the price sent from the browser.
    $stmt_price = $conn->prepare("SELECT price FROM events WHERE id = ?");
    $stmt_price->bind_param("i", $event_id);
    $stmt_price->execute();
    $res_price = $stmt_price->get_result();
    $event_data = $res_price->fetch_assoc();
    
    if(!$event_data) {
        die("Invalid Event ID");
    }

    $unit_price = $event_data['price'];
    $total_price = $unit_price * $quantity;

    /* 5. PREPARED INSERT */
    // Matching your 'bookings' table structure
    $stmt = $conn->prepare("INSERT INTO bookings 
        (event_id, user_id, quantity, total_price, payment_status, booking_status) 
        VALUES (?, ?, ?, ?, 'pending', 'confirmed')");

    $stmt->bind_param("iiid", $event_id, $user_id, $quantity, $total_price);

    if($stmt->execute()){
        $bookingSuccess = true;
    } else {
        echo "Insert Error: " . $stmt->error;
    }

    $stmt->close();
    $stmt_price->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: white; font-family: 'Plus Jakarta Sans', sans-serif; }
        .box { background: rgba(255,255,255,0.05); border: 1px solid #6366f1; border-radius: 24px; padding: 40px; }
        .gold { color: #6366f1; font-weight: 800; }
    </style>
</head>
<body>
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <?php if($bookingSuccess): ?>
                    <div class="box text-center shadow-lg">
                        <i class="bi bi-check-circle-fill text-success display-1 mb-4"></i>
                        <h2 class="fw-bold mb-3 text-success">Booking Confirmed!</h2>
                        <p class="opacity-75 mb-4">Your tickets have been reserved successfully. You can view your receipt in your dashboard.</p>
                        <div class="p-3 mb-4 rounded-3" style="background: rgba(99, 102, 241, 0.1);">
                            <span class="d-block small text-uppercase">Total Paid</span>
                            <span class="h2 fw-bold gold">₹<?php echo number_format($total_price, 2); ?></span>
                        </div>
                        <a href="index.php" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow">Return to Home</a>
                    </div>
                <?php else: ?>
                    <div class="box text-center border-danger">
                        <h3 class="text-danger">Processing Error</h3>
                        <p>Something went wrong with your reservation. Please try again.</p>
                        <a href="index.php" class="btn btn-warning">Back to Events</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>