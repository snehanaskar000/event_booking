<?php
// This file assumes session_start() and auth check has been done in the calling file.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.07);
            border: none;
        }
        .table thead th {
            font-weight: 700;
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
    </style>
</head>
<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h4><i class="fas fa-tachometer-alt"></i> Admin Panel</h4>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="add-event.php"><i class="fas fa-plus-circle"></i> Add Event</a>
    <a href="manage-events.php"><i class="fas fa-list"></i> Manage Events</a>
    <a href="bookings.php"><i class="fas fa-calendar-check"></i> View Bookings</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content" id="main-content">