<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ═══════════════════════════════════════════════════════════
// SESSION & AUTH LOGIC
// ═══════════════════════════════════════════════════════════
$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$display_name = $_SESSION['user_name'] ?? 'User'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventBook | Premium Event Platform</title>
    <title>EventBook | Discover Amazing Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
        :root {
            --primary-accent: #ffc107;
            --dark-bg: #212529;
            --transition: 0.3s ease;
        }
    /* ═══════════════════════════════════════════════════════════
       MODERN DESIGN SYSTEM (GLOBAL & SHARED LAYOUT)
    ═══════════════════════════════════════════════════════════ */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f7f8fc;
        --bg-dark: #0a0a0f;
        --text-primary: #1a1a2e;
        --text-secondary: #64748b;
        --text-light: #94a3b8;
        --accent-primary: #7c3aed;
        --accent-secondary: #a855f7;
        --accent-gradient: linear-gradient(135deg, #7c3aed 0%, #a855f7 50%, #ec4899 100%);
        --accent-glow: rgba(124, 58, 237, 0.4);
        --card-bg: #ffffff;
        --card-border: #e2e8f0;
        --success: #10b981;
        --warning: #f59e0b;
        --radius-sm: 12px;
        --radius-md: 16px;
        --radius-lg: 24px;
        --radius-xl: 32px;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 8px 24px rgba(0,0,0,0.06);
        --shadow-lg: 0 16px 48px rgba(0,0,0,0.08);
        --shadow-xl: 0 24px 64px rgba(0,0,0,0.12);
        --transition-fast: 0.2s ease;
        --transition-normal: 0.3s ease;
        --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: var(--bg-primary); color: var(--text-primary); line-height: 1.6; overflow-x: hidden; -webkit-font-smoothing: antialiased; }
    h1, h2, h3, h4, h5, h6 { font-family: 'Sora', sans-serif; font-weight: 700; line-height: 1.2; }
    ::selection { background: var(--accent-primary); color: white; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--bg-secondary); }
    ::-webkit-scrollbar-thumb { background: var(--accent-primary); border-radius: 10px; }

        /* Navbar Design */
        .navbar-main {
            background: var(--dark-bg);
            padding: 0.85rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    /* NAVBAR STYLES */
    .navbar-main { position: fixed; top: 0; left: 0; right: 0; z-index: 9999; padding: 1rem 0; transition: var(--transition-normal); }
    .navbar-main.scrolled { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); box-shadow: 0 1px 0 rgba(0,0,0,0.05); padding: 0.75rem 0; }
    .navbar-main.scrolled .nav-brand, .navbar-main.scrolled .nav-link-main { color: var(--text-primary) !important; }
    .nav-brand { font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 800; color: white; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: var(--transition-fast); }
    .nav-brand:hover { color: white; }
    .nav-brand-icon { width: 36px; height: 36px; background: var(--accent-gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; }
    .nav-link-main { color: rgba(255,255,255,0.85) !important; font-weight: 500; font-size: 0.95rem; padding: 0.5rem 1rem !important; border-radius: var(--radius-sm); transition: var(--transition-fast); }
    .nav-link-main:hover { color: white !important; background: rgba(255,255,255,0.1); }
    .btn-nav { padding: 0.6rem 1.5rem; border-radius: 100px; font-weight: 600; font-size: 0.9rem; transition: var(--transition-normal); border: none; text-decoration: none; }
    .btn-nav-outline { background: transparent; border: 2px solid rgba(255,255,255,0.3); color: white; }
    .btn-nav-outline:hover { background: white; border-color: white; color: var(--text-primary); }
    .navbar-main.scrolled .btn-nav-outline { border-color: var(--text-primary); color: var(--text-primary); }
    .navbar-main.scrolled .btn-nav-outline:hover { background: var(--text-primary); color: white !important; }
    .btn-nav-primary { background: white; color: var(--accent-primary); }
    .btn-nav-primary:hover { background: var(--bg-secondary); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255,255,255,0.2); color: var(--accent-primary); }

        .navbar-brand { font-weight: 800; font-size: 1.5rem; }
        .nav-link { font-weight: 500; transition: var(--transition); color: rgba(255,255,255,0.75) !important; }
        .nav-link:hover { color: #fff !important; }
    /* Toggler adjustments */
    .navbar-toggler { border-color: rgba(255,255,255,0.5); }
    .navbar-toggler-icon { filter: invert(1); }
    .navbar-main.scrolled .navbar-toggler-icon { filter: invert(0); }
    .navbar-main.scrolled .navbar-toggler { border-color: rgba(0,0,0,0.1); }

        .user-welcome-tag {
            background: rgba(255,255,255,0.1);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.85rem;
            color: var(--primary-accent) !important;
            border: 1px solid rgba(255,193,7,0.2);
            display: inline-flex;
            align-items: center;
        }

        /* Modal styling */
        .modal-content { border-radius: 20px; border: none; overflow: hidden; }
        .modal-header { border-bottom: none; padding: 25px 25px 10px; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #e2e8f0; }
        .form-control:focus { border-color: #7c3aed; box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1); }
        .btn-auth { border-radius: 12px; padding: 12px; font-weight: 700; width: 100%; transition: var(--transition); }
    /* FOOTER STYLES */
    .footer { background: var(--bg-dark); color: rgba(255,255,255,0.7); padding: 80px 0 30px; }
    .footer-brand { display: flex; align-items: center; gap: 10px; font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 800; color: white; margin-bottom: 1rem; }
    .footer-text { font-size: 0.95rem; line-height: 1.8; margin-bottom: 1.5rem; }
    .footer-title { color: white; font-weight: 700; margin-bottom: 1.5rem; font-size: 1rem; }
    .footer-link { display: block; color: rgba(255,255,255,0.6); text-decoration: none; margin-bottom: 12px; font-size: 0.95rem; transition: var(--transition-fast); }
    .footer-link:hover { color: white; padding-left: 6px; }
    .social-links { display: flex; gap: 10px; }
    .social-link { width: 42px; height: 42px; background: rgba(255,255,255,0.08); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; text-decoration: none; transition: var(--transition-normal); }
    .social-link:hover { background: var(--accent-primary); transform: translateY(-3px); color: white; }
    .newsletter-form { display: flex; gap: 10px; }
    .newsletter-input { flex: 1; padding: 12px 18px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-sm); color: white; font-size: 0.95rem; transition: var(--transition-fast); }
    .newsletter-input::placeholder { color: rgba(255,255,255,0.4); }
    .newsletter-input:focus { outline: none; border-color: var(--accent-primary); background: rgba(255,255,255,0.12); }
    .newsletter-btn { padding: 12px 20px; background: var(--accent-gradient); border: none; border-radius: var(--radius-sm); color: white; font-weight: 600; cursor: pointer; transition: var(--transition-normal); }
    .newsletter-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px var(--accent-glow); }
    .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem; margin-top: 3rem; text-align: center; font-size: 0.9rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-main sticky-top">
    <div class="container">
        <a class="navbar-brand text-white" href="index.php">
            <i class="bi bi-calendar-check-fill me-2 text-warning"></i>EventBook
    <!-- ═══════════ SHARED NAVBAR ═══════════ -->
    <nav class="navbar navbar-expand-lg navbar-main" id="mainNavbar">
        <div class="container">
            <a class="nav-brand" href="index.php">
                <div class="nav-brand-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                EventBook
            </a>

            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link nav-link-main" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-main" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-main" href="events.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-main" href="contact.php">Contact</a></li>

                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="nav-link nav-link-main">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
                        </span>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="logout.php" class="btn btn-nav btn-nav-outline">Logout</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item ms-2">
                        <a href="login.php" class="nav-link nav-link-main">Login</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="register.php" class="btn btn-nav btn-nav-primary">Get Started</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script>
    // Handles Navbar Scrolled State behavior
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
    });
    </script>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                
                <?php if($is_logged_in): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    
                    <li class="nav-item ms-lg-3">
                        <span class="nav-link user-welcome-tag">
                            <i class="bi bi-person-circle me-2"></i>
                            Hi, <?php echo htmlspecialchars($display_name); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger btn-sm rounded-pill px-3 ms-lg-2" href="logout.php">
                            Logout
                        </a>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <button type="button" class="btn btn-link nav-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-warning btn-sm text-dark px-4 rounded-pill fw-bold ms-lg-2" data-bs-toggle="modal" data-bs-target="#registerModal">
                            Register
                        </button>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header d-flex justify-content-between">
                <h4 class="fw-bold mb-0">Sign In</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="loginForm">
                <div class="modal-body p-4">
                    <div id="loginError" class="alert alert-danger d-none small py-2"></div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" class="form-control" name="email" required placeholder="name@email.com">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-dark btn-auth">Login Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h4 class="fw-bold mb-0">Create Account</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="registerForm">
                <div class="modal-body p-4">
                    <div id="registerError" class="alert alert-danger d-none small py-2"></div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" class="form-control" name="name" required placeholder="Your Name">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="email@test.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Phone</label>
                            <input type="tel" class="form-control" name="phone" required placeholder="9876543210">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="Create password">
                    </div>
                    <button type="submit" class="btn btn-warning btn-auth text-dark">Join EventBook</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Determine the base path automatically
    const pathParts = window.location.pathname.split('/');
    const baseURL = window.location.origin + pathParts.slice(0, pathParts.length - 1).join('/');

    // Unified Auth Logic for Login/Register
    const processAuth = (formId, targetFile, errorDivId) => {
        const form = document.getElementById(formId);
        if(!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const errDiv = document.getElementById(errorDivId);
            errDiv.classList.add('d-none');

            fetch(`${baseURL}/${targetFile}`, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(res => res.text())
            .then(data => {
                if(data.includes('error')) {
                    errDiv.textContent = data.replace('error: ', '');
                    errDiv.classList.remove('d-none');
                } else {
                    if(targetFile === 'login.php') {
                        // Success Login: Check for admin or user redirect
                        window.location.href = data.includes('admin') ? 'admin/dashboard.php' : 'index.php';
                    } else {
                        // Success Registration
                        alert('Registration Successful! Please login.');
                        location.reload();
                    }
                }
            })
            .catch(err => {
                errDiv.textContent = 'Server connection failed.';
                errDiv.classList.remove('d-none');
            });
        });
    };

    processAuth('loginForm', 'login.php', 'loginError');
    processAuth('registerForm', 'register.php', 'registerError');
});
</script>