<?php
session_start();
include('../includes/db.php');

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

$id = intval($_GET['id']);
$event = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM events WHERE id = '$id'"));

if(isset($_POST['update_event'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = $_POST['event_date'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = $_POST['price'];
    $status = $_POST['status'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Image Update Logic
    if(!empty($_FILES['event_image']['name'])){
        $image = time() . "_" . $_FILES['event_image']['name'];
        move_uploaded_file($_FILES['event_image']['tmp_name'], "../uploads/" . $image);
        
        // Delete old image
        if(file_exists("../uploads/" . $event['event_image'])){
            unlink("../uploads/" . $event['event_image']);
        }
        
        $sql = "UPDATE events SET title='$title', event_date='$date', location='$location', price='$price', status='$status', description='$description', event_image='$image' WHERE id='$id'";
    } else {
        $sql = "UPDATE events SET title='$title', event_date='$date', location='$location', price='$price', status='$status', description='$description' WHERE id='$id'";
    }

    if(mysqli_query($conn, $sql)){
        header("Location: manage-events.php?msg=updated");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white"><h4>Edit Event Details</h4></div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>Event Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo $event['title']; ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Date</label>
                                    <input type="date" name="event_date" class="form-control" value="<?php echo $event['event_date']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control" value="<?php echo $event['price']; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="<?php echo $event['location']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="upcoming" <?php if($event['status']=='upcoming') echo 'selected'; ?>>Upcoming</option>
                                    <option value="completed" <?php if($event['status']=='completed') echo 'selected'; ?>>Completed</option>
                                    <option value="cancelled" <?php if($event['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Current Image</label><br>
                                <img src="../uploads/<?php echo $event['event_image']; ?>" width="100" class="mb-2 rounded">
                                <input type="file" name="event_image" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4"><?php echo $event['description']; ?></textarea>
                            </div>
                            <button type="submit" name="update_event" class="btn btn-success w-100">Update Event</button>
                            <a href="manage-events.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>