<?php
include('includes/header.php');
include('includes/db.php');

$success = "";
$error = "";

if(isset($_POST['send'])){

    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $subject = trim(mysqli_real_escape_string($conn, $_POST['subject']));
    $message = trim(mysqli_real_escape_string($conn, $_POST['message']));

    if(!empty($name) && !empty($email) && !empty($message)){

        $insert = mysqli_query($conn, "INSERT INTO contact_messages (name,email,subject,message) 
                                       VALUES ('$name','$email','$subject','$message')");

        if($insert){
            $success = "Thank you! Your message has been sent successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }

    } else {
        $error = "Please fill all required fields.";
    }
}
?>

<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════════════════════
   CONTACT PAGE STYLES
═══════════════════════════════════════════════════════════ */

:root {
    --primary: #7c3aed;
    --secondary: #ec4899;
    --accent: #f59e0b;
    --dark: #1e1b4b;
    --text: #334155;
    --text-light: #64748b;
    --bg-light: #f8fafc;
    --white: #ffffff;
    --gradient: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    color: var(--text);
    background: var(--white);
}

/* ═══════════════════════════════════════════════════════════
   HERO SECTION
═══════════════════════════════════════════════════════════ */
.contact-hero {
    min-height: 50vh;
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    padding: 120px 20px 80px;
}

.hero-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.4;
    animation: float-shape 15s infinite ease-in-out;
}

.hero-shape-1 {
    width: 400px;
    height: 400px;
    background: var(--primary);
    top: -150px;
    right: -100px;
}

.hero-shape-2 {
    width: 300px;
    height: 300px;
    background: var(--secondary);
    bottom: -100px;
    left: -50px;
    animation-delay: -5s;
}

@keyframes float-shape {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.hero-content {
    position: relative;
    z-index: 10;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 100px;
    color: white;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
}

.hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 2rem;
}

/* ═══════════════════════════════════════════════════════════
   INFO CARDS
═══════════════════════════════════════════════════════════ */
.info-section {
    padding: 80px 0;
    background: var(--bg-light);
}

.info-card {
    background: var(--white);
    padding: 40px 30px;
    border-radius: 24px;
    border: 1px solid #e2e8f0;
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--gradient);
    transform: scaleX(0);
    transition: 0.4s ease;
}

.info-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(124, 58, 237, 0.15);
    border-color: transparent;
}

.info-card:hover::before {
    transform: scaleX(1);
}

.info-icon-wrapper {
    width: 70px;
    height: 70px;
    background: var(--gradient);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    color: white;
    font-size: 2rem;
    transition: 0.4s ease;
}

.info-card:hover .info-icon-wrapper {
    transform: scale(1.1) rotate(5deg);
}

.info-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 15px;
    text-align: center;
}

.info-text {
    color: var(--text-light);
    font-size: 1rem;
    line-height: 1.7;
    text-align: center;
}

/* ═══════════════════════════════════════════════════════════
   CONTACT FORM & MAP
═══════════════════════════════════════════════════════════ */
.contact-section {
    padding: 80px 0;
    background: var(--white);
}

.contact-container {
    background: var(--white);
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,0.1);
    border: 1px solid #e2e8f0;
}

.form-column {
    padding: 50px;
    background: var(--white);
}

.map-column {
    position: relative;
    min-height: 500px;
}

.map-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(30, 27, 75, 0.9), rgba(76, 29, 149, 0.8));
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px;
    text-align: center;
    color: white;
}

.map-overlay h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.map-overlay p {
    font-size: 1rem;
    max-width: 400px;
    margin: 0 auto 2rem;
    opacity: 0.9;
}

.map-button {
    padding: 14px 30px;
    background: var(--gradient);
    color: white;
    border: none;
    border-radius: 100px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.map-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(124, 58, 237, 0.4);
}

.map-iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Form Styles */
.form-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 15px;
}

.form-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 4px;
    background: var(--gradient);
    border-radius: 2px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 10px;
    display: block;
}

