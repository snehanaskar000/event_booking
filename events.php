<?php
include('includes/header.php');
include('includes/db.php');

// Get events with filters
$status = isset($_GET['status']) ? $_GET['status'] : 'upcoming';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM events WHERE status = '$status'";
if (!empty($search)) {
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%' OR location LIKE '%$search%')";
}
$query .= " ORDER BY event_date ASC";

$events = mysqli_query($conn, $query);
?>

<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════════════════════
   EVENTS PAGE STYLES
═══════════════════════════════════════════════════════════ */

:root {
    --primary: #7c3aed;
    --primary-light: #a78bfa;
    --secondary: #ec4899;
    --accent: #f59e0b;
    --dark: #1e1b4b;
    --text: #334155;
    --text-light: #64748b;
    --bg-light: #f8fafc;
    --white: #ffffff;
    --success: #10b981;
    --danger: #ef4444;
    --gray: #94a3b8;
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
    background: var(--bg-light);
}

/* ═══════════════════════════════════════════════════════════
   HERO SECTION
═══════════════════════════════════════════════════════════ */
.events-hero {
    min-height: 60vh;
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    padding: 140px 20px 100px;
}

/* Animated Shapes */
.hero-shape {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.4;
    animation: float-shape 15s infinite ease-in-out;
}

.hero-shape-1 {
    width: 500px;
    height: 500px;
    background: var(--primary);
    top: -200px;
    right: -100px;
}

.hero-shape-2 {
    width: 400px;
    height: 400px;
    background: var(--secondary);
    bottom: -150px;
    left: -100px;
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
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.hero-title span {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-subtitle {
    font-size: 1.15rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 2rem;
}

.search-bar {
    max-width: 600px;
    margin: 0 auto;
    display: flex;
    background: white;
    border-radius: 100px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

.search-bar input {
    flex: 1;
    padding: 18px 25px;
    border: none;
    font-size: 1rem;
    outline: none;
}

.search-bar button {
    padding: 18px 35px;
    background: var(--gradient);
    color: white;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.search-bar button:hover {
    background: linear-gradient(135deg, #5b21b6, #7c3aed);
}

/* ═══════════════════════════════════════════════════════════
   FILTER BAR
═══════════════════════════════════════════════════════════ */
.filter-bar {
    background: var(--white);
    padding: 25px 0;
    border-bottom: 1px solid #e2e8f0;
    position: sticky;
    top: 80px;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.filter-tabs {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 12px 30px;
    background: var(--bg-light);
    color: var(--text);
    border: 2px solid transparent;
    border-radius: 100px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: 0.3s ease;
    text-decoration: none;
}

.filter-tab:hover,
.filter-tab.active {
    background: var(--gradient);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

/* ═══════════════════════════════════════════════════════════
   SECTION HEADER
═══════════════════════════════════════════════════════════ */
.section-padding {
    padding: 100px 0;
    background: var(--bg-light);
}

.section-header {
    margin-bottom: 50px;
}

.section-header h2 {
    font-size: 2rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.section-header p {
    color: var(--text-light);
    font-size: 1.05rem;
}

.events-count {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 18px;
    background: rgba(124, 58, 237, 0.1);
    color: var(--primary);
    border-radius: 100px;
    font-weight: 600;
    font-size: 0.9rem;
}

/* ═══════════════════════════════════════════════════════════
   EVENT CARDS
═══════════════════════════════════════════════════════════ */
.event-card {
    background: var(--white);
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
}

.event-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 60px rgba(124, 58, 237, 0.15);
    border-color: transparent;
}

.event-image-wrapper {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.event-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.6s ease;
}

.event-card:hover .event-image {
    transform: scale(1.1);
}

/* Status Badge */
.status-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 8px 16px;
    border-radius: 100px;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
    z-index: 10;
}

.status-upcoming {
    background: rgba(16, 185, 129, 0.95);
    color: white;
}

.status-completed {
    background: rgba(107, 114, 128, 0.95);
    color: white;
}

.status-cancelled {
    background: rgba(239, 68, 68, 0.95);
    color: white;
}

/* Price Badge */
.price-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    padding: 10px 18px;
    background: white;
    border-radius: 100px;
    font-weight: 700;
    font-size: 1rem;
    color: var(--primary);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    z-index: 10;
}

/* Category Badge */
.category-badge {
    position: absolute;
    bottom: 16px;
    left: 16px;
    padding: 6px 14px;
    background: var(--dark);
    color: white;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 10;
}

/* Card Body */
.event-card-body {
    padding: 25px;
}

.event-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 60px;
}

.event-meta {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 15px;
}

.event-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-light);
    font-size: 0.95rem;
}

.event-meta-icon {
    width: 35px;
    height: 35px;
    background: var(--bg-light);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1rem;
}

.event-description {
    color: var(--text-light);
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Buttons */
.btn-book {
    width: 100%;
    padding: 14px;
    background: var(--gradient);
    color: white;
    border: none;
    border-radius: 14px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3);
    color: white;
}

.btn-disabled {
    background: var(--gray);
    cursor: not-allowed;
    opacity: 0.6;
}

.btn-disabled:hover {
    transform: none;
    box-shadow: none;
}

/* ═══════════════════════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════════════════════ */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: var(--bg-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    color: var(--gray);
    font-size: 3rem;
}

.empty-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 10px;
}

.empty-text {
    color: var(--text-light);
    font-size: 1.05rem;
    margin-bottom: 25px;
}

.btn-primary {
    padding: 14px 35px;
    background: var(--gradient);
    color: white;
    border: none;
    border-radius: 100px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(124, 58, 237, 0.3);
    color: white;
}

/* ═══════════════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
    .events-hero {
        padding: 120px 20px 80px;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .search-bar {
        flex-direction: column;
        border-radius: 20px;
    }

    .search-bar input,
    .search-bar button {
        width: 100%;
    }

    .filter-bar {
        top: 70px;
    }

    .filter-tabs {
        padding: 0 15px;
        overflow-x: auto;
        justify-content: flex-start;
    }

    .section-padding {
        padding: 60px 0;
    }
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════ -->
<section class="events-hero">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>

    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <div class="hero-badge">
            <i class="bi bi-calendar-event"></i>
            Browse All Events
        </div>
        <h1 class="hero-title">
            Discover <span>Amazing</span><br>Events Near You
        </h1>
        <p class="hero-subtitle">
            Find and book tickets for conferences, concerts, workshops, and more
        </p>

        <form class="search-bar" method="GET" action="">
            <input type="text" name="search" placeholder="Search events by name, location..."
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">
                <i class="bi bi-search me-2"></i> Search
            </button>
        </form>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     FILTER BAR
═══════════════════════════════════════════════════════════ -->
<section class="filter-bar">
    <div class="container">
        <div class="filter-tabs">
            <a href="events.php" class="filter-tab <?php echo !isset($_GET['status']) ? 'active' : ''; ?>">
                <i class="bi bi-grid me-2"></i> All Events
            </a>
            <a href="events.php?status=upcoming" class="filter-tab <?php echo (isset($_GET['status']) && $_GET['status']=='upcoming') ? 'active' : ''; ?>">
                <i class="bi bi-calendar-check me-2"></i> Upcoming
            </a>
            <a href="events.php?status=completed" class="filter-tab <?php echo (isset($_GET['status']) && $_GET['status']=='completed') ? 'active' : ''; ?>">
                <i class="bi bi-check-circle me-2"></i> Completed
            </a>
            <a href="events.php?status=cancelled" class="filter-tab <?php echo (isset($_GET['status']) && $_GET['status']=='cancelled') ? 'active' : ''; ?>">
                <i class="bi bi-x-circle me-2"></i> Cancelled
            </a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     EVENTS GRID
═══════════════════════════════════════════════════════════ -->
<section class="section-padding">
    <div class="container">

        <!-- Section Header -->
        <div class="section-header d-flex justify-content-between align-items-center flex-wrap gap-3" data-aos="fade-up">
            <div>
                <h2>
                    <?php
                    if(isset($_GET['status'])) {
                        echo ucfirst($_GET['status']) . ' Events';
                    } else {
                        echo 'All Events';
                    }
                    ?>
                </h2>
                <p>Explore our curated collection of amazing events</p>
            </div>
            <div class="events-count">
                <i class="bi bi-calendar3"></i>
                <?php echo mysqli_num_rows($events); ?> Events Found
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row g-4">

            <?php if(mysqli_num_rows($events) > 0) {
                $delay = 0;
                while($row = mysqli_fetch_assoc($events)) {
            ?>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="event-card">
                    <div class="event-image-wrapper">
                        <!-- Status Badge -->
                        <span class="status-badge status-<?php echo $row['status']; ?>">
                            <?php
                            if($row['status'] == 'upcoming') echo '<i class="bi bi-calendar-check me-1"></i>';
                            elseif($row['status'] == 'completed') echo '<i class="bi bi-check-circle me-1"></i>';
                            else echo '<i class="bi bi-x-circle me-1"></i>';
                            ?>
                            <?php echo ucfirst($row['status']); ?>
                        </span>

                        <!-- Price Badge -->
                        <span class="price-badge">
                            ₹<?php echo number_format($row['price'], 0); ?>
                        </span>

                        <!-- Category Badge -->
                        <?php if(isset($row['category'])): ?>
                        <span class="category-badge">
                            <?php echo htmlspecialchars($row['category']); ?>
                        </span>
                        <?php endif; ?>

                        <!-- Event Image -->
                        <?php
                        $img = "uploads/" . $row['event_image'];
                        if(!file_exists($img) || empty($row['event_image'])) {
                            $img = "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=800&q=80";
                        }
                        ?>
                        <img src="<?php echo $img; ?>" class="event-image" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    </div>

                    <div class="event-card-body">
                        <h3 class="event-title">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </h3>

                        <div class="event-meta">
                            <div class="event-meta-item">
                                <div class="event-meta-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <span>
                                    <?php echo date("d M Y", strtotime($row['event_date'])); ?>
                                </span>
                            </div>

                            <?php if(isset($row['location']) && !empty($row['location'])): ?>
                            <div class="event-meta-item">
                                <div class="event-meta-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <span><?php echo htmlspecialchars($row['location']); ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if(isset($row['description']) && !empty($row['description'])): ?>
                        <p class="event-description">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </p>
                        <?php endif; ?>

                        <!-- Action Button -->
                        <?php if($row['status'] == 'upcoming'): ?>
                            <a href="book-event.php?id=<?php echo $row['id']; ?>" class="btn-book">
                                <i class="bi bi-ticket-perforated me-2"></i> Book Now
                            </a>
                        <?php else: ?>
                            <button class="btn-book btn-disabled" disabled>
                                <i class="bi bi-lock me-2"></i> Booking Closed
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php
                $delay += 100;
                }
            } else {
            ?>

            <!-- Empty State -->
            <div class="col-12">
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3 class="empty-title">No Events Found</h3>
                    <p class="empty-text">
                        We couldn't find any events matching your criteria.<br>
                        Try adjusting your filters or check back later.
                    </p>
                    <a href="events.php" class="btn-primary">
                        <i class="bi bi-arrow-left me-2"></i> View All Events
                    </a>
                </div>
            </div>

            <?php } ?>

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