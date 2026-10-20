<?php
require_once 'includes/auth_check.php';
require_once '../config/database.php';

$adminPage = 'appointments';
$pageTitle = 'Appointments';

// Update status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    $allowed = ['confirmed', 'completed', 'cancelled'];
    if (in_array($action, $allowed)) {
        $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        $stmt->execute([$action, $id]);
        header('Location: appointments.php');
        exit;
    }
}

$appointments = $pdo->query("
    SELECT a.*, c.name as client_name, c.phone as client_phone, s.name as service_name, s.price
    FROM appointments a
    JOIN clients c ON a.client_id = c.id
    JOIN services s ON a.service_id = s.id
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <div class="topbar">
            <h5 class="mb-0">Appointments</h5>
            <a href="../logout.php" class="btn btn-sm btn-outline-gold">Logout</a>
        </div>
        <div class="content-area">
            <div class="card-elegant">
                <div class="table-responsive">
                    <table class="table table-elegant mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Client</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($appointments)): ?>
                                <tr><td colspan="9" class="text-center text-muted py-4">No appointments found</td></tr>
                            <?php else: ?>
                                <?php foreach ($appointments as $i => $row): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo date('d M Y', strtotime($row['appointment_date'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['appointment_time'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['client_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                                    <td><span class="badge-status badge-<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <?php if ($row['status'] === 'pending'): ?>
                                                <a href="?action=confirmed&id=<?php echo $row['id']; ?>" class="btn btn-outline-success" title="Confirm">✓</a>
                                            <?php endif; ?>
                                            <?php if (in_array($row['status'], ['pending','confirmed'])): ?>
                                                <a href="?action=completed&id=<?php echo $row['id']; ?>" class="btn btn-outline-primary" title="Complete">✔</a>
                                                <a href="?action=cancelled&id=<?php echo $row['id']; ?>" class="btn btn-outline-danger" title="Cancel" onclick="return confirm('Cancel this appointment?')">✕</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
