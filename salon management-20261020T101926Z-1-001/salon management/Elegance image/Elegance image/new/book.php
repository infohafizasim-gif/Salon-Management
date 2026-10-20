<?php
$pageTitle = "Book Appointment";
$activePage = "book";
require_once 'config/database.php';
require_once 'includes/header.php';

$success = '';
$error = '';
$services = [];

try {
    $services = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY category, name")->fetchAll();
} catch (Exception $e) {
    $services = [
        ['id' => 1, 'name' => 'Precision Haircut', 'duration' => 45, 'price' => 65, 'category' => 'Hair'],
        ['id' => 2, 'name' => 'Hair Color & Highlights', 'duration' => 90, 'price' => 120, 'category' => 'Hair'],
        ['id' => 3, 'name' => 'Signature Facial', 'duration' => 60, 'price' => 95, 'category' => 'Skin'],
        ['id' => 4, 'name' => 'Gel Manicure', 'duration' => 45, 'price' => 45, 'category' => 'Beauty'],
        ['id' => 5, 'name' => 'Relaxation Massage', 'duration' => 60, 'price' => 110, 'category' => 'Wellness'],
        ['id' => 6, 'name' => 'Bridal Makeup', 'duration' => 90, 'price' => 180, 'category' => 'Beauty'],
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service_id = (int)($_POST['service_id'] ?? 0);
    $date = $_POST['appointment_date'] ?? '';
    $time = $_POST['appointment_time'] ?? '';
    $notes = trim($_POST['notes'] ?? '');

    if (empty($name) || empty($phone) || empty($service_id) || empty($date) || empty($time)) {
        $error = 'Please fill all required fields.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM clients WHERE phone = ? OR email = ?");
            $stmt->execute([$phone, $email]);
            $client = $stmt->fetch();

            if ($client) {
                $client_id = $client['id'];
            } else {
                $stmt = $pdo->prepare("INSERT INTO clients (name, email, phone) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $phone]);
                $client_id = $pdo->lastInsertId();
            }

            $stmt = $pdo->prepare("INSERT INTO appointments (client_id, service_id, appointment_date, appointment_time, status, notes) VALUES (?, ?, ?, ?, 'pending', ?)");
            $stmt->execute([$client_id, $service_id, $date, $time, $notes]);

            $success = 'Appointment booked successfully! We will confirm shortly.';
        } catch (Exception $e) {
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?>

<!-- ================= BOOK HERO ================= -->
<section class="book-hero py-5">
    <div class="container py-lg-3 text-center">
        <span class="section-kicker">RESERVE YOUR SPOT</span>
        <h1 class="display-heading mb-3">Book Your <em>Appointment</em></h1>
        <div class="divider mx-auto"></div>
        <p class="section-text mx-auto" style="max-width: 520px;">
            Luxury care, personalized for you. Choose a service, pick your time, and we’ll take care of the rest.
        </p>
    </div>
</section>

<!-- ================= BOOKING FORM ================= -->
<section class="py-5 book-body">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <?php if ($success): ?>
                <div class="book-alert book-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Booking Confirmed</strong>
                        <span><?php echo htmlspecialchars($success); ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="book-alert book-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Oops</strong>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                </div>
                <?php endif; ?>

                <form method="POST" action="" class="book-form" id="bookingForm">

                    <!-- STEP 1: Service -->
                    <div class="book-step">
                        <div class="book-step-header">
                            <span class="step-num">01</span>
                            <div>
                                <h3>Select Service</h3>
                                <p>Choose the treatment you’d like</p>
                            </div>
                        </div>
                        <div class="row g-3">
                            <?php if (empty($services)): ?>
                                <div class="col-12">
                                    <p style="color: var(--muted);">No services available at the moment.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($services as $service): ?>
                                <div class="col-md-6 col-lg-4">
                                    <label class="service-pick">
                                        <input type="radio" name="service_id" value="<?php echo (int)$service['id']; ?>" required>
                                        <div class="service-pick-card">
                                            <div class="service-pick-top">
                                                <span class="service-pick-cat"><?php echo htmlspecialchars($service['category'] ?? 'Service'); ?></span>
                                                <span class="service-pick-price">$<?php echo number_format((float)$service['price'], 0); ?></span>
                                            </div>
                                            <h4><?php echo htmlspecialchars($service['name']); ?></h4>
                                            <span class="service-pick-dur"><i class="far fa-clock"></i> <?php echo (int)$service['duration']; ?> min</span>
                                            <div class="service-pick-check"><i class="fas fa-check"></i></div>
                                        </div>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- STEP 2: Date & Time -->
                    <div class="book-step">
                        <div class="book-step-header">
                            <span class="step-num">02</span>
                            <div>
                                <h3>Date & Time</h3>
                                <p>When would you like to visit?</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="book-label">Preferred Date *</label>
                                <input type="date" name="appointment_date" class="book-input" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="book-label">Preferred Time *</label>
                                <select name="appointment_time" class="book-input" required>
                                    <option value="">Choose time</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                    <option value="18:00">6:00 PM</option>
                                    <option value="19:00">7:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Your Info -->
                    <div class="book-step">
                        <div class="book-step-header">
                            <span class="step-num">03</span>
                            <div>
                                <h3>Your Details</h3>
                                <p>So we can confirm your booking</p>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="book-label">Full Name *</label>
                                <input type="text" name="name" class="book-input" placeholder="Your name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="book-label">Email</label>
                                <input type="email" name="email" class="book-input" placeholder="you@email.com">
                            </div>
                            <div class="col-md-4">
                                <label class="book-label">Phone *</label>
                                <input type="tel" name="phone" class="book-input" placeholder="+1 234 567 890" required>
                            </div>
                            <div class="col-12">
                                <label class="book-label">Notes <span style="color:var(--muted);font-weight:400">(optional)</span></label>
                                <textarea name="notes" class="book-input" rows="3" placeholder="Any special requests or preferences..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="book-submit-wrap">
                        <button type="submit" class="btn btn-gold btn-lg book-submit-btn">
                            <i class="fas fa-calendar-check"></i> Confirm Booking
                        </button>
                        <p class="book-note">You’ll receive a confirmation shortly after booking.</p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<style>
/* ===== BOOK PAGE ===== */
.book-hero { background: var(--black-soft, #121010); }
.book-body { background: var(--black, #0B0A0A); }

.book-alert {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1.15rem 1.35rem; border-radius: 16px; margin-bottom: 1.75rem;
}
.book-alert i { font-size: 1.3rem; margin-top: 2px; }
.book-alert strong { display: block; margin-bottom: 0.2rem; }
.book-alert span { font-size: 0.9rem; opacity: 0.9; }
.book-alert-success {
    background: rgba(40, 167, 69, 0.12);
    border: 1px solid rgba(40, 167, 69, 0.35);
    color: #7dcea0;
}
.book-alert-error {
    background: rgba(220, 53, 69, 0.12);
    border: 1px solid rgba(220, 53, 69, 0.35);
    color: #f1948a;
}

.book-step {
    background: linear-gradient(145deg, #1a1515 0%, #121010 100%);
    border: 1px solid rgba(214,185,140,0.14);
    border-radius: 22px;
    padding: 2rem 1.75rem;
    margin-bottom: 1.5rem;
}
.book-step-header {
    display: flex; align-items: center; gap: 1rem;
    margin-bottom: 1.5rem; padding-bottom: 1.15rem;
    border-bottom: 1px solid rgba(214,185,140,0.1);
}
.step-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; color: var(--champagne, #D6B98C);
    opacity: 0.7; min-width: 42px;
}
.book-step-header h3 {
    font-size: 1.2rem; color: var(--cream, #F5F1EA); margin: 0 0 0.15rem;
}
.book-step-header p {
    font-size: 0.85rem; color: var(--muted, #A9A3A0); margin: 0;
}

.service-pick { display: block; cursor: pointer; }
.service-pick input { display: none; }
.service-pick-card {
    position: relative;
    background: rgba(255,255,255,0.02);
    border: 1.5px solid rgba(214,185,140,0.14);
    border-radius: 16px;
    padding: 1.2rem 1.15rem;
    height: 100%;
    transition: all 0.3s ease;
}
.service-pick-card:hover {
    border-color: rgba(214,185,140,0.35);
    background: rgba(214,185,140,0.04);
}
.service-pick input:checked + .service-pick-card {
    border-color: var(--champagne, #D6B98C);
    background: rgba(214,185,140,0.08);
    box-shadow: 0 0 0 1px rgba(214,185,140,0.25);
}
.service-pick-top {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 0.6rem;
}
.service-pick-cat {
    font-size: 0.68rem; font-weight: 600; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--champagne, #D6B98C);
    background: rgba(214,185,140,0.12);
    padding: 0.2rem 0.55rem; border-radius: 999px;
}
.service-pick-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem; color: var(--champagne, #D6B98C); font-weight: 600;
}
.service-pick-card h4 {
    font-size: 1rem; color: var(--cream, #F5F1EA);
    margin: 0 0 0.4rem; line-height: 1.35;
}
.service-pick-dur { font-size: 0.8rem; color: var(--muted, #A9A3A0); }
.service-pick-check {
    position: absolute; top: 12px; right: 12px;
    width: 22px; height: 22px; border-radius: 50%;
    background: var(--champagne, #D6B98C); color: #0B0A0A;
    font-size: 0.65rem; display: grid; place-items: center;
    opacity: 0; transform: scale(0.6); transition: all 0.25s ease;
}
.service-pick input:checked + .service-pick-card .service-pick-check {
    opacity: 1; transform: scale(1);
}

.book-label {
    display: block; font-size: 0.85rem; font-weight: 500;
    color: var(--cream, #F5F1EA); margin-bottom: 0.45rem;
}
.book-input {
    width: 100%;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(214,185,140,0.18);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    color: var(--cream, #F5F1EA);
    font-size: 0.95rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    outline: none;
}
.book-input:focus {
    border-color: var(--champagne, #D6B98C);
    box-shadow: 0 0 0 3px rgba(214,185,140,0.12);
}
.book-input::placeholder { color: rgba(169,163,160,0.6); }
select.book-input {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='%23D6B98C'%3E%3Cpath d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    padding-right: 2.5rem;
}
textarea.book-input { resize: vertical; min-height: 90px; }

.book-submit-wrap { text-align: center; padding: 1.5rem 0 0.5rem; }
.book-submit-btn { min-width: 240px; }
.book-note { font-size: 0.82rem; color: var(--muted, #A9A3A0); margin-top: 1rem; }

@media (max-width: 576px) {
    .book-step { padding: 1.4rem 1.15rem; }
    .book-step-header { gap: 0.75rem; }
}
</style>

<?php require_once 'includes/footer.php'; ?>