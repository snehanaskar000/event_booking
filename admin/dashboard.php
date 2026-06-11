<?php
session_start();
include('../includes/db.php');

/* ================= DATABASE CONNECTION CHECK ================= */
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

/* ================= ADMIN LOGIN CHECK ================= */
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

/* ================= HELPER FUNCTION FOR SAFE COUNTING ================= */
function safeCount($conn, $table, $where = '') {
    $table = mysqli_real_escape_string($conn, $table);
    $query = "SELECT COUNT(*) as total FROM `{$table}`";
    
    if ($where) {
        $query .= " WHERE {$where}";
    }
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        error_log("Database Query Error: " . mysqli_error($conn));
        return 0;
    }
    
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

/* ================= FUNCTION TO CHECK IF COLUMN EXISTS ================= */
function columnExists($conn, $table, $column) {
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    
    $result = mysqli_query($conn, "SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");
    
    if (!$result) {
        return false;
    }
    
    return mysqli_num_rows($result) > 0;
}

/* ================= GET COUNTS ================= */

// Total Events
$total_events = safeCount($conn, 'events');

// Upcoming Events (Check if status column exists)
if (columnExists($conn, 'events', 'status')) {
    $upcoming_events = safeCount($conn, 'events', "status='upcoming'");
} else {
    $upcoming_events = 0;
}

// Completed Events (Check if status column exists)
if (columnExists($conn, 'events', 'status')) {
    $completed_events = safeCount($conn, 'events', "status='completed'");
} else {
    $completed_events = 0;
}

// Total Bookings
$total_bookings = safeCount($conn, 'bookings');

// Total Users
$total_users = safeCount($conn, 'users');

