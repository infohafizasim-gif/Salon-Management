<?php
$pageTitle = "Contact Us";
$activePage = "contact";
require_once 'includes/header.php';
?>

<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>Contact Us</h2>
            <div class="divider"></div>
            <p>We would love to hear from you</p>
        </div>
        <div class="row g-5">
            <div class="col-lg-5">
                <div class="card-elegant h-100">
                    <h5 class="mb-4">Get in Touch</h5>
                    <div class="d-flex gap-3 mb-4">
                        <div class="kpi-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h6 class="mb-1">Address</h6>
                            <p class="text-muted mb-0">123 Luxury Lane, Clifton, Karachi</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <div class="kpi-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h6 class="mb-1">Phone</h6>
                            <p class="text-muted mb-0">+92 300 1234567</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <div class="kpi-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h6 class="mb-1">Email</h6>
                            <p class="text-muted mb-0">info@elegancesalon.com</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="kpi-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h6 class="mb-1">Opening Hours</h6>
                            <p class="text-muted mb-0">Mon – Sat: 10:00 AM – 8:00 PM<br>Sunday: Closed</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-elegant">
                    <h5 class="mb-4">Send a Message</h5>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-elegant">Name</label>
                                <input type="text" class="form-control form-control-elegant" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-elegant">Email</label>
                                <input type="email" class="form-control form-control-elegant" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-elegant">Subject</label>
                                <input type="text" class="form-control form-control-elegant">
                            </div>
                            <div class="col-12">
                                <label class="form-label-elegant">Message</label>
                                <textarea class="form-control form-control-elegant" rows="4" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-gold">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
