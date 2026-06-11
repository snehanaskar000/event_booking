<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "event_platform"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("<div style='color:red; padding:20px;'>Connection failed: " . mysqli_connect_error() . "</div>");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>EventBook | Discover Amazing Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

    <style>
    /* ═══════════════════════════════════════════════════════════
       MODERN DESIGN SYSTEM
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

    /* ═══════════════════════════════════════════════════════════
       BASE STYLES
    ═══════════════════════════════════════════════════════════ */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg-primary);
        color: var(--text-primary);
        line-height: 1.6;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        line-height: 1.2;
    }

    /* Selection */
    ::selection {
        background: var(--accent-primary);
        color: white;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--bg-secondary); }
    ::-webkit-scrollbar-thumb { 
        background: var(--accent-primary); 
        border-radius: 10px; 
    }

    /* ═══════════════════════════════════════════════════════════
       NAVBAR
    ═══════════════════════════════════════════════════════════ */
    .navbar-main {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        padding: 1rem 0;
        transition: var(--transition-normal);
    }

    .navbar-main.scrolled {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 1px 0 rgba(0,0,0,0.05);
        padding: 0.75rem 0;
    }

    .navbar-main.scrolled .nav-brand,
    .navbar-main.scrolled .nav-link-main {
        color: var(--text-primary) !important;
    }

    .nav-brand {
        font-family: 'Sora', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-fast);
    }

    .nav-brand:hover {
        color: white;
    }

    .nav-brand-icon {
        width: 36px;
        height: 36px;
        background: var(--accent-gradient);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .nav-link-main {
        color: rgba(255,255,255,0.85) !important;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem !important;
        border-radius: var(--radius-sm);
        transition: var(--transition-fast);
    }

    .nav-link-main:hover {
        color: white !important;
        background: rgba(255,255,255,0.1);
    }

    .btn-nav {
        padding: 0.6rem 1.5rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: var(--transition-normal);
        border: none;
        text-decoration: none;
    }

    .btn-nav-outline {
        background: transparent;
        border: 2px solid rgba(255,255,255,0.3);
        color: white;
    }

    .btn-nav-outline:hover {
        background: white;
        border-color: white;
        color: var(--text-primary);
    }

    .btn-nav-primary {
        background: white;
        color: var(--accent-primary);
    }

    .btn-nav-primary:hover {
        background: var(--bg-secondary);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255,255,255,0.2);
        color: var(--accent-primary);
    }

    /* ═══════════════════════════════════════════════════════════
       HERO SECTION
    ═══════════════════════════════════════════════════════════ */
    .hero {
        min-height: 100vh;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding: 120px 0 80px;
    }

    /* Animated Background Shapes */
    .hero-shapes {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }

    .hero-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.5;
        animation: float-shape 20s infinite ease-in-out;
    }

    .hero-shape-1 {
        width: 500px;
        height: 500px;
        background: var(--accent-primary);
        top: -20%;
        right: -10%;
        animation-delay: 0s;
    }

    .hero-shape-2 {
        width: 400px;
        height: 400px;
        background: #ec4899;
        bottom: -15%;
        left: -5%;
        animation-delay: -5s;
    }

    .hero-shape-3 {
        width: 300px;
        height: 300px;
        background: #06b6d4;
        top: 40%;
        left: 30%;
        animation-delay: -10s;
    }

    @keyframes float-shape {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(30px, -30px) scale(1.05); }
        50% { transform: translate(-20px, 20px) scale(0.95); }
        75% { transform: translate(20px, 10px) scale(1.02); }
    }

    .hero-content {
        position: relative;
        z-index: 10;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 100px;
        color: white;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .hero-tag-dot {
        width: 8px;
        height: 8px;
        background: var(--success);
        border-radius: 50%;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }

    .hero-title {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 800;
        color: white;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
    }

    .hero-title-gradient {
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.15rem;
        color: rgba(255,255,255,0.7);
        max-width: 500px;
        margin-bottom: 2.5rem;
        line-height: 1.8;
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-hero {
        padding: 1rem 2rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: var(--transition-normal);
        border: none;
        cursor: pointer;
    }

    .btn-hero-primary {
        background: var(--accent-gradient);
        color: white;
        box-shadow: 0 8px 30px var(--accent-glow);
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px var(--accent-glow);
        color: white;
    }

    .btn-hero-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }

    .btn-hero-secondary:hover {
        background: rgba(255,255,255,0.2);
        color: white;
        transform: translateY(-3px);
    }

    /* Hero Image Side */
    .hero-visual {
        position: relative;
        z-index: 10;
    }

    .hero-card-stack {
        position: relative;
        padding: 20px;
    }

    .hero-main-card {
        background: white;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        transform: rotate(3deg);
    }

    .hero-main-card img {
        width: 100%;
        height: 350px;
        object-fit: cover;
    }

    .hero-main-card-body {
        padding: 1.5rem;
    }

    .hero-main-card-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .hero-main-card-meta {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .hero-floating-card {
        position: absolute;
        background: white;
        padding: 1rem 1.25rem;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: float-card 4s infinite ease-in-out;
    }

    .hero-floating-card-1 {
        bottom: 10%;
        left: -10%;
        animation-delay: 0s;
    }

    .hero-floating-card-2 {
        top: 15%;
        right: -5%;
        animation-delay: -2s;
    }

    @keyframes float-card {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .floating-icon {
        width: 45px;
        height: 45px;
        background: var(--accent-gradient);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .floating-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    .floating-icon.orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

    .floating-text h6 {
        font-weight: 700;
        font-size: 0.95rem;
        margin: 0;
    }

    .floating-text p {
        color: var(--text-secondary);
        font-size: 0.8rem;
        margin: 0;
    }

    /* ═══════════════════════════════════════════════════════════
       STATS BAR
    ═══════════════════════════════════════════════════════════ */
    .stats-bar {
        background: var(--bg-secondary);
        padding: 4rem 0;
        border-bottom: 1px solid var(--card-border);
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-family: 'Sora', sans-serif;
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* ═══════════════════════════════════════════════════════════
       SECTION STYLES
    ═══════════════════════════════════════════════════════════ */
    .section {
        padding: 100px 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        background: rgba(124, 58, 237, 0.1);
        color: var(--accent-primary);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 100px;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.1rem;
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto;
    }

    /* ═══════════════════════════════════════════════════════════
       EVENT CARDS
    ═══════════════════════════════════════════════════════════ */
    .events-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .events-header-text h2 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .events-header-text p {
        color: var(--text-secondary);
        margin: 0;
    }

    .btn-view-all {
        padding: 0.75rem 1.5rem;
        background: var(--text-primary);
        color: white;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition-normal);
    }

    .btn-view-all:hover {
        background: var(--accent-primary);
        color: white;
        transform: translateY(-2px);
    }

    .event-card {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: 1px solid var(--card-border);
        transition: var(--transition-slow);
        height: 100%;
    }

    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }

    .event-card-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .event-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-slow);
    }

    .event-card:hover .event-card-image img {
        transform: scale(1.05);
    }

    .event-card-price {
        position: absolute;
        top: 16px;
        right: 16px;
        background: white;
        padding: 8px 16px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--accent-primary);
        box-shadow: var(--shadow-md);
    }

    .event-card-category {
        position: absolute;
        bottom: 16px;
        left: 16px;
        background: var(--text-primary);
        color: white;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-card-body {
        padding: 1.5rem;
    }

    .event-card-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .event-card-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
    }

    .event-card-meta i {
        color: var(--accent-primary);
    }

    .btn-book {
        width: 100%;
        padding: 0.875rem;
        background: var(--text-primary);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition-normal);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-book:hover {
        background: var(--accent-primary);
        transform: translateY(-2px);
    }

    /* ═══════════════════════════════════════════════════════════
       FEATURES SECTION
    ═══════════════════════════════════════════════════════════ */
    .features-section {
        background: var(--bg-secondary);
    }

    .feature-card {
        background: var(--card-bg);
        padding: 2.5rem 2rem;
        border-radius: var(--radius-xl);
        text-align: center;
        border: 1px solid var(--card-border);
        transition: var(--transition-slow);
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--accent-primary);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: var(--accent-gradient);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 1.75rem;
        transition: var(--transition-normal);
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .feature-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 0.75rem;
    }

    .feature-text {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.7;
    }

    /* ═══════════════════════════════════════════════════════════
       TESTIMONIALS
    ═══════════════════════════════════════════════════════════ */
    .testimonial-card {
        background: var(--card-bg);
        padding: 2rem;
        border-radius: var(--radius-xl);
        border: 1px solid var(--card-border);
        height: 100%;
        transition: var(--transition-slow);
        position: relative;
    }

    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: 1.5rem;
        right: 2rem;
        font-family: 'Playfair Display', serif;
        font-size: 5rem;
        color: rgba(124, 58, 237, 0.08);
        line-height: 1;
    }

    .testimonial-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--accent-primary);
    }

    .testimonial-stars {
        color: var(--warning);
        margin-bottom: 1rem;
        font-size: 1rem;
    }

    .testimonial-text {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .testimonial-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--bg-secondary);
        transition: var(--transition-fast);
    }

    .testimonial-card:hover .testimonial-avatar {
        border-color: var(--accent-primary);
        transform: scale(1.1);
    }

    .testimonial-name {
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 2px;
    }

    .testimonial-role {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    /* ═══════════════════════════════════════════════════════════
       CTA SECTION
    ═══════════════════════════════════════════════════════════ */
    .cta-section {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: var(--accent-primary);
        filter: blur(150px);
        opacity: 0.3;
        top: -200px;
        right: -100px;
    }

    .cta-content {
        text-align: center;
        position: relative;
        z-index: 10;
    }

    .cta-title {
        font-size: 2.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .cta-text {
        color: rgba(255,255,255,0.7);
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    /* ═══════════════════════════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════════════════════════ */
    .footer {
        background: var(--bg-dark);
        color: rgba(255,255,255,0.7);
        padding: 80px 0 30px;
    }

    .footer-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Sora', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        margin-bottom: 1rem;
    }

    .footer-text {
        font-size: 0.95rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .footer-title {
        color: white;
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }

    .footer-link {
        display: block;
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        margin-bottom: 12px;
        font-size: 0.95rem;
        transition: var(--transition-fast);
    }

    .footer-link:hover {
        color: white;
        padding-left: 6px;
    }

    .social-links {
        display: flex;
        gap: 10px;
    }

    .social-link {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.08);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        text-decoration: none;
        transition: var(--transition-normal);
    }

    .social-link:hover {
        background: var(--accent-primary);
        transform: translateY(-3px);
        color: white;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
    }

    .newsletter-input {
        flex: 1;
        padding: 12px 18px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: var(--radius-sm);
        color: white;
        font-size: 0.95rem;
        transition: var(--transition-fast);
    }

    .newsletter-input::placeholder {
        color: rgba(255,255,255,0.4);
    }

    .newsletter-input:focus {
        outline: none;
        border-color: var(--accent-primary);
        background: rgba(255,255,255,0.12);
    }

    .newsletter-btn {
        padding: 12px 20px;
        background: var(--accent-gradient);
        border: none;
        border-radius: var(--radius-sm);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-normal);
    }

    .newsletter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px var(--accent-glow);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 2rem;
        margin-top: 3rem;
        text-align: center;
        font-size: 0.9rem;
    }

    /* ═══════════════════════════════════════════════════════════
       MODAL
    ═══════════════════════════════════════════════════════════ */
    .modal-content {
        border-radius: var(--radius-xl);
        border: none;
        overflow: hidden;
    }

    .modal-header-custom {
        background: var(--accent-gradient);
        color: white;
        padding: 1.5rem;
        border: none;
    }

    .modal-title-custom {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .form-control-custom {
        padding: 0.875rem 1rem;
        border: 2px solid var(--card-border);
        border-radius: var(--radius-md);
        font-size: 1rem;
        transition: var(--transition-fast);
    }

    .form-control-custom:focus {
        border-color: var(--accent-primary);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
    }

    .total-box {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: var(--radius-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .total-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .total-amount {
        font-family: 'Sora', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .btn-checkout {
        width: 100%;
        padding: 1rem;
        background: var(--accent-gradient);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition-normal);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px var(--accent-glow);
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════════════════ */
    @media (max-width: 991px) {
        .hero-visual {
            margin-top: 3rem;
        }
        
        .hero-floating-card {
            display: none;
        }

        .hero-main-card {
            transform: rotate(0);
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .events-header {
            text-align: center;
            justify-content: center;
        }

        .newsletter-form {
            flex-direction: column;
        }
    }
    </style>
</head>

<body>

    <!-- ═══════════ NAVBAR ═══════════ -->
    <nav class="navbar navbar-expand-lg navbar-main" id="mainNavbar">
        <div class="container">
            <a class="nav-brand" href="index.php">
                <div class="nav-brand-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                EventBook
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link nav-link-main" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-main" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-main" href="events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-main" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link nav-link-main">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </span>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="logout.php" class="btn btn-nav btn-nav-outline">Logout</a>
                    </li>

                    <?php else: ?>
                    <li class="nav-item">
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

    <!-- ═══════════ HERO ═══════════ -->
    <section class="hero">
        <div class="hero-shapes">
            <div class="hero-shape hero-shape-1"></div>
            <div class="hero-shape hero-shape-2"></div>
            <div class="hero-shape hero-shape-3"></div>
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content" data-aos="fade-right" data-aos-duration="1000">
                        <div class="hero-tag">
                            <span class="hero-tag-dot"></span>
                            Discover events near you
                        </div>
                        <h1 class="hero-title">
                            Find Your Next <br>
                            <span class="hero-title-gradient">Amazing Experience</span>
                        </h1>
                        <p class="hero-subtitle">
                            Explore thousands of events, from concerts and conferences to workshops and meetups. 
                            Book your tickets in seconds.
                        </p>
                        <div class="hero-buttons">
                            <a href="#events" class="btn-hero btn-hero-primary">
                                <i class="bi bi-search"></i> Explore Events
                            </a>
                            <a href="#features" class="btn-hero btn-hero-secondary">
                                <i class="bi bi-play-circle"></i> How It Works
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-visual" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <div class="hero-card-stack">
                            <div class="hero-main-card">
                                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80" alt="Event">
                                <div class="hero-main-card-body">
                                    <div class="hero-main-card-title">Tech Conference 2025</div>
                                    <div class="hero-main-card-meta">
                                        <i class="bi bi-calendar3 me-2"></i> March 15, 2025
                                    </div>
                                </div>
                            </div>

                            <div class="hero-floating-card hero-floating-card-1">
                                <div class="floating-icon green">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <div class="floating-text">
                                    <h6>Booking Confirmed</h6>
                                    <p>Your tickets are ready</p>
                                </div>
                            </div>

                            <div class="hero-floating-card hero-floating-card-2">
                                <div class="floating-icon orange">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="floating-text">
                                    <h6>50K+ Users</h6>
                                    <p>Trust our platform</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ STATS ═══════════ -->
    <section class="stats-bar">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Events Listed</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Happy Users</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Cities</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <div class="stat-number">4.9★</div>
                        <div class="stat-label">User Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ EVENTS ═══════════ -->
    <section class="section" id="events">
        <div class="container">
            <div class="events-header" data-aos="fade-up">
                <div class="events-header-text">
                    <h2>Trending Events</h2>
                    <p>Discover what's happening this week</p>
                </div>
                <a href="events.php" class="btn-view-all">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4">
                <?php
                $sql = "SELECT * FROM events ORDER BY created_at DESC LIMIT 8";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0):
                    $delay = 0;
                    while($event = mysqli_fetch_assoc($result)):
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="event-card">
                        <div class="event-card-image">
                            <?php 
                                $img = "uploads/" . $event['event_image'];
                                if(!file_exists($img) || empty($event['event_image'])) {
                                    $img = "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=800&q=80";
                                }
                            ?>
                            <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            <div class="event-card-price">₹<?php echo number_format($event['price'], 0); ?></div>
                            <div class="event-card-category"><?php echo htmlspecialchars($event['category']); ?></div>
                        </div>
                        <div class="event-card-body">
                            <h5 class="event-card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                            <div class="event-card-meta">
                                <i class="bi bi-calendar3"></i>
                                <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                            </div>
                            <button class="btn-book"
                                data-bs-toggle="modal" data-bs-target="#bookingModal"
                                data-event-id="<?php echo $event['id']; ?>"
                                data-event-title="<?php echo htmlspecialchars($event['title']); ?>"
                                data-event-price="<?php echo $event['price']; ?>">
                                <i class="bi bi-ticket-perforated"></i> Book Now
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    $delay += 100;
                    endwhile; 
                endif; 
                ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ FEATURES ═══════════ -->
    <section class="section features-section" id="features">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-tag"><i class="bi bi-stars"></i> Features</div>
                <h2 class="section-title">Why Choose EventBook</h2>
                <p class="section-subtitle">We make event booking simple, secure, and enjoyable for everyone.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="feature-title">Secure Payments</h4>
                        <p class="feature-text">
                            Your transactions are protected with bank-level encryption and security protocols.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4 class="feature-title">Instant Tickets</h4>
                        <p class="feature-text">
                            Get your e-tickets instantly delivered to your email. No waiting, no hassle.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h4 class="feature-title">24/7 Support</h4>
                        <p class="feature-text">
                            Our dedicated team is here to help you with any questions, anytime, anywhere.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ TESTIMONIALS ═══════════ -->
    <section class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-tag"><i class="bi bi-chat-quote"></i> Testimonials</div>
                <h2 class="section-title">What People Say</h2>
                <p class="section-subtitle">Trusted by thousands of happy customers worldwide.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">
                            "Amazing platform! Booking events has never been this easy. The interface is beautiful and intuitive."
                        </p>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-avatar" alt="">
                            <div>
                                <div class="testimonial-name">Rahul Sharma</div>
                                <div class="testimonial-role">Tech Enthusiast</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">
                            "I love how smooth the booking experience is. Found great events and got tickets in seconds!"
                        </p>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="testimonial-avatar" alt="">
                            <div>
                                <div class="testimonial-name">Priya Patel</div>
                                <div class="testimonial-role">Designer</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">
                            "Best event booking website I've used. Clean design, fast performance, and great support."
                        </p>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/65.jpg" class="testimonial-avatar" alt="">
                            <div>
                                <div class="testimonial-name">Arjun Mehta</div>
                                <div class="testimonial-role">Event Organizer</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ CTA ═══════════ -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <h2 class="cta-title">Ready to Discover Events?</h2>
                <p class="cta-text">Join thousands of people finding amazing experiences every day.</p>
                <a href="events.php" class="btn-hero btn-hero-primary">
                    <i class="bi bi-rocket-takeoff"></i> Get Started Free
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════ FOOTER ═══════════ -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <div class="nav-brand-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        EventBook
                    </div>
                    <p class="footer-text">
                        Your trusted platform for discovering and booking amazing events worldwide.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6">
                    <h5 class="footer-title">Quick Links</h5>
                    <a href="index.php" class="footer-link">Home</a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="events.php" class="footer-link">Events</a>
                    <a href="about.php" class="footer-link">About</a>
                    <a href="contact.php" class="footer-link">Contact</a>
                    <?php else: ?>
                    <a href="login.php" class="footer-link">Login</a>
                    <a href="register.php" class="footer-link">Get Started</a>
                    <?php endif; ?>
                </div>

                <div class="col-lg-2 col-6">
                    <h5 class="footer-title">Support</h5>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Terms</a>
                    <a href="#" class="footer-link">Privacy</a>
                    <a href="#" class="footer-link">Refunds</a>
                </div>

                <div class="col-lg-4">
                    <h5 class="footer-title">Newsletter</h5>
                    <p class="footer-text">Subscribe to get updates on the latest events.</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Enter your email">
                        <button type="submit" class="newsletter-btn">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                © 2025 EventBook. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- ═══════════ MODAL ═══════════ -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title modal-title-custom" id="modalEventTitle">
                        <i class="bi bi-ticket-perforated me-2"></i> Book Event
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="process_booking.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="event_id" id="modalEventId">
                        <input type="hidden" name="unit_price" id="modalUnitPrice">
                        
                        <div class="mb-4">
                            <label class="form-label fw-600">Number of Tickets</label>
                            <input type="number" name="quantity" id="ticketQuantity" 
                                   class="form-control form-control-custom" value="1" min="1" max="10" required>
                        </div>

                        <div class="total-box mb-4">
                            <div class="total-label">Total Amount</div>
                            <div class="total-amount">₹<span id="totalPriceDisplay">0</span></div>
                        </div>

                        <button type="submit" name="confirm_booking" class="btn-checkout">
                            <i class="bi bi-lock-fill"></i> Secure Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ═══════════ SCRIPTS ═══════════ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
    // Init AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });

    // Navbar scroll
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Modal
    const bookingModal = document.getElementById('bookingModal');
    if (bookingModal) {
        bookingModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-event-id');
            const title = button.getAttribute('data-event-title');
            const price = button.getAttribute('data-event-price');
            
            document.getElementById('modalEventId').value = id;
            document.getElementById('modalEventTitle').innerHTML = 
                '<i class="bi bi-ticket-perforated me-2"></i> ' + title;
            document.getElementById('modalUnitPrice').value = price;
            updateTotal();
        });

        document.getElementById('ticketQuantity').addEventListener('input', updateTotal);
    }

    function updateTotal() {
        const qty = document.getElementById('ticketQuantity').value || 1;
        const price = document.getElementById('modalUnitPrice').value;
        const total = qty * price;
        document.getElementById('totalPriceDisplay').textContent = total.toLocaleString('en-IN');
    }

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    </script>
</body>

</html>