// Get last 5 recent bookings
$recent_bookings_query = mysqli_query($conn, "
    SELECT b.id, b.user_id, b.event_id, b.booking_date, u.name, e.title 
    FROM bookings b 
    LEFT JOIN users u ON b.user_id = u.id 
    LEFT JOIN events e ON b.event_id = e.id 
    ORDER BY b.booking_date DESC 
    LIMIT 5
");

if (!$recent_bookings_query) {
    error_log("Recent bookings query failed: " . mysqli_error($conn));
    $recent_bookings = [];
} else {
    $recent_bookings = [];
    while ($row = mysqli_fetch_assoc($recent_bookings_query)) {
        $recent_bookings[] = $row;
    }
}

// Get last 5 recent events
$recent_events_query = mysqli_query($conn, "
    SELECT id, title, event_date, created_at 
    FROM events 
    ORDER BY created_at DESC 
    LIMIT 5
");

if (!$recent_events_query) {
    error_log("Recent events query failed: " . mysqli_error($conn));
    $recent_events = [];
} else {
    $recent_events = [];
    while ($row = mysqli_fetch_assoc($recent_events_query)) {
        $recent_events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
document.addEventListener("DOMContentLoaded", function () {

    const links = document.querySelectorAll(".sidebar a");
    const mainContent = document.getElementById("main-content");

    links.forEach(link => {
        link.addEventListener("click", function (e) {

            const url = this.getAttribute("href");

            // Ignore logout
            if (url.includes("logout.php")) return;

            e.preventDefault();

            // Show loader
            mainContent.innerHTML = `
                <div style="text-align:center; padding:50px;">
                    <div class="spinner"></div>
                    <p>Loading...</p>
                </div>
            `;

            fetch(url)
                .then(response => response.text())
                .then(data => {

                    // Extract only main content from loaded page
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, "text/html");
                    const newContent = doc.querySelector(".main-content");

                    if (newContent) {
                        mainContent.innerHTML = newContent.innerHTML;
                    } else {
                        mainContent.innerHTML = "<p>Content not found</p>";
                    }

                    // Update active menu
                    links.forEach(l => l.classList.remove("active"));
                    this.classList.add("active");

                    // Change URL (no reload)
                    window.history.pushState({}, "", url);

                })
                .catch(() => {
                    mainContent.innerHTML = "<p>Error loading page</p>";
                });

        });
    });

});
</script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ================= SIDEBAR STYLES ================= */
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

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 1.3rem;
            border-bottom: 2px solid #ffc107;
            padding-bottom: 15px;
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

        /* ================= MAIN CONTENT STYLES ================= */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #dee2e6;
        }

        .page-header h2 {
            font-weight: 700;
            color: #1a1a1a;
        }

        /* ================= CARD BOX STYLES ================= */
        .card-box {
            border-radius: 12px;
            padding: 25px;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .card-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-box h5 {
            font-size: 0.95rem;
            font-weight: 600;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .card-box h2 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .card-box .card-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        /* ================= COLOR CLASSES ================= */
        .bg-blue { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
        .bg-green { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); }
        .bg-orange { background: linear-gradient(135deg, #fd7e14 0%, #e65100 100%); }
        .bg-purple { background: linear-gradient(135deg, #6f42c1 0%, #4c2a85 100%); }
        .bg-pink { background: linear-gradient(135deg, #e83e8c 0%, #bd2130 100%); }
        .bg-info { background: linear-gradient(135deg, #17a2b8 0%, #0c5460 100%); }

        /* ================= ACTION BUTTONS ================= */
        .quick-actions {
            margin-top: 40px;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .quick-actions h4 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            margin-bottom: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* ================= TABLE STYLES ================= */
        .recent-section {
            margin-top: 40px;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .recent-section h4 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .table {
            font-size: 0.95rem;
        }

        .table thead th {
            background: #f8f9fa;
            font-weight: 700;
            color: #1a1a1a;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr {
            transition: background 0.3s ease;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ================= RESPONSIVE DESIGN ================= */
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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .card-box h2 {
                font-size: 1.8rem;
            }

            .card-box {
                padding: 20px;
            }

            .table {
                font-size: 0.85rem;
            }
        }

        /* ================= LOADER/SPINNER ================= */
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

        /* ================= EMPTY STATE ================= */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>


<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h4>
        <i class="fas fa-tachometer-alt"></i> Admin Panel
    </h4>

    <a href="dashboard.php" class="active">
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

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content" id="main-content">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <div>
            <h2>Dashboard Overview</h2>
            <p class="text-muted mb-0">Welcome back! Here's what's happening.</p>
        </div>
        <div>
            <small class="text-muted">Last updated: <?php echo date('M d, Y - h:i A'); ?></small>
        </div>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="row g-4 mb-5">

        <!-- TOTAL EVENTS CARD -->
        <div class="col-md-6 col-lg-3">
            <div class="card-box bg-blue h-100">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h5>Total Events</h5>
                <h2><?php echo $total_events; ?></h2>
                <small><a href="manage-events.php" class="text-white" style="text-decoration: none;">View all →</a></small>
            </div>
        </div>

        <!-- UPCOMING EVENTS CARD -->
        <div class="col-md-6 col-lg-3">
            <div class="card-box bg-green h-100">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h5>Upcoming Events</h5>
                <h2><?php echo $upcoming_events; ?></h2>
                <small><a href="manage-events.php" class="text-white" style="text-decoration: none;">View all →</a></small>
            </div>
        </div>

        <!-- COMPLETED EVENTS CARD -->
        <div class="col-md-6 col-lg-3">
            <div class="card-box bg-orange h-100">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5>Completed Events</h5>
                <h2><?php echo $completed_events; ?></h2>
                <small><a href="manage-events.php" class="text-white" style="text-decoration: none;">View all →</a></small>
            </div>
        </div>

        <!-- TOTAL BOOKINGS CARD -->
        <div class="col-md-6 col-lg-3">
            <div class="card-box bg-purple h-100">
                <div class="card-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h5>Total Bookings</h5>
                <h2><?php echo $total_bookings; ?></h2>
                <small><a href="bookings.php" class="text-white" style="text-decoration: none;">View all →</a></small>
            </div>
        </div>

        <!-- TOTAL USERS CARD -->
        <div class="col-md-6 col-lg-3">
            <div class="card-box bg-pink h-100">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5>Total Users</h5>
                <h2><?php echo $total_users; ?></h2>
                <small><a href="users.php" class="text-white" style="text-decoration: none;">View all →</a></small>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="quick-actions">
        <h4>
            <i class="fas fa-lightning-bolt text-warning"></i> Quick Actions
        </h4>
        <div class="d-flex flex-wrap gap-2">
            <a href="add-event.php" class="btn btn-dark">
                <i class="fas fa-plus"></i> Add New Event
            </a>
            <a href="manage-events.php" class="btn btn-warning">
                <i class="fas fa-edit"></i> Manage Events
            </a>
            <a href="bookings.php" class="btn btn-info text-white">
                <i class="fas fa-list"></i> View Bookings
            </a>
            <a href="users.php" class="btn btn-primary">
                <i class="fas fa-user-cog"></i> Manage Users
            </a>
        </div>
    </div>

    <!-- RECENT EVENTS -->
    <?php if (!empty($recent_events)): ?>
    <div class="recent-section">
        <h4>
            <i class="fas fa-history"></i> Recent Events
        </h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Event Date</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_events as $event): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($event['title'] ?? 'N/A'); ?></strong>
                        </td>
                        <td>
                            <?php 
                            $event_date = $event['event_date'] ?? 'N/A';
                            if ($event_date !== 'N/A') {
                                echo date('M d, Y', strtotime($event_date));
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            $created_date = $event['created_at'] ?? date('Y-m-d H:i:s');
                            echo date('M d, Y', strtotime($created_date));
                            ?>
                        </td>
                        <td>
                            <a href="manage-events.php?edit=<?php echo $event['id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="recent-section">
        <h4>
            <i class="fas fa-history"></i> Recent Events
        </h4>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>No events found</p>
            <a href="add-event.php" class="btn btn-primary mt-3">Create First Event</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- RECENT BOOKINGS -->
    <?php if (!empty($recent_bookings)): ?>
    <div class="recent-section">
        <h4>
            <i class="fas fa-history"></i> Recent Bookings
        </h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>Event Title</th>
                        <th>Booking Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_bookings as $booking): ?>
                    <tr>
                        <td>
                            <strong>#<?php echo $booking['id']; ?></strong>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($booking['name'] ?? 'Unknown'); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($booking['title'] ?? 'Unknown Event'); ?>
                        </td>
                        <td>
                            <?php echo date('M d, Y - h:i A', strtotime($booking['booking_date'])); ?>
                        </td>
                        <td>
                            <a href="bookings.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="recent-section">
        <h4>
            <i class="fas fa-history"></i> Recent Bookings
        </h4>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>No bookings found yet</p>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Highlight active menu item
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.sidebar a');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'dashboard.php')) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });
</script>

</body>
</html>