.form-control-custom {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-size: 1rem;
    transition: 0.3s ease;
    background: var(--white);
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
}

textarea.form-control-custom {
    min-height: 150px;
    resize: vertical;
}

.btn-submit {
    width: 100%;
    padding: 16px;
    background: var(--gradient);
    color: white;
    border: none;
    border-radius: 16px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: 0.3s ease;
    margin-top: 10px;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(124, 58, 237, 0.4);
}

/* Alert Messages */
.alert-success {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.3);
    color: #10b981;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #ef4444;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Required Star */
.form-label.required::after {
    content: ' *';
    color: var(--primary);
}

/* ═══════════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════════ */
@media (max-width: 991px) {
    .contact-container {
        border-radius: 24px;
    }
    
    .form-column,
    .map-column {
        padding: 30px;
    }
    
    .map-overlay {
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .contact-hero {
        padding: 100px 20px 60px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .info-section,
    .contact-section {
        padding: 60px 0;
    }
    
    .form-column,
    .map-column {
        padding: 25px;
    }
    
    .form-title {
        font-size: 1.5rem;
    }
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════ -->
<section class="contact-hero">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <div class="hero-badge">
            <i class="bi bi-envelope-fill"></i>
            Get In Touch
        </div>
        <h1 class="hero-title">Contact Us</h1>
        <p class="hero-subtitle">
            We'd love to hear from you. Let's connect and create amazing experiences together.
        </p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     INFO CARDS
═══════════════════════════════════════════════════════════ -->
<section class="info-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card">
                    <div class="info-icon-wrapper">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3 class="info-title">Our Location</h3>
                    <p class="info-text">
                        123 Event Street,<br>Newtown, Kolkata<br>West Bengal, India
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card">
                    <div class="info-icon-wrapper">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h3 class="info-title">Call Us</h3>
                    <p class="info-text">
                        +91 98765 43210<br>
                        Mon-Fri: 9AM-6PM<br>
                        Sat: 10AM-4PM
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card">
                    <div class="info-icon-wrapper">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h3 class="info-title">Email Us</h3>
                    <p class="info-text">
                        support@eventbook.com<br>
                        info@eventbook.com<br>
                        We reply within 24 hours
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CONTACT FORM & MAP
═══════════════════════════════════════════════════════════ -->
<section class="contact-section">
    <div class="container">
        <div class="contact-container">
            <div class="row g-0">
                
                <!-- Map Column -->
                <div class="col-lg-6 map-column">
                    <div class="map-overlay">
                        <h3>Visit Our Office</h3>
                        <p>
                            Come see us at our beautiful office in the heart of Kolkata. 
                            We'd love to meet you in person!
                        </p>
                        <a href="https://maps.google.com" target="_blank" class="map-button">
                            <i class="bi bi-geo-alt me-2"></i> Get Directions
                        </a>
                    </div>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3683.602520933058!2d88.4082!3d22.5865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0275350398a5b9%3A0x75e165b244323425!2sNewtown%2C%20Kolkata%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1710000000000"
                        class="map-iframe"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
                
                <!-- Form Column -->
                <div class="col-lg-6 form-column">
                    <h2 class="form-title">Send Us a Message</h2>
                    
                    <?php if($success != "") { ?>
                        <div class="alert-success">
                            <i class="bi bi-check-circle-fill"></i>
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>

                    <?php if($error != "") { ?>
                        <div class="alert-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <form method="POST">
                        <div class="form-group">
                            <label class="form-label required">Full Name</label>
                            <input type="text" name="name" class="form-control-custom" placeholder="Enter your full name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Email Address</label>
                            <input type="email" name="email" class="form-control-custom" placeholder="Enter your email address" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control-custom" placeholder="What is this regarding?">
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Message</label>
                            <textarea name="message" class="form-control-custom" placeholder="Tell us how we can help you..." required></textarea>
                        </div>

                        <button type="submit" name="send" class="btn-submit">
                            <i class="bi bi-send me-2"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AOS Animation JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true,
    offset: 50
});
</script>

<?php include('includes/footer.php'); ?>