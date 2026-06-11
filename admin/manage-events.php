<?php
session_start();
include('../includes/db.php');

/* --- DELETE EVENT --- */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $get_img = mysqli_fetch_assoc(mysqli_query($conn, "SELECT event_image FROM events WHERE id='$id'"));
    
    if($get_img){
        $image_path = "../uploads/" . $get_img['event_image'];
        
        if(file_exists($image_path)){
            unlink($image_path);
        }

        mysqli_query($conn, "DELETE FROM events WHERE id='$id'");
    }

    header("Location: manage-events.php");
    exit();
}

/* --- FETCH EVENTS --- */
$events = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");

/* ✅ CHECK AJAX */
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);
?>

<?php if(!$isAjax){ ?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Events</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background-color: #f4f6f9; }

.sidebar {
    height: 100vh;
    background: #111;
    color: white;
    padding-top: 20px;
    position: fixed;
    width: 250px;
}

.sidebar a {
    color: white;
    text-decoration: none;
    display: block;
    padding: 12px 20px;
}

.sidebar a:hover {
    background: #ffc107;
    color: black;
}

.main-content {
    margin-left: 250px;
    padding: 30px;
}
</style>
</head>
<body>

<!-- SIDEBAR (ONLY NORMAL LOAD) -->
<div class="sidebar">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="add-event.php">➕ Add Event</a>
    <a href="manage-events.php">📋 Manage Events</a>
    <a href="#">📦 Bookings</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

<?php } ?>

<!-- ✅ ALWAYS LOAD THIS -->
<div class="main-content">

<h2 class="mb-4">Manage Events</h2>

<div class="card shadow">
<div class="card-body">

<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Image</th>
<th>Title</th>
<th>Date</th>
<th>Location</th>
<th>Price</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($events)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>

<td>
<img src="../uploads/<?php echo $row['event_image']; ?>" width="70">
</td>

<td><?php echo $row['title']; ?></td>

<td><?php echo date("d M Y", strtotime($row['event_date'])); ?></td>

<td><?php echo $row['location']; ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td>
<?php
if($row['status']=='upcoming'){
echo "<span class='badge bg-success'>Upcoming</span>";
}elseif($row['status']=='completed'){
echo "<span class='badge bg-secondary'>Completed</span>";
}else{
echo "<span class='badge bg-danger'>Cancelled</span>";
}
?>
</td>

<td>
<a href="edit-event.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>

<a href="manage-events.php?delete=<?php echo $row['id']; ?>" 
class="btn btn-sm btn-danger"
onclick="return confirm('Delete?')">Delete</a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>

</div>

<?php if(!$isAjax){ ?>
</body>
</html>
<?php } ?>