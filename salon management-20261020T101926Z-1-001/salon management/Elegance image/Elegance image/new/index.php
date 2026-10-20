<?php
$pageTitle = "Home";
$activePage = "home";
require_once 'includes/header.php';

/*
 * Home page image setup:
 * All image URLs are intentionally kept in this file so the page works
 * without a database. External images use Unsplash with no referrer policy.
 */
?>

<!-- ================= HERO ================= -->
<section class="home-hero">
    <div class="home-hero-overlay"></div>
    <div class="container position-relative">
        <div class="row min-vh-75 align-items-center">
            <div class="col-lg-7">
                <div class="hero-copy">
                    <span class="hero-eyebrow">WELCOME TO ELEGANCE SALON</span>
                    <h1>Beauty, <span>Refined.</span><br>Confidence, Elevated.</h1>
                    <p class="hero-description">
                        Discover a premium salon experience where expert styling,
                        personalized care and timeless elegance come together.
                    </p>
                    <div class="hero-actions">
                        <a href="book.php" class="btn btn-gold btn-lg">
                            <i class="fas fa-calendar-check"></i> Book Appointment
                        </a>
                        <a href="services.php" class="btn btn-hero-outline btn-lg">
                            Explore Services <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="hero-trust">
                        <div><i class="fas fa-star"></i> Premium Service</div>
                        <div><i class="fas fa-user-check"></i> Expert Stylists</div>
                        <div><i class="fas fa-heart"></i> Personalized Care</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll" id="scrollDown">
        <span>Scroll to explore</span>
        <i class="fas fa-arrow-down"></i>
    </div>
</section>

<!-- ================= INTRO ================= -->
<section class="intro-section py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-kicker">THE ELEGANCE EXPERIENCE</span>
                <h2 class="display-heading">Where beauty meets <em>personal care.</em></h2>
                <div class="gold-line"></div>
                <p class="section-text">
                    At Elegance Salon, every appointment is designed around you.
                    From precision hair styling to restorative skin and wellness
                    treatments, our team combines professional expertise with a calm,
                    luxurious environment.
                </p>
                <div class="intro-stats-row">
                    <div><strong>12+</strong><span>Years</span></div>
                    <div><strong>8k+</strong><span>Clients</span></div>
                    <div><strong>25+</strong><span>Experts</span></div>
                </div>
                <a href="about.php" class="text-link">Discover Our Story <i class="fas fa-arrow-right"></i></a>
            </div>
<div class="col-lg-6">
    <div class="intro-visual">
        <div class="intro-img-main">
            <img src="assets/img/hero.jpeg" alt="Luxury salon interior">
        </div>
        <div class="intro-img-float">
            <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?w=500&q=80" alt="Salon styling">
        </div>
        <div class="intro-badge">
            <i class="fas fa-award"></i>
            <div>
                <strong>Premium Rated</strong>
                <span>Client Favorite 2025</span>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</section>

<!-- ================= SERVICES ================= -->
<section class="services-home py-5">
    <div class="container py-lg-4">
        <div class="services-header">
            <div class="services-header-left">
                <span class="section-kicker">WHAT WE OFFER</span>
                <h2>Signature <em>Services</em></h2>
                <div class="divider divider-left"></div>
            </div>
            <div class="services-header-right">
                <p>Curated treatments crafted with precision, premium products, and a calm, luxurious touch — made to feel exceptional from the moment you arrive.</p>
                <a href="services.php" class="btn btn-outline-gold btn-sm d-none d-md-inline-flex">
                    View Full Menu <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="signature-grid">
            <?php
            $services = [
                [
                    'img' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?w=800&q=80',
                    'number' => '01',
                    'category' => 'Hair',
                    'title' => 'Hair Styling & Color',
                    'desc' => 'Precision cuts, modern styling, highlights, balayage and fully customized color work.',
                    'price' => 'From $85',
                    'duration' => '45–90 min',
                    'featured' => true
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=700&q=80',
                    'number' => '02',
                    'category' => 'Skin',
                    'title' => 'Facial & Skin Therapy',
                    'desc' => 'Rejuvenating facials designed for clear, healthy and radiant-looking skin.',
                    'price' => 'From $120',
                    'duration' => '60 min',
                    'featured' => false
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=700&q=80',
                    'number' => '03',
                    'category' => 'Beauty',
                    'title' => 'Nails & Beauty',
                    'desc' => 'Manicures, pedicures, gel finishes and refined nail art with lasting polish.',
                    'price' => 'From $70',
                    'duration' => '40–55 min',
                    'featured' => false
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=700&q=80',
                    'number' => '04',
                    'category' => 'Wellness',
                    'title' => 'Massage & Wellness',
                    'desc' => 'Restorative body treatments created to release tension and restore balance.',
                    'price' => 'From $130',
                    'duration' => '60–90 min',
                    'featured' => false
                ],
            ];
            foreach ($services as $service):
                $featuredClass = !empty($service['featured']) ? ' is-featured' : '';
            ?>
            <article class="sig-card<?php echo $featuredClass; ?>">
                <div class="sig-card-media">
                    <img src="<?php echo htmlspecialchars($service['img']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" loading="eager" decoding="async" referrerpolicy="no-referrer">
                    <div class="sig-card-media-overlay"></div>
                    <span class="sig-category"><?php echo $service['category']; ?></span>
                    <span class="sig-number"><?php echo $service['number']; ?></span>
                </div>
                <div class="sig-card-body">
                    <h3><?php echo $service['title']; ?></h3>
                    <p><?php echo $service['desc']; ?></p>
                    <div class="sig-meta">
                        <span><i class="far fa-clock"></i> <?php echo $service['duration']; ?></span>
                    </div>
                    <div class="sig-card-bottom">
                        <strong><?php echo $service['price']; ?></strong>
                        <a href="book.php" class="sig-book-btn" aria-label="Book <?php echo htmlspecialchars($service['title']); ?>">
                            Book <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="services.php" class="btn btn-outline-gold">View Full Menu <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
    </div>
</section>

<!-- ================= STATS ================= -->
<section class="stats-section">
    <div class="container">
        <div class="row g-0">
            <div class="col-6 col-md-3"><div class="stat-item"><strong>12+</strong><span>Years of Excellence</span></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><strong>8,500+</strong><span>Happy Clients</span></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><strong>25+</strong><span>Expert Stylists</span></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><strong>40+</strong><span>Premium Services</span></div></div>
        </div>
    </div>
</section>

<!-- ================= STYLISTS ================= -->
<!-- ================= STYLISTS ================= -->
<section class="stylists-section py-5">
    <div class="container py-lg-4">
        <div class="section-title">
            <span class="section-kicker">OUR TEAM</span>
            <h2>Featured <em>Stylists</em></h2>
            <div class="divider"></div>
            <p>Meet the experts who bring elegance to every appointment.</p>
        </div>

        <div class="row g-4">
            <?php
          $stylists = [
    [
        'name' => 'Sophia Laurent',
        'role' => 'Master Stylist',
        'specialty' => 'Hair Color & Balayage',
        'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'name' => 'Isabella Grace',
        'role' => 'Senior Stylist',
        'specialty' => 'Bridal & Special Events',
        'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'name' => 'Emma Rose',
        'role' => 'Skin Specialist',
        'specialty' => 'Facials & Skincare',
        'img' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'name' => 'Liam Brooks',
        'role' => 'Barber & Stylist',
        'specialty' => "Men's Grooming",
        'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80'
    ]
];
            foreach ($stylists as $stylist):
            ?>
            <div class="col-md-6 col-lg-3">
                <div class="stylist-card vip-stylist">
                    <div class="stylist-photo">
                        <img src="<?php echo $stylist['img']; ?>"
                             alt="<?php echo htmlspecialchars($stylist['name']); ?>"
                             loading="lazy"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($stylist['name']); ?>&background=6D1F2B&color=D6B98C&size=300'">
                        <div class="stylist-photo-overlay"></div>
                        <a href="book.php" class="stylist-book-float">Book</a>
                    </div>
                    <div class="stylist-info">
                        <h4><?php echo $stylist['name']; ?></h4>
                        <span class="stylist-role"><?php echo $stylist['role']; ?></span>
                        <p><?php echo $stylist['specialty']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- ================= WHY US ================= -->
<section class="why-section py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="section-kicker">WHY ELEGANCE</span>
                <h2 class="display-heading">Care that goes beyond <em>the ordinary.</em></h2>
                <div class="gold-line"></div>
                <p class="section-text">We focus on the details that turn a regular salon visit into a complete beauty experience.</p>
                <a href="contact.php" class="btn btn-gold">Visit Elegance <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-user-tie"></i></div>
                            <h4>Expert Stylists</h4>
                            <p>Skilled professionals focused on your individual look and needs.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-gem"></i></div>
                            <h4>Premium Products</h4>
                            <p>Only trusted, high-quality brands for hair, skin and beauty.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-leaf"></i></div>
                            <h4>Calm Atmosphere</h4>
                            <p>A serene space designed for comfort, privacy and relaxation.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="benefit-card">
                            <div class="benefit-icon"><i class="fas fa-heart"></i></div>
                            <h4>Personalized Care</h4>
                            <p>Every service is tailored to your preferences and expectations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="gallery-section py-5">
    <div class="container py-lg-4">
        <div class="section-title">
            <span class="section-kicker">MOMENTS OF ELEGANCE</span>
            <h2>Salon <em>Gallery</em></h2>
            <div class="divider"></div>
        </div>
<div class="vip-gallery">
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?w=800&q=80" alt="Hair Artistry" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Hair Artistry</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?w=700&q=80" alt="Interior" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Interior</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=700&q=80" alt="Makeup" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Makeup</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=800&q=80" alt="Wellness Ritual" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Wellness Ritual</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?w=700&q=80" alt="Details" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Details</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1604654894610-df63bc536371?w=700&q=80" alt="Nails" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Nail Art</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=700&q=80" alt="Facial Care" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Facial Care</span></div>
    </div>
    <div class="gallery-item">
        <img src="https://images.unsplash.com/photo-1633681926022-b411b6bfd763?w=700&q=80" alt="Luxury Salon" loading="eager" referrerpolicy="no-referrer">
        <div class="gallery-caption"><span>Luxury Salon</span></div>
    </div>
</div>
    </div>
</section>

<!-- ================= TESTIMONIALS ================= -->
<section class="testimonials-section py-5">
    <div class="container py-lg-4">
        <div class="section-title">
            <span class="section-kicker">CLIENT LOVE</span>
            <h2>What Our Clients <em>Say</em></h2>
            <div class="divider"></div>
        </div>

        <div class="row g-4">
            <?php
            $testimonials = [
                ['name' => 'Olivia M.', 'text' => 'Elegance Salon is my sanctuary. Every visit feels luxurious, personalized and truly relaxing.', 'role' => 'Regular Client', 'img' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&q=80'],
                ['name' => 'Ayesha K.', 'text' => 'The stylists here truly understand what you want. My hair has never looked better.', 'role' => 'Verified Client', 'img' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=200&q=80'],
                ['name' => 'Sara R.', 'text' => 'Beautiful atmosphere, professional staff and exceptional service. Highly recommended!', 'role' => 'Bridal Client', 'img' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=200&q=80']
            ];
            foreach ($testimonials as $t):
            ?>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p>“<?php echo $t['text']; ?>”</p>
                    <div class="testimonial-author-row">
                        <img src="<?php echo htmlspecialchars($t['img']); ?>" alt="<?php echo htmlspecialchars($t['name']); ?>" class="testimonial-avatar" loading="eager" decoding="async" referrerpolicy="no-referrer">
                        <div>
                            <strong><?php echo $t['name']; ?></strong>
                            <span><?php echo $t['role']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<section class="home-cta py-5">
    <div class="container py-lg-4">
        <div class="cta-box cta-vip">
            <span class="section-kicker">YOUR NEXT MOMENT OF SELF-CARE</span>
            <h2>Ready for your<br><em>Elegance experience?</em></h2>
            <p>Reserve your appointment and let our team take care of the rest.</p>
            <a href="book.php" class="btn btn-gold btn-lg"><i class="fas fa-calendar-check"></i> Book Your Appointment</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>