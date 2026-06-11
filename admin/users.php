<?php
session_start();
include('../includes/db.php');

if($_SESSION['user_role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

// SEARCH
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
    $query = "SELECT * FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
} else {
    $query = "SELECT * FROM users ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<?php include('includes/header.php'); ?>
<title>Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- ✅ FIX START -->
<div class="main-content">

<div class="container mt-5">

<h2>👥 Users Management</h2>

<!-- SEARCH -->
<form method="GET" class="mb-3">
<input type="text" name="search" placeholder="Search user..." class="form-control" value="<?php echo $search; ?>">
</form>

<table class="table table-bordered">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Status</th>
<th>Last Login</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>

<td>
<?php if($row['status']=='active'){ ?>
<span class="badge bg-success">Active</span>
<?php } else { ?>
<span class="badge bg-danger">Blocked</span>
<?php } ?>
</td>

<td><?php echo $row['last_login'] ?? 'Never'; ?></td>

<td>

<a href="delete_user.php?id=<?php echo $row['id']; ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Are you sure you want to delete this user?')">
   Delete
</a>

<a href="login_history.php?id=<?php echo $row['id']; ?>" 
   class="btn btn-info btn-sm">
   Logs
</a>

</td>
</tr>

<?php } ?>

</table>
</div>

</div>
<!-- ✅ FIX END -->

</body>
</html>
<?php include('includes/footer.php'); ?>