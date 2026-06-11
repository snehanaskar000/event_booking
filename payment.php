<?php
session_start();
include('includes/db.php');

$event_id = $_POST['event_id'];
$quantity = $_POST['quantity'];
$price = $_POST['unit_price'];

$total = $quantity * $price;
?>

<!DOCTYPE html>
<html>
<head>
<title>Secure Payment</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
body{
    background: linear-gradient(135deg,#0f172a,#1e293b);
    color:white;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: 'Segoe UI', sans-serif;
}

.payment-box{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    padding:40px;
    border-radius:20px;
    text-align:center;
    width:100%;
    max-width:400px;
    box-shadow:0 20px 40px rgba(0,0,0,0.4);
}

.pay-btn{
    background:#6366f1;
    border:none;
    padding:14px;
    width:100%;
    color:white;
    border-radius:12px;
    font-weight:bold;
    transition:0.3s;
}

.pay-btn:hover{
    background:#4f46e5;
    transform:translateY(-3px);
}

.loader{
    display:none;
}
</style>

</head>
<body>

<div class="payment-box">

    <h3 class="mb-3">Complete Your Payment</h3>

    <p class="mb-4">Total Amount</p>

    <h1 class="text-warning mb-4">₹<?php echo number_format($total,2); ?></h1>

    <button id="payBtn" class="pay-btn">
        Pay Securely 💳
    </button>

    <div class="loader mt-3" id="loadingText">
        Processing...
    </div>

</div>

<script>

var options = {
    "key": "rzp_test_STui2tERIeLURC",
    "amount": "<?php echo $total * 100; ?>",
    "currency": "INR",
    "name": "EventBook",
    "description": "Event Booking Payment",

    "theme": {
        "color": "#6366f1"
    },

    "handler": function (response){

        document.getElementById("loadingText").style.display = "block";

        window.location.href = "verify_payment.php?payment_id=" + response.razorpay_payment_id +
        "&event_id=<?php echo $event_id; ?>&qty=<?php echo $quantity; ?>&total=<?php echo $total; ?>";
    }
};

var rzp = new Razorpay(options);

// Auto open payment (🔥 pro feel)
window.onload = function(){
    rzp.open();
}

// Button click
document.getElementById('payBtn').onclick = function(e){
    rzp.open();
    e.preventDefault();
}

</script>

</body>
</html>