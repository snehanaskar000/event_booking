<?php include('includes/header.php'); ?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
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
    --gradient-dark: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
}

body {
    font-family: 'Poppins', sans-serif;
    color: var(--text);
    overflow-x: hidden;
}

.about-hero {
    min-height: 70vh;
    background: var(--gradient-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    padding: 140px 20px 100px;
}

.hero-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.5;
    animation: float-orb 15s infinite ease-in-out;
}

.hero-orb-1 {
    width: 500px;
    height: 500px;
    background: var(--primary);
    top: -200px;
    right: -150px;
    animation-delay: 0s;
}

.hero-orb-2 {
    width: 400px;
    height: 400px;
    background: var(--secondary);
    bottom: -150px;
    left: -100px;
    animation-delay: -5s;
}

.hero-orb-3 {
    width: 300px;
    height: 300px;
    background: #06b6d4;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: -10s;
}

@keyframes float-orb {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.hero-content {
    position: relative;
    z-index: 10;
    max-width: 800px;
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

.hero-badge i {
    color: var(--accent);
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 800;
    color: white;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    letter-spacing: -1px;
}

.hero-title span {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255,255,255,0.8);
    line-height: 1.8;
    max-width: 600px;
    margin: 0 auto;
}

.stats-section {
    background: var(--white);
    padding: 60px 0;
    border-bottom: 1px solid #e2e8f0;
    margin-top: -50px;
    position: relative;
    z-index: 20;
    border-radius: 30px 30px 0 0;
}

.stat-card {
    text-align: center;
    padding: 30px 20px;
}

.stat-number {
    font-size: 3rem;
    font-weight: 800;
    background: var(--gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    color: var(--text-light);
    font-weight: 500;
    font-size: 1rem;
}

.story-section {
    padding: 120px 0;
    background: var(--white);
}

.story-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(124, 58, 237, 0.1);
    color: var(--primary);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 100px;
    margin-bottom: 1.5rem;
}

.story-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.story-text {
    font-size: 1.1rem;
    color: var(--text-light);
    line-height: 1.9;
    margin-bottom: 1.5rem;
}

.story-features {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-top: 2rem;
}

.story-feature {
    display: flex;
    align-items: center;
    gap: 12px;
}

.story-feature-icon {
    width: 45px;
    height: 45px;
    background: var(--gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.story-feature-text {
    font-weight: 600;
    color: var(--dark);
}

.story-image-wrapper {
    position: relative;
}

.story-image {
    width: 100%;
    border-radius: 30px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    transition: 0.5s ease;
}

.story-image:hover {
    transform: scale(1.03) rotate(1deg);
}

.story-floating-card {
    position: absolute;
    background: white;
    padding: 20px 25px;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 15px;
    animation: float 4s ease-in-out infinite;
}

.story-floating-card-1 {
    bottom: -20px;
    left: -20px;
}

.story-floating-card-2 {
    top: 20px;
    right: -20px;
    animation-delay: -2s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

.floating-card-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #10b981, #34d399);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
}

.floating-card-icon.purple {
    background: var(--gradient);
}

.floating-card-text h6 {
    font-weight: 700;
    font-size: 1rem;
    margin: 0 0 2px 0;
    color: var(--dark);
}

.floating-card-text p {
    margin: 0;
    color: var(--text-light);
    font-size: 0.85rem;
}

.mission-section {
    padding: 120px 0;
    background: var(--bg-light);
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(124, 58, 237, 0.1);
    color: var(--primary);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 100px;
    margin-bottom: 1rem;
}

.section-title {
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.15rem;
    color: var(--text-light);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.8;
}

.mission-card {
    background: var(--white);
    border-radius: 24px;
    padding: 40px 30px;
    text-align: center;
    border: 1px solid #e2e8f0;
    height: 100%;
    transition: 0.4s ease;
    position: relative;
    overflow: hidden;
}

.mission-card::before {
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

.mission-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(124, 58, 237, 0.15);
    border-color: transparent;
}

.mission-card:hover::before {
    transform: scaleX(1);
}

.mission-icon {
    width: 80px;
    height: 80px;
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

.mission-card:hover .mission-icon {
    transform: scale(1.1) rotate(5deg);
}

.mission-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 15px;
}

.mission-text {
    color: var(--text-light);
    font-size: 1rem;
    line-height: 1.7;
}

.values-section {
    padding: 120px 0;
    background: var(--gradient-dark);
    position: relative;
    overflow: hidden;
}

.values-section::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    background: rgba(124, 58, 237, 0.3);
    border-radius: 50%;
    filter: blur(100px);
    top: -200px;
    right: -100px;
}

.values-section .section-tag {
    background: rgba(255,255,255,0.15);
    color: white;
}

.values-section .section-title {
    color: white;
}

.values-section .section-subtitle {
    color: rgba(255,255,255,0.8);
}

.value-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 24px;
    padding: 40px 30px;
    text-align: center;
    height: 100%;
    transition: 0.4s ease;
}

.value-card:hover {
    transform: translateY(-10px);
    background: rgba(255,255,255,0.15);
    border-color: rgba(255,255,255,0.3);
}

.value-icon {
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    color: white;
    font-size: 1.8rem;
    transition: 0.4s ease;
}

.value-card:hover .value-icon {
    background: white;
    color: var(--primary);
    transform: scale(1.1);
}

.value-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin-bottom: 12px;
}

.value-text {
    color: rgba(255,255,255,0.75);
    font-size: 0.95rem;
    line-height: 1.7;
}

.team-section {
    padding: 120px 0;
    background: var(--white);
}

.team-card {
    background: var(--white);
    border-radius: 24px;
    padding: 40px 30px;
    text-align: center;
    border: 1px solid #e2e8f0;
    height: 100%;
    transition: 0.4s ease;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.1);
    border-color: transparent;
}

.team-avatar-wrapper {
    position: relative;
    width: 130px;
    height: 130px;
    margin: 0 auto 25px;
}

.team-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid var(--bg-light);
    transition: 0.4s ease;
}

.team-card:hover .team-avatar {
    border-color: var(--primary);
    transform: scale(1.08);
}

.team-avatar-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 35px;
    height: 35px;
    background: var(--gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    border: 3px solid white;
}

.team-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 5px;
}

.team-role {
    color: var(--primary);
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.team-bio {
    color: var(--text-light);
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
}

.team-socials {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.team-social-link {
    width: 40px;
    height: 40px;
    background: var(--bg-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
    font-size: 1rem;
    text-decoration: none;
    transition: 0.3s ease;
}

.team-social-link:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-3px);
}

.cta-section {
    padding: 100px 0;
    background: var(--bg-light);
    text-align: center;
}

.cta-card {
    background: var(--gradient);
    border-radius: 30px;
    padding: 80px 40px;
    position: relative;
    overflow: hidden;
}

.cta-card::before {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    top: -100px;
    right: -100px;
}

.cta-card::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
    bottom: -80px;
    left: -80px;
}

.cta-content {
    position: relative;
    z-index: 10;
}

.cta-title {
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
}

.cta-text {
    font-size: 1.15rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 40px;
    background: white;
    color: var(--primary);
    font-weight: 700;
    font-size: 1rem;
    border-radius: 100px;
    text-decoration: none;
    transition: 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.btn-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    color: var(--primary-dark);
}

@media (max-width: 991px) {
    .story-floating-card {
        display: none;
    }

    .story-image-wrapper {
        margin-top: 40px;
    }
}

@media (max-width: 768px) {
    .about-hero {
        padding: 120px 20px 80px;
    }

    .story-section,
    .mission-section,
    .values-section,
    .team-section {
        padding: 80px 0;
    }

    .stats-section {
        margin-top: -30px;
    }

    .stat-number {
        font-size: 2.5rem;
    }
}
</style>

<section class="about-hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    <div class="hero-orb hero-orb-3"></div>

    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <div class="hero-badge">
            <i class="bi bi-stars"></i>
            About EventBook
        </div>
        <h1 class="hero-title">
            We Create <span>Unforgettable</span><br>
            Event Experiences
        </h1>
        <p class="hero-subtitle">
            Your trusted platform for discovering, booking, and experiencing amazing events
            from conferences to concerts, workshops to meetups.
        </p>
    </div>
</section>

<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Events Hosted</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Happy Users</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Cities</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card">
                    <div class="stat-number">4.9★</div>
                    <div class="stat-label">User Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="story-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <div class="story-tag">
                    <i class="bi bi-book"></i> Our Story
                </div>
                <h2 class="story-title">
                    Building the Future of Event Discovery
                </h2>
                <p class="story-text">
                    EventBook was born from a simple idea: make discovering and booking events
                    as easy as possible. We saw how fragmented the event industry was and
                    decided to create a unified platform where anyone can find amazing experiences.
                </p>
                <p class="story-text">
                    Today, we connect thousands of event organizers with millions of attendees,
                    creating memorable moments that bring people together.
                </p>

                <div class="story-features">
                    <div class="story-feature">
                        <div class="story-feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="story-feature-text">Trusted Platform</span>
                    </div>
                    <div class="story-feature">
                        <div class="story-feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="story-feature-text">Secure Payments</span>
                    </div>
                    <div class="story-feature">
                        <div class="story-feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <span class="story-feature-text">24/7 Support</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                <div class="story-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=800&q=80"
                         class="story-image" alt="Event">

                    <div class="story-floating-card story-floating-card-1">
                        <div class="floating-card-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="floating-card-text">
                            <h6>10K+ Events</h6>
                            <p>Successfully hosted</p>
                        </div>
                    </div>

                    <div class="story-floating-card story-floating-card-2">
                        <div class="floating-card-icon purple">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div class="floating-card-text">
                            <h6>50K+ Users</h6>
                            <p>Trust our platform</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mission-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag">
                <i class="bi bi-bullseye"></i> Our Mission
            </div>
            <h2 class="section-title">What Drives Us Forward</h2>
            <p class="section-subtitle">
                We're on a mission to transform how people discover and experience events,
                making every moment count.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="bi bi-hand-index-thumb"></i>
                    </div>
                    <h4 class="mission-title">Easy Discovery</h4>
                    <p class="mission-text">
                        Find events that match your interests with our smart search and
                        personalized recommendations.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="mission-title">Secure Booking</h4>
                    <p class="mission-text">
                        Book with confidence knowing your payments and data are protected
                        by industry-leading security.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h4 class="mission-title">Community Building</h4>
                    <p class="mission-text">
                        Connect with like-minded people and build lasting relationships
                        through shared experiences.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="values-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag">
                <i class="bi bi-heart"></i> Our Values
            </div>
            <h2 class="section-title">What We Stand For</h2>
            <p class="section-subtitle">
                These core values guide everything we do at EventBook.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h4 class="value-title">Innovation</h4>
                    <p class="value-text">
                        Constantly improving our platform with new features and technologies.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h4 class="value-title">Excellence</h4>
                    <p class="value-text">
                        Delivering the highest quality experience in everything we do.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </div>
                    <h4 class="value-title">Trust</h4>
                    <p class="value-text">
                        Building lasting relationships through transparency and reliability.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-globe"></i>
                    </div>
                    <h4 class="value-title">Inclusion</h4>
                    <p class="value-text">
                        Creating a platform where everyone feels welcome and valued.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="team-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <div class="section-tag">
                <i class="bi bi-people"></i> Our Team
            </div>
            <h2 class="section-title">Meet the People Behind EventBook</h2>
            <p class="section-subtitle">
                Our passionate team is dedicated to creating the best event platform for you.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card">
                    <div class="team-avatar-wrapper">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg"
                             class="team-avatar" alt="John Doe">
                        <div class="team-avatar-badge">
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <h4 class="team-name">John Doe</h4>
                    <p class="team-role">Founder & CEO</p>
                    <p class="team-bio">
                        Visionary leader with 10+ years of experience in tech and events industry.
                    </p>
                    <div class="team-socials">
                        <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="team-social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="team-social-link"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card">
                    <div class="team-avatar-wrapper">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                             class="team-avatar" alt="Jane Smith">
                        <div class="team-avatar-badge">
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <h4 class="team-name">Jane Smith</h4>
                    <p class="team-role">Marketing Head</p>
                    <p class="team-bio">
                        Creative marketing expert passionate about building brand experiences.
                    </p>
                    <div class="team-socials">
                        <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="team-social-link"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="team-social-link"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card">
                    <div class="team-avatar-wrapper">
                        <img src="https://randomuser.me/api/portraits/men/65.jpg"
                             class="team-avatar" alt="Michael Lee">
                        <div class="team-avatar-badge">
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <h4 class="team-name">Michael Lee</h4>
                    <p class="team-role">Technical Lead</p>
                    <p class="team-bio">
                        Full-stack developer with expertise in building scalable platforms.
                    </p>
                    <div class="team-socials">
                        <a href="#" class="team-social-link"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="team-social-link"><i class="bi bi-github"></i></a>
                        <a href="#" class="team-social-link"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-card" data-aos="zoom-in" data-aos-duration="800">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Explore Events?</h2>
                <p class="cta-text">
                    Join thousands of people discovering amazing experiences every day.
                </p>
                <a href="events.php" class="btn-cta">
                    <i class="bi bi-rocket-takeoff"></i>
                    Browse Events Now
                </a>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true,
    offset: 50
});
</script>

<?php include('includes/footer.php'); ?>