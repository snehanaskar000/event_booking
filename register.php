<?php
include('includes/db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";
$message_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $raw_password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($raw_password)) {
        $message = "All required fields must be filled.";
        $message_type = "danger";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email already exists.";
            $message_type = "danger";
            $stmt->close();
        } else {
            $stmt->close();

            $password = password_hash($raw_password, PASSWORD_DEFAULT);
            $role = "user";
            $status = "active";

            $insert = $conn->prepare("
                INSERT INTO users (name, email, phone, password, role, status)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $insert->bind_param("ssssss", $name, $email, $phone, $password, $role, $status);

            if ($insert->execute()) {
                $message = "Registration successful. Please login.";
                $message_type = "success";
            } else {
                $message = "Something went wrong. Try again.";
                $message_type = "danger";
            }

            $insert->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | EventBook</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-accent: #7c3aed;
            --secondary-accent: #ec4899;
            --dark-deep: #0f172a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fdfdfd;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-container {
            max-width: 1000px;
            width: 95%;
            margin: auto;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .register-side-info {
            background: linear-gradient(135deg, var(--dark-deep) 0%, #1e1b4b 100%);
            width: 45%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
        }

        .register-side-info::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: var(--primary-accent);
            filter: blur(80px);
            top: 10%;
            right: 10%;
            opacity: 0.4;
        }

        .register-form-content {
            width: 55%;
            padding: 60px;
        }

        .brand-logo {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-title {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--dark-deep);
            margin-bottom: 10px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 0.95rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
            border-color: var(--primary-accent);
        }

        .btn-register {
            background: var(--dark-deep);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
            color: white;
        }

        .custom-alert {
            border-radius: 12px;
            border: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        @media (max-width: 991px) {
            .register-side-info { display: none; }
            .register-form-content { width: 100%; padding: 40px; }
            .register-container { max-width: 500px; }
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-side-info">
        <a href="index.php" class="brand-logo">
            <i class="bi bi-calendar-event-fill text-warning"></i>
            EventBook
        </a>
        <div>
            <h1 class="fw-800 display-5">Join the <span class="text-warning">Experience.</span></h1>
            <p class="opacity-75">Create your account to explore premium events, conferences, concerts, and workshops near you.</p>
        </div>
        <div class="small opacity-50">© 2026 EventBook. All rights reserved.</div>
    </div>

    <div class="register-form-content">
        <div class="mb-5">
            <h2 class="form-title">Create Account</h2>
            <p class="text-muted">Fill in your details to get started</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?> custom-alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Your full name" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" placeholder="9876543210">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Create password" required>
            </div>

            <button type="submit" class="btn btn-register w-100">
                Create Account
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="small text-muted">
                Already have an account?
                <a href="login.php" class="text-primary text-decoration-none fw-bold">Login here</a>
            </p>
            <hr class="my-4" style="opacity: 0.1;">
            <a href="index.php" class="text-muted small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to website
            </a>
        </div>
    </div>
</div>

</body>
</html>