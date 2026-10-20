<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$role = $_SESSION['user_role'] ?? '';
if (in_array($role, ['admin', 'receptionist', 'stylist'], true)) {
    header('Location: ../admin/dashboard.php');
    exit;
}

$name = $_SESSION['user_name'] ?? 'Customer';
$email = '';
$phone = '';

$stmt = $pdo->prepare("SELECT email, phone FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$row = $stmt->fetch();
if ($row) {
    $email = $row['email'] ?? '';
    $phone = $row['phone'] ?? '';
}

$appointments = [];
if ($email) {
    $c = $pdo->prepare("SELECT id FROM clients WHERE email = ? LIMIT 1");
    $c->execute([$email]);
    $client = $c->fetch();
    if ($client) {
        try {
            $q = $pdo->prepare("
                SELECT a.*, s.name AS service_name
                FROM appointments a
                JOIN services s ON s.id = a.service_id
                WHERE a.client_id = ?
                ORDER BY a.appointment_date DESC, a.appointment_time DESC
                LIMIT 12
            ");
            $q->execute([$client['id']]);
            $appointments = $q->fetchAll();
        } catch (PDOException $e) {
            $appointments = [];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: var(--black, #0B0A0A); min-height: 100vh; color: var(--cream, #F5F1EA); }
        .cust-nav {
            background: #121010;
            border-bottom: 1px solid rgba(214,185,140,0.15);
            padding: 14px 0;
        }
        .cust-nav .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: #F5F1EA;
            letter-spacing: 1px;
            text-decoration: none;
        }
        .cust-nav a.nav-link-c {
            color: #A9A3A0;
            font-size: 0.88rem;
            margin-left: 1rem;
            text-decoration: none;
        }
        .cust-nav a.nav-link-c:hover { color: #D6B98C; }
        .welcome-card {
            background: linear-gradient(135deg, #4B141D, #181414);
            border: 1px solid rgba(214,185,140,0.2);
            border-radius: 18px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }
        .welcome-card h1 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin: 0.3rem 0; }
        .panel {
            background: #181414;
            border: 1px solid rgba(214,185,140,0.15);
            border-radius: 16px;
            padding: 1.4rem;
            margin-bottom: 1.2rem;
            height: 100%;
        }
        .panel h3 { font-size: 1.05rem; color: #D6B98C; margin-bottom: 1rem; }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.85rem;
        }
        .quick-btn {
            display: flex; flex-direction: column; align-items: center; gap: 0.45rem;
            padding: 1.15rem 0.75rem; background: #121010;
            border: 1px solid rgba(214,185,140,0.15); border-radius: 12px;
            color: #F5F1EA; text-decoration: none; text-align: center; transition: 0.3s;
        }
        .quick-btn i { color: #D6B98C; font-size: 1.25rem; }
        .quick-btn:hover { border-color: #D6B98C; transform: translateY(-3px); color: #F5F1EA; }
        .appt-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0.8rem 0; border-bottom: 1px solid rgba(255,255,255,0.06); gap: 1rem; flex-wrap: wrap;
        }
        .appt-row:last-child { border-bottom: 0; }
        .badge-soft {
            font-size: 0.75rem; padding: 0.25rem 0.7rem; border-radius: 999px;
            background: rgba(214,185,140,0.15); color: #D6B98C;
        }
        .eyebrow { font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; color: #D6B98C; font-weight: 600; }
    </style>
</head>
<body>
    <?php
    require_once 'C:\xampp\htdocs\new\includes\header.php';
?>
<div class="container py-5">
    <div class="welcome-card">
        <span class="eyebrow">Customer Account</span>
        <h1>Welcome, <?php echo htmlspecialchars($name); ?></h1>
        <p class="mb-0" style="color:#A9A3A0;">Book services, track appointments, and manage your visits.</p>
    </div>

    <div class="panel">
        <h3><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
        <div class="quick-actions">
            <a href="../book.php" class="quick-btn"><i class="fas fa-calendar-plus"></i><span>Book Now</span></a>
            <a href="../services.php" class="quick-btn"><i class="fas fa-spa"></i><span>Services</span></a>
            <a href="../contact.php" class="quick-btn"><i class="fas fa-envelope"></i><span>Contact</span></a>
            <a href="../feedback.php" class="quick-btn"><i class="fas fa-star"></i><span>Feedback</span></a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="panel">
                <h3><i class="fas fa-user me-2"></i>Profile</h3>
                <p class="mb-2"><strong>Name</strong><br><?php echo htmlspecialchars($name); ?></p>
                <p class="mb-2"><strong>Email</strong><br><?php echo htmlspecialchars($email); ?></p>
                <p class="mb-0"><strong>Phone</strong><br><?php echo htmlspecialchars($phone ?: '—'); ?></p>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel">
                <h3><i class="fas fa-calendar-check me-2"></i>My Appointments</h3>
                <?php if (empty($appointments)): ?>
                    <p style="color:#A9A3A0;margin:0;">No appointments yet. <a href="../book.php" style="color:#D6B98C;">Book your first visit</a></p>
                <?php else: ?>
                    <?php foreach ($appointments as $a): ?>
                        <div class="appt-row">
                            <div>
                                <strong><?php echo htmlspecialchars($a['service_name']); ?></strong><br>
                                <small style="color:#A9A3A0;">
                                    <?php echo date('M d, Y', strtotime($a['appointment_date'])); ?>
                                    · <?php echo date('h:i A', strtotime($a['appointment_time'])); ?>
                                </small>
                            </div>
                            <span class="badge-soft"><?php echo htmlspecialchars(ucfirst($a['status'])); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
