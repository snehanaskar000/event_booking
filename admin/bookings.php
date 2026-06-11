<?php
session_start();
include('../includes/db.php');

// Admin check
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

// Fetch bookings with event name
$result = mysqli_query($conn, "
SELECT b.*, e.title 
FROM bookings b
JOIN events e ON b.event_id = e.id
ORDER BY b.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Bookings</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #f4f6f9;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Sidebar */
.sidebar {
    height: 100vh;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    padding-top: 20px;
    position: fixed;
    width: 250px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.3);
    overflow-y: auto;
    z-index: 1000;
}

.sidebar a {
    color: #ccc;
    text-decoration: none;
    display: block;
    padding: 14px 20px;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.sidebar a:hover,
.sidebar a.active {
    background: #ffc107;
    color: black;
    border-left-color: #ffc107;
    font-weight: 600;
}

.sidebar h4 {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 700;
    font-size: 1.3rem;
    border-bottom: 2px solid #ffc107;
    padding-bottom: 15px;
}

/* Main */
.main-content {
    margin-left: 250px;
    padding: 30px;
    min-height: 100vh;
}

/* Loader/Spinner */
.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #ffc107;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>
        <i class="fas fa-tachometer-alt"></i> Admin Panel
    </h4>
    <a href="dashboard.php">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="add-event.php">
        <i class="fas fa-plus-circle"></i> Add Event
    </a>
    <a href="manage-events.php">
        <i class="fas fa-list"></i> Manage Events
    </a>
    <a href="bookings.php">
        <i class="fas fa-calendar-check"></i> View Bookings
    </a>
    <a href="users.php">
        <i class="fas fa-users"></i> Users
    </a>
    <a href="../logout.php">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" id="main-content">

<h2 class="mb-4 fw-bold">📦 Bookings</h2>

<div class="card shadow-lg border-0" style="border-radius: 20px;">
<div class="card-body">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Event</th>
<th>Qty</th>
<th>Total</th>
<th>Payment ID</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($result) > 0){ ?>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td class="fw-bold">#<?php echo $row['id']; ?></td>

<td>
    <span class="fw-semibold"><?php echo $row['title']; ?></span>
</td>

<td><?php echo $row['quantity']; ?></td>

<td class="text-success fw-bold">
    ₹<?php echo number_format($row['total_price'],2); ?>
</td>

<td>
    <small class="text-muted"><?php echo $row['payment_id']; ?></small>
</td>

<td>
<?php if($row['booking_status']=='confirmed'){ ?>
    <span class="badge bg-success px-3 py-2">Confirmed</span>
<?php } else { ?>
    <span class="badge bg-danger px-3 py-2">Pending</span>
<?php } ?>
</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>
<td colspan="6" class="text-center">No Bookings Found</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.sidebar a');
        const mainContent = document.getElementById('main-content');
        
        // AJAX Navigation
        if (mainContent) {
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    const url = this.getAttribute('href');
                    if (url.includes('logout.php')) return;
                    
                    e.preventDefault();
                    
                    mainContent.innerHTML = `
                        <div style="text-align:center; padding:50px;">
                            <div class="spinner"></div>
                            <p>Loading...</p>
                        </div>
                    `;
                    
                    fetch(url)
                        .then(response => response.text())
                        .then(data => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(data, 'text/html');
                            const newContent = doc.querySelector('.main-content');
                            
                            if (newContent) {
                                mainContent.innerHTML = newContent.innerHTML;
                            } else {
                                mainContent.innerHTML = '<p>Content not found</p>';
                            }
                            
                            links.forEach(l => l.classList.remove('active'));
                            this.classList.add('active');
                            window.history.pushState({}, '', url);
                        })
                        .catch(() => {
                            mainContent.innerHTML = '<p>Error loading page</p>';
                        });
                });
            });
        }

        // Highlight active menu item on page load
        const currentPage = window.location.pathname.split('/').pop();
        
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'bookings.php')) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });
</script>

</body>
</html>