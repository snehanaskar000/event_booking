<?php
session_start();
include('includes/db.php');

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "<div class='alert alert-danger custom-alert'>All fields are required!</div>";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($user['status'] !== 'active') {
                $message = "<div class='alert alert-warning custom-alert'>Account is inactive. Contact admin.</div>";
            }
            elseif (password_verify($password, $user['password'])) {
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                header("Location: " . ($user['role'] === 'admin' ? "admin/dashboard.php" : "index.php"));
                exit();
            } else {
                $message = "<div class='alert alert-danger custom-alert'>Invalid Password!</div>";
            }
        } else {
            $message = "<div class='alert alert-danger custom-alert'>Invalid Email!</div>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | EventBook</title>
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

        .login-container {
            max-width: 1000px;
            width: 95%;
            margin: auto;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        /* Branding Side */
        .login-side-info {
            background: linear-gradient(135deg, var(--dark-deep) 0%, #1e1b4b 100%);
            width: 45%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
        }

        .login-side-info::after {
            content: '';
            position: absolute;
            width: 150px; height: 150px;
            background: var(--primary-accent);
            filter: blur(80px);
            top: 10%; right: 10%;
            opacity: 0.4;
        }

        /* Form Side */
        .login-form-content {
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

        .input-group-text {
            background: transparent;
            border-right: none;
            color: #94a3b8;
            padding-left: 15px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border-left: none;
            font-size: 0.95rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #e2e8f0;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--primary-accent);
            color: var(--dark-deep);
        }

        .btn-login {
            background: var(--dark-deep);
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
        }

        .custom-alert {
            border-radius: 12px;
            border: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        @media (max-width: 991px) {
            .login-side-info { display: none; }
            .login-form-content { width: 100%; padding: 40px; }
            .login-container { max-width: 500px; }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-side-info">
        <a href="index.php" class="brand-logo">
            <i class="bi bi-calendar-event-fill text-warning"></i>
            EventBook
        </a>
        <div>
            <h1 class="fw-800 display-5">Book the <span class="text-warning">Moment.</span></h1>
            <p class="opacity-75">Join our community to discover premium events, workshops, and concerts happening around you.</p>
        </div>
        <div class="small opacity-50">© 2026 EventBook. All rights reserved.</div>
    </div>

    <div class="login-form-content">
        <div class="mb-5">
            <h2 class="form-title">Sign In</h2>
            <p class="text-muted">Enter your credentials to access your account</p>
        </div>

        <?php echo $message; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label class="form-label">Password</label>
                    <a href="#" class="small text-decoration-none text-primary fw-600">Forgot?</a>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login_btn" class="btn btn-login w-100 mb-4">
                Login to Dashboard
            </button>
        </form>

        <div class="text-center">
            <p class="small text-muted">New to our platform? 
                <a href="register.php" class="text-primary text-decoration-none fw-bold">Create an account</a>
            </p>
            <hr class="my-4" style="opacity: 0.1;">
            <a href="index.php" class="text-muted small text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to website</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>