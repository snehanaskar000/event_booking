    <!-- ═══════════ SHARED FOOTER ═══════════ -->
    <footer class="footer mt-auto">
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
                    <a href="events.php" class="footer-link">Events</a>
                    <a href="about.php" class="footer-link">About</a>
                    <a href="contact.php" class="footer-link">Contact</a>
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
                © <?php echo date("Y"); ?> EventBook. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Base Scripts Loaded Everywhere -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</body>
</html>