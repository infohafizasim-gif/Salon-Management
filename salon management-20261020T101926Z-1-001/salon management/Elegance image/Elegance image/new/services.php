<?php
$pageTitle = "Services";
$activePage = "services";
require_once 'config/database.php';
require_once 'includes/header.php';

$services = [];
$categories = [];

try {
    $services = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY category, name")->fetchAll();
    foreach ($services as $s) {
        $categories[$s['category']][] = $s;
    }
} catch (Exception $e) {
    // Fallback if DB not available
    $categories = [
        'Hair' => [
            ['name' => 'Precision Haircut', 'description' => 'Expert cut tailored to your face shape and style preference.', 'duration' => 45, 'price' => 65],
            ['name' => 'Hair Color & Highlights', 'description' => 'Full color, balayage, highlights and custom color work.', 'duration' => 90, 'price' => 120],
            ['name' => 'Blowout & Styling', 'description' => 'Professional blow-dry and styling for any occasion.', 'duration' => 40, 'price' => 55],
        ],
        'Skin' => [
            ['name' => 'Signature Facial', 'description' => 'Deep cleansing facial for radiant, healthy-looking skin.', 'duration' => 60, 'price' => 95],
            ['name' => 'Anti-Aging Treatment', 'description' => 'Advanced facial focused on firmness and glow.', 'duration' => 75, 'price' => 140],
            ['name' => 'Hydrating Skin Therapy', 'description' => 'Intensive moisture treatment for dry or dull skin.', 'duration' => 50, 'price' => 85],
        ],
        'Beauty' => [
            ['name' => 'Gel Manicure', 'description' => 'Long-lasting gel polish with perfect finish.', 'duration' => 45, 'price' => 45],
            ['name' => 'Luxury Pedicure', 'description' => 'Relaxing pedicure with premium products.', 'duration' => 55, 'price' => 55],
            ['name' => 'Bridal Makeup', 'description' => 'Full bridal look with premium cosmetics.', 'duration' => 90, 'price' => 180],
        ],
        'Wellness' => [
            ['name' => 'Relaxation Massage', 'description' => 'Full body massage to release tension and restore calm.', 'duration' => 60, 'price' => 110],
            ['name' => 'Hot Stone Therapy', 'description' => 'Warm stones and skilled technique for deep relaxation.', 'duration' => 75, 'price' => 135],
            ['name' => 'Scalp Treatment', 'description' => 'Nourishing scalp massage and treatment.', 'duration' => 30, 'price' => 50],
        ],
    ];
}

$catIcons = [
    'Hair' => 'fa-scissors',
    'Skin' => 'fa-spa',
    'Beauty' => 'fa-hand-sparkles',
    'Wellness' => 'fa-hot-tub-person',
    'Nails' => 'fa-hand-sparkles',
    'Makeup' => 'fa-paint-brush',
];
?>

<!-- ================= SERVICES HERO ================= -->
<section class="services-page-hero py-5">
    <div class="container py-lg-3 text-center">
        <span class="section-kicker">WHAT WE OFFER</span>
        <h1 class="display-heading mb-3">Our <em>Signature Services</em></h1>
        <div class="divider mx-auto"></div>
        <p class="section-text mx-auto" style="max-width: 560px;">
            Premium treatments crafted with precision, care, and the finest products — 
            designed to make you look and feel exceptional.
        </p>
    </div>
</section>

<!-- ================= SERVICES BY CATEGORY ================= -->
<section class="py-5 services-page-body">
    <div class="container">

        <?php if (empty($categories)): ?>
            <div class="text-center py-5">
                <i class="fas fa-spa fa-3x mb-3" style="color: var(--champagne);"></i>
                <h4 style="color: var(--cream);">No services available right now</h4>
                <p style="color: var(--muted);">Please check back soon or contact us.</p>
            </div>
        <?php else: ?>

            <?php foreach ($categories as $cat => $items): 
                $icon = $catIcons[$cat] ?? 'fa-star';
            ?>
            <div class="service-category-block mb-5">
                <div class="category-header">
                    <div class="category-icon"><i class="fas <?php echo $icon; ?>"></i></div>
                    <div>
                        <h2 class="category-title"><?php echo htmlspecialchars($cat); ?></h2>
                        <span class="category-count"><?php echo count($items); ?> services</span>
                    </div>
                </div>

                <div class="row g-4">
                    <?php foreach ($items as $service): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="vip-service-card">
                            <div class="vip-service-top">
                                <span class="vip-duration">
                                    <i class="far fa-clock"></i>
                                    <?php echo (int)$service['duration']; ?> min
                                </span>
                                <span class="vip-price">
                                    $<?php echo number_format((float)$service['price'], 0); ?>
                                </span>
                            </div>
                            <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                            <a href="book.php" class="vip-book-btn">
                                Book Now <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-5">
    <div class="container">
        <div class="services-cta">
            <span class="section-kicker">READY TO BOOK?</span>
            <h2>Your next moment of <em>self-care</em> awaits.</h2>
            <p>Choose a service and reserve your preferred time with our expert team.</p>
            <a href="book.php" class="btn btn-gold btn-lg mt-3">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </a>
        </div>
    </div>
</section>
<?php require_once 'includes/footer.php'; ?>