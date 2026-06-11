<?php
include('../includes/db.php');

if(isset($_POST['add_event'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Image Upload
    $image = $_FILES['event_image']['name'];
    $tmp_name = $_FILES['event_image']['tmp_name'];

    move_uploaded_file($tmp_name, "../uploads/$image");

    $query = "INSERT INTO events 
              (title, description, category, event_date, event_time, location, price, event_image, status)
              VALUES
              ('$title','$description','$category','$event_date','$event_time','$location','$price','$image','$status')";

    mysqli_query($conn, $query);

    echo "<script>alert('Event Added Successfully'); window.location='add-event.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Event</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ IMPORTANT WRAPPER (FIX) -->
<div class="main-content">

<div class="container mt-5">
    <h2>Add New Event</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Event Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Time</label>
            <input type="time" name="event_time" class="form-control">
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control">
        </div>

        <div class="mb-3">
            <label>Event Image</label>
            <input type="file" name="event_image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="upcoming">Upcoming</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" name="add_event" class="btn btn-dark">
            Add Event
        </button>

    </form>
</div>

</div>
<!-- ✅ END FIX -->

</body>
</html>