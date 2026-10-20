<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

function redirect_by_role(string $role): void {
    if (in_array($role, ['admin', 'receptionist', 'stylist'], true)) {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: customer/index.php');
    }
    exit;
}

if (isset($_SESSION['user_id'])) {
    redirect_by_role($_SESSION['user_role'] ?? '');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name             = trim($_POST['name'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $phone            = trim($_POST['phone'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($name === '' || $email === '' || $password === '' || $confirm_password === '') {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $check->execute([$email]);
            if ($check->fetch()) {
                $error = 'This email is already registered. Please sign in.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // ALWAYS client — never admin
                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, phone, password, role, status)
                     VALUES (?, ?, ?, ?, 'client', 'active')"
                );
                $stmt->execute([$name, $email, $phone !== '' ? $phone : null, $hash]);

                // Sync to clients table for bookings
                $c = $pdo->prepare("SELECT id FROM clients WHERE email = ? LIMIT 1");
                $c->execute([$email]);
                if (!$c->fetch()) {
                    $pdo->prepare("INSERT INTO clients (name, email, phone) VALUES (?, ?, ?)")
                        ->execute([$name, $email, $phone !== '' ? $phone : 'N/A']);
                }

                // Auto-login as customer
                $_SESSION['user_id']   = (int) $pdo->lastInsertId();
                $_SESSION['user_name'] = $name;
                $_SESSION['user_role'] = 'client';
                header('Location: customer/index.php');
                exit;
            }
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'Data truncated') !== false || strpos($msg, 'client') !== false) {
                $error = 'Database update needed. Run in phpMyAdmin: ALTER TABLE users MODIFY role ENUM(\'admin\',\'receptionist\',\'stylist\',\'client\') DEFAULT \'client\';';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --black: #0B0A0A;
            --black-soft: #121010;
            --black-card: #181414;
            --burgundy: #6D1F2B;
            --champagne: #D6B98C;
            --champagne-light: #E8D4AE;
            --cream: #F5F1EA;
            --muted: #A9A3A0;
            --border: rgba(214, 185, 140, 0.22);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--black);
            color: var(--cream);
            min-height: 100vh;
        }
        .signup-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
        }
        .signup-visual {
            position: relative;
            background:
                linear-gradient(160deg, rgba(11,10,10,0.55) 0%, rgba(75,20,29,0.72) 100%),
                url('assets/img/hero.jpeg') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem;
            overflow: hidden;
        }
        .signup-visual::before {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(214,185,140,0.08);
            top: -80px;
            right: -60px;
        }
        .signup-visual::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(109,31,43,0.25);
            bottom: 10%;
            left: -40px;
        }
        .brand-row {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            letter-spacing: 2px;
            color: var(--cream);
        }
        .brand-row i { color: var(--champagne); }
        .visual-copy {
            position: relative;
            z-index: 2;
            max-width: 420px;
        }
        .visual-copy .eyebrow {
            display: inline-block;
            font-size: 0.72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--champagne);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .visual-copy h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            line-height: 1.15;
            margin: 0 0 1rem;
            color: #fff;
        }
        .visual-copy h1 em {
            font-style: italic;
            color: var(--champagne);
        }
        .visual-copy p {
            color: rgba(245,241,234,0.75);
            line-height: 1.75;
            margin: 0;
        }
        .perk-list {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 2rem;
        }
        .perk {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: rgba(245,241,234,0.85);
        }
        .perk span {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: rgba(214,185,140,0.15);
            border: 1px solid rgba(214,185,140,0.3);
            color: var(--champagne);
            font-size: 0.7rem;
        }
        .signup-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            background: radial-gradient(ellipse at 80% 0%, rgba(109,31,43,0.2), transparent 50%), var(--black);
        }
        .signup-card {
            width: 100%;
            max-width: 440px;
            background: linear-gradient(160deg, #1c1616 0%, #121010 100%);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.25rem 2rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.45);
        }
        .signup-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            margin: 0 0 0.35rem;
            text-align: center;
        }
        .signup-card .sub {
            text-align: center;
            color: var(--muted);
            font-size: 0.92rem;
            margin-bottom: 1.75rem;
        }
        .form-label-elegant {
            display: block;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--cream);
            margin-bottom: 0.35rem;
        }
        .form-control-elegant {
            width: 100%;
            background: rgba(0,0,0,0.35);
            border: 1px solid rgba(214,185,140,0.22);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            color: var(--cream);
            font-size: 0.92rem;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
        }
        .form-control-elegant:focus {
            border-color: var(--champagne);
            box-shadow: 0 0 0 3px rgba(214,185,140,0.12);
        }
        .form-control-elegant::placeholder { color: #6a6560; }
        .mb-field { margin-bottom: 1rem; }
        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
        }
        .btn-signup {
            width: 100%;
            border: none;
            border-radius: 999px;
            padding: 0.9rem 1.25rem;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.03em;
            background: linear-gradient(135deg, var(--champagne), #c4a574);
            color: #0B0A0A;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.35rem;
        }
        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(214,185,140,0.3);
        }
        .alert-box {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.88rem;
            margin-bottom: 1rem;
        }
        .alert-err {
            background: rgba(180,40,55,0.15);
            border: 1px solid rgba(226,138,149,0.35);
            color: #E28A95;
        }
        .switch-line {
            text-align: center;
            margin-top: 1.35rem;
            font-size: 0.9rem;
            color: var(--muted);
        }
        .switch-line a {
            color: var(--champagne);
            font-weight: 600;
            text-decoration: none;
        }
        .switch-line a:hover { color: var(--champagne-light); }
        .back-home {
            display: block;
            text-align: center;
            margin-top: 0.85rem;
            font-size: 0.82rem;
            color: var(--muted);
            text-decoration: none;
        }
        .back-home:hover { color: var(--champagne); }
        .terms {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: var(--muted);
            margin: 0.75rem 0 1rem;
        }
        .terms input { margin-top: 3px; accent-color: var(--champagne); }
        @media (max-width: 900px) {
            .signup-page { grid-template-columns: 1fr; }
            .signup-visual { min-height: 240px; padding: 1.5rem; }
            .perk-list { display: none; }
            .visual-copy h1 { font-size: 1.8rem; }
        }
        @media (max-width: 520px) {
            .row-2 { grid-template-columns: 1fr; }
            .signup-card { padding: 1.75rem 1.25rem; }
        }
    </style>
</head>
<body>
<div class="signup-page">
    <aside class="signup-visual">
        <div class="brand-row">
            <i class="fas fa-spa"></i> ELEGANCE SALON
        </div>
        <div>
            <div class="visual-copy">
                <span class="eyebrow">Join the experience</span>
                <h1>Your beauty journey starts <em>here.</em></h1>
                <p>Create a free customer account to book appointments, track visits, and enjoy a personalized salon experience.</p>
            </div>
            <div class="perk-list">
                <div class="perk"><span><i class="fas fa-check"></i></span> Easy online booking</div>
                <div class="perk"><span><i class="fas fa-check"></i></span> Track your appointments</div>
                <div class="perk"><span><i class="fas fa-check"></i></span> Exclusive member care</div>
            </div>
        </div>
        <div style="position:relative;z-index:2;font-size:0.78rem;color:rgba(255,255,255,0.45);">
            © <?php echo date('Y'); ?> Elegance Salon
        </div>
    </aside>

    <main class="signup-form-side">
        <div class="signup-card">
            <h2>Create Account</h2>
            <p class="sub">Customer sign up — takes less than a minute</p>

            <?php if ($error): ?>
                <div class="alert-box alert-err"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="" autocomplete="off">
                <div class="mb-field">
                    <label class="form-label-elegant">Full Name *</label>
                    <input type="text" name="name" class="form-control-elegant" placeholder="Your full name" required
                           value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                </div>
                <div class="mb-field">
                    <label class="form-label-elegant">Email *</label>
                    <input type="email" name="email" class="form-control-elegant" placeholder="you@example.com" required
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                <div class="mb-field">
                    <label class="form-label-elegant">Phone</label>
                    <input type="tel" name="phone" class="form-control-elegant" placeholder="03XX-XXXXXXX"
                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                </div>
                <div class="row-2 mb-field">
                    <div>
                        <label class="form-label-elegant">Password *</label>
                        <input type="password" name="password" class="form-control-elegant" placeholder="Min. 6 chars" required minlength="6">
                    </div>
                    <div>
                        <label class="form-label-elegant">Confirm *</label>
                        <input type="password" name="confirm_password" class="form-control-elegant" placeholder="Re-enter" required minlength="6">
                    </div>
                </div>
                <label class="terms">
                    <input type="checkbox" required>
                    <span>I agree to the terms of service & privacy policy</span>
                </label>
                <button type="submit" class="btn-signup">
                    <i class="fas fa-user-plus"></i> Create Customer Account
                </button>
            </form>

            <div class="switch-line">
                Already a member? <a href="login.php">Sign In</a>
            </div>
            <a href="index.php" class="back-home"><i class="fas fa-arrow-left me-1"></i> Back to Home</a>
        </div>
    </main>
</div>
</body>
</html>
