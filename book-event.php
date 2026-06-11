<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// Check event ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$event_id = intval($_GET['id']);

// Fetch event
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: events.php");
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check status
if ($event['status'] != 'upcoming') {
    header("Location: events.php");
    exit();
}
?>

<style>
.event-detail-hero {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
    url('https://images.unsplash.com/photo-1506157786151-b8491531f063');
    background-size: cover;
    background-position: center;
    padding: 100px 0;
    text-align: center;
    color: white;
}

.booking-form {
    background: rgba(255,255,255,0.05);
    border: 1px solid #6366f1;
    border-radius: 24px;
    padding: 40px;
    max-width: 500px;
    margin-top: 20px;
}

.price-display {
    font-size: 2rem;
    font-weight: bold;
    color: #ffc107;
}

.btn-pay {
    background: linear-gradient(135deg,#7c3aed,#ec4899);
    border: none;
    padding: 14px;
    border-radius: 12px;
    color: white;
    font-weight: bold;
}
</style>

<!-- HERO -->
<section class="event-detail-hero">
    <div class="container">
        <h1><?php echo htmlspecialchars($event['title']); ?></h1>
        <p><?php echo htmlspecialchars($event['description']); ?></p>
    </div>
</section>

<!-- DETAILS -->
<div class="container py-5">
    <div class="row">

        <!-- IMAGE -->
        <div class="col-md-6">
            <img src="uploads/<?php echo htmlspecialchars($event['event_image']); ?>" 
                 class="img-fluid rounded">
        </div>

        <!-- BOOKING -->
        <div class="col-md-6">
            <h3>Event Details</h3>
            <p><b>Date:</b> <?php echo date("d M Y", strtotime($event['event_date'])); ?></p>
            <p><b>Location:</b> <?php echo htmlspecialchars($event['location']); ?></p>
            <p><b>Price:</b> ₹<?php echo number_format($event['price'],2); ?></p>

            <!-- ✅ PAYMENT FORM -->
            <form method="POST" action="payment.php" class="booking-form">

                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <input type="hidden" name="unit_price" value="<?php echo $event['price']; ?>">

                <label>Tickets</label>
                <input type="number" id="qty" name="quantity" value="1" min="1" max="10" class="form-control mb-3">

                <p>Total: <span class="price-display" id="total">
                    ₹<?php echo number_format($event['price'],2); ?>
                </span></p>

                <button type="submit" class="btn-pay w-100">
                    Proceed to Payment
                </button>

            </form>
        </div>
    </div>
</div>

<script>
let qty = document.getElementById('qty');
let total = document.getElementById('total');
let price = <?php echo $event['price']; ?>;

qty.addEventListener('input', function(){
    let q = parseInt(this.value) || 1;
    total.innerHTML = "₹" + (q * price).toFixed(2);
});
</script>

<?php include('includes/footer.php'); ?>