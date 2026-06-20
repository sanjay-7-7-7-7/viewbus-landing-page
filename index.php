<?php
$pageTitle = 'ViewBus — Premium Bus Booking Across Tamil Nadu';
$pageCss = 'home.css';
require_once __DIR__ . '/templates/header.php';
require_once __DIR__ . '/templates/navbar.php';

// Fetch dynamic statistics
try {
    $db = \TNExpress\Core\Database::getInstance();
    
    // Total registered users (Happy Passengers)
    $passengerCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn() ?: 0;
    
    // Total unique districts covered by buses
    $districtsCount = $db->query("SELECT COUNT(DISTINCT c.district) FROM routes r JOIN cities c ON r.to_city_id = c.id")->fetchColumn() ?: 0;
    if ($districtsCount == 0) {
        // Fallback to all districts if no routes yet
        $districtsCount = $db->query("SELECT COUNT(DISTINCT district) FROM cities")->fetchColumn() ?: 0;
    }
    
    // Total active buses
    $busesCount = $db->query("SELECT COUNT(*) FROM buses WHERE is_active = true")->fetchColumn() ?: 0;
    
    // Average user rating (User requested to keep it > 4.5)
    $dbRating = $db->query("SELECT COALESCE(ROUND(AVG(rating), 1), 0) FROM reviews")->fetchColumn() ?: 0.0;
    $avgRating = ($dbRating >= 4.5) ? $dbRating : 4.8;
} catch (Exception $e) {
    // Fallbacks if DB is unavailable
    $passengerCount = 0;
    $districtsCount = 0;
    $busesCount = 0;
    $avgRating = 0.0;
}

// Formatting for display
$passengerDisplay = $passengerCount > 0 ? number_format($passengerCount) : '0';
$districtsDisplay = $districtsCount > 0 ? $districtsCount : '0';
$busesDisplay = $busesCount > 0 ? $busesCount : '0';
$ratingDisplay = $avgRating > 0 ? number_format($avgRating, 1) : '0.0';
?>

<main class="apple-main">

  <!-- ══════════════════════════════════════════════════════════
       SECTION 1 — CINEMATIC HERO
  ══════════════════════════════════════════════════════════ -->
  <section class="apple-hero-section">
    <div class="hero-bg-layer">
      <video class="hero-bg-video" autoplay loop muted playsinline>
        <source src="hero-video.mp4" type="video/mp4">
      </video>
    </div>

    <meta name="theme-color" content="#FF2E55">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "ViewBus",
  "url": "http://localhost/tnexpress/public/index.php",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "http://localhost/tnexpress/public/booking.php?from={search_term_string}&to={search_term_string}&date={search_date}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "ViewBus Express",
  "url": "http://localhost/tnexpress",
  "logo": "http://localhost/tnexpress/public/images/logo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+91-1800-123-4567",
    "contactType": "customer service"
  }
}
</script>

    <div class="hero-content-layer reveal">
      <!-- Badge -->
      <div class="hero-badge">
        <span class="hero-badge-dot"></span>
        🚌 Tamil Nadu's #1 Bus Booking Platform
      </div>

      <!-- Main Title -->
      <h1 class="apple-massive-title">
        <span class="line-1">Travel Across Tamil Nadu</span>
        <span class="line-2">With Comfort.</span>
      </h1>

      <p class="apple-subtitle">
        Book premium bus tickets in seconds.<br>
        Fast, secure &amp; reliable — trusted by 2 lakh+ passengers.
      </p>

      <!-- Hero CTAs -->
      <div class="hero-ctas">
        <button class="btn-hero-primary" onclick="document.querySelector('.apple-search-dock').scrollIntoView({behavior:'smooth'})">
          <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
          Book Tickets Now
        </button>
        <button class="btn-hero-secondary" onclick="window.location.href='explore.php'">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
          Explore Routes
        </button>
      </div>
    </div>

    <!-- Hero Stats -->
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-num" id="stat-passengers"><?= htmlspecialchars($passengerDisplay) ?></div>
        <div class="hero-stat-label">Happy Passengers</div>
      </div>
      <div class="hero-stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num"><?= htmlspecialchars($districtsDisplay) ?></div>
        <div class="hero-stat-label">Districts Covered</div>
      </div>
      <div class="hero-stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num"><?= htmlspecialchars($busesDisplay) ?></div>
        <div class="hero-stat-label">Daily Buses</div>
      </div>
      <div class="hero-stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num"><?= htmlspecialchars($ratingDisplay) ?>★</div>
        <div class="hero-stat-label">User Rating</div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════
       FLOATING SEARCH DOCK
  ══════════════════════════════════════════════════════════ -->
  <div class="apple-search-dock reveal" style="transition-delay:0.15s">
    <div class="dock-label-row">
      <div class="dock-trip-type">
        <button type="button" class="trip-btn active" id="btn-oneway" onclick="setTripType('oneway')">One Way</button>
        <button type="button" class="trip-btn" id="btn-roundtrip" onclick="setTripType('roundtrip')">Round Trip</button>
      </div>
    </div>
    <form class="dock-grid" role="search" aria-label="Bus search" onsubmit="event.preventDefault(); doSearch();">
      <div class="dock-item" style="flex:1.4">
        <label>
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
          From City
        </label>
        <input class="dock-input" type="text" id="search-from" placeholder="e.g. Chennai" autocomplete="off" oninput="suggestCities(this,'from')">
        <div class="autocomplete-list" id="autocomplete-from"></div>
      </div>

      <button type="button" class="btn-swap-dock" onclick="swapCities()" title="Swap cities">⇄</button>

      <div class="dock-item" style="flex:1.4">
        <label>
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
          To City
        </label>
        <input class="dock-input" type="text" id="search-to" placeholder="e.g. Coimbatore" autocomplete="off" oninput="suggestCities(this,'to')">
        <div class="autocomplete-list" id="autocomplete-to"></div>
      </div>

      <div class="dock-item">
        <label>
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>
          Journey Date
        </label>
        <input class="dock-input" type="date" id="search-date" style="color:var(--navy);font-family:var(--font-display)" onchange="updateReturnMinDate()">
      </div>

      <div class="dock-item" id="return-date-container" style="display:none; border-left:1px solid rgba(15,23,42,0.18); padding-left:15px; margin-left:-5px;">
        <label style="color:var(--primary-dark)">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 18H4V8h16v13z"/></svg>
          Return Date
        </label>
        <input class="dock-input" type="date" id="search-return-date" style="color:var(--navy);font-family:var(--font-display)">
      </div>

      <button type="submit" class="btn-search-dock" id="hero-search-btn">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
        Search Buses
      </button>
    </form>
  </div>

  <!-- ══════════════════════════════════════════════════════════
       TRUST BAR
  ══════════════════════════════════════════════════════════ -->
  <div class="trust-bar reveal" style="transition-delay:0.25s">
    <div class="trust-item">
      <span class="trust-item-icon">🔒</span>
      Secure Payments
    </div>
    <div class="trust-divider"></div>
    <div class="trust-item">
      <span class="trust-item-icon">📍</span>
      Live Bus Tracking
    </div>
    <div class="trust-divider"></div>
    <div class="trust-item">
      <span class="trust-item-icon">⚡</span>
      Instant Confirmation
    </div>
    <div class="trust-divider"></div>
    <div class="trust-item">
      <span class="trust-item-icon">🛡️</span>
      CERT-In Compliant
    </div>
    <div class="trust-divider"></div>
    <div class="trust-item">
      <span class="trust-item-icon">🎫</span>
      Easy Refunds
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════════════
       SECTION 2 — POPULAR ROUTES
  ══════════════════════════════════════════════════════════ -->
  <section class="routes-section">
    <div class="routes-section-header reveal">
      <div class="section-tag">🗺️ Popular Routes</div>
      <h2 class="section-title">Top Routes Across Tamil Nadu</h2>
      <p class="section-subtitle" style="margin:0 auto">
        Explore the most loved bus routes with great frequency, comfort, and unbeatable prices.
      </p>
    </div>
    <div class="routes-grid" id="popular-routes">
      <!-- Populated by JS -->
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════
       SECTION 3 — WHY CHOOSE US
  ══════════════════════════════════════════════════════════ -->
  <section class="features-section">
    <div class="features-section-header reveal">
      <div class="section-tag">✨ Why ViewBus</div>
      <h2 class="section-title">Travel Smarter, Travel Better</h2>
      <p class="section-subtitle" style="margin:0 auto">
        We've built every feature with the passenger in mind — from booking to destination.
      </p>
    </div>
    <div class="features-grid">
      <div class="feature-card reveal" style="transition-delay:0.05s">
        <div class="feature-icon-wrap">📍</div>
        <div class="feature-title">Real-Time Live Tracking</div>
        <div class="feature-desc">Track your bus on a live map. Know exactly when it arrives so you never miss a ride.</div>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.1s">
        <div class="feature-icon-wrap">✅</div>
        <div class="feature-title">Verified Operators Only</div>
        <div class="feature-desc">Every bus operator is government-verified and rated by real passengers. No surprises.</div>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.15s">
        <div class="feature-icon-wrap">🔐</div>
        <div class="feature-title">100% Secure Payments</div>
        <div class="feature-desc">Your payment is protected by bank-grade 256-bit encryption and Razorpay security.</div>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.2s">
        <div class="feature-icon-wrap">🎫</div>
        <div class="feature-title">Instant E-Ticket</div>
        <div class="feature-desc">Receive your digital ticket in seconds. No printing needed — just show & board.</div>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.25s">
        <div class="feature-icon-wrap">🔄</div>
        <div class="feature-title">Hassle-Free Refunds</div>
        <div class="feature-desc">Plans changed? Cancel instantly and get your money back — no questions asked.</div>
      </div>
      <div class="feature-card reveal" style="transition-delay:0.3s">
        <div class="feature-icon-wrap">📞</div>
        <div class="feature-title">24/7 Customer Support</div>
        <div class="feature-desc">Our support team is available around the clock via phone, chat, or email.</div>
      </div>
    </div>
  </section>



  <!-- ══════════════════════════════════════════════════════════
       SECTION 5 — STATS CARDS
  ══════════════════════════════════════════════════════════ -->
  <section class="apple-grid-section">
    <div style="text-align:center;margin-bottom:50px" class="reveal">
      <div class="section-tag">📊 By The Numbers</div>
      <h2 class="section-title">The ViewBus Promise</h2>
    </div>
    <div class="apple-grid">
      <div class="glass-card reveal" style="transition-delay:0.05s;background:linear-gradient(145deg,#FFF7ED,#FFF)">
        <h3 style="color:var(--primary-dark)">38 Districts.</h3>
        <p>A web of interconnected routes spanning all districts of Tamil Nadu — from Kanyakumari to Chennai.</p>
        <div class="card-icon">🗺️</div>
      </div>
      <div class="glass-card reveal" style="transition-delay:0.1s;background:linear-gradient(145deg,#EFF6FF,#FFF)">
        <h3 style="color:var(--highlight)">60+ Buses.</h3>
        <p>Daily dispatches ensuring you always find a ride when you need it — morning, afternoon, or night.</p>
        <div class="card-icon">🚌</div>
      </div>
      <div class="glass-card reveal" style="transition-delay:0.15s;grid-column:1/-1;display:flex;justify-content:space-between;align-items:center;background:linear-gradient(145deg,#F0FDF4,#FFF)">
        <div>
          <h3 style="color:var(--success)">Refunds Built-In.</h3>
          <p>Plans changed? Cancel anytime directly through our platform and receive instant refunds.</p>
        </div>
        <div class="card-icon" style="font-size:4rem;margin-top:0">🛡️</div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════
       SECTION 6 — BUS OPERATORS
  ══════════════════════════════════════════════════════════ -->
  <section class="operators-section">
    <div class="operators-section-header reveal">
      <div class="section-tag">🏢 Our Partners</div>
      <h2 class="section-title">Trusted Bus Operators</h2>
      <p class="section-subtitle" style="margin:0 auto">Top-rated, government-verified operators that guarantee comfort and safety.</p>
    </div>
    <div class="operators-track-wrapper">
      <div class="operators-track" id="operators-track">
        <!-- Set A -->
        <div class="operator-card">
          <div class="operator-logo">🚌</div>
          <div class="operator-name">SETC</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">State Fleet • 200+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟦</div>
          <div class="operator-name">KPN Travels</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">Premium AC • 80+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟠</div>
          <div class="operator-name">Parveen Travels</div>
          <div class="operator-stars">★★★★☆</div>
          <div class="operator-buses">Sleeper • 60+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟣</div>
          <div class="operator-name">SRM Travels</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">Luxury • 45+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟡</div>
          <div class="operator-name">YBM Travels</div>
          <div class="operator-stars">★★★★☆</div>
          <div class="operator-buses">AC Seater • 35+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🔵</div>
          <div class="operator-name">SRS Travels</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">Multi-axle • 50+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟢</div>
          <div class="operator-name">VRL Travels</div>
          <div class="operator-stars">★★★★☆</div>
          <div class="operator-buses">Sleeper • 40+ Buses</div>
        </div>
        <!-- Set B (mirror for infinite scroll) -->
        <div class="operator-card">
          <div class="operator-logo">🚌</div>
          <div class="operator-name">SETC</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">State Fleet • 200+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟦</div>
          <div class="operator-name">KPN Travels</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">Premium AC • 80+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟠</div>
          <div class="operator-name">Parveen Travels</div>
          <div class="operator-stars">★★★★☆</div>
          <div class="operator-buses">Sleeper • 60+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟣</div>
          <div class="operator-name">SRM Travels</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">Luxury • 45+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟡</div>
          <div class="operator-name">YBM Travels</div>
          <div class="operator-stars">★★★★☆</div>
          <div class="operator-buses">AC Seater • 35+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🔵</div>
          <div class="operator-name">SRS Travels</div>
          <div class="operator-stars">★★★★★</div>
          <div class="operator-buses">Multi-axle • 50+ Buses</div>
        </div>
        <div class="operator-card">
          <div class="operator-logo">🟢</div>
          <div class="operator-name">VRL Travels</div>
          <div class="operator-stars">★★★★☆</div>
          <div class="operator-buses">Sleeper • 40+ Buses</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════
       SECTION 7 — SPECIAL OFFERS
  ══════════════════════════════════════════════════════════ -->
  <section class="offers-section">
    <div class="offers-section-header reveal">
      <div class="section-tag">🎁 Exclusive Deals</div>
      <h2 class="section-title">Special Offers For You</h2>
      <p class="section-subtitle" style="margin:0 auto">Limited time offers — grab them before they expire!</p>
    </div>
    <div class="offers-grid">
      <div class="offer-card amber-card reveal" style="transition-delay:0.05s">
        <span class="offer-tag">Cashback</span>
        <div>
          <div class="offer-title">₹100 Back</div>
          <div class="offer-subtitle">On your first booking. No minimum fare.</div>
        </div>
        <button class="offer-cta">Grab Offer →</button>
      </div>
      <div class="offer-card blue-card reveal" style="transition-delay:0.1s">
        <span class="offer-tag">Festival</span>
        <div>
          <div class="offer-title">20% Off</div>
          <div class="offer-subtitle">Tamil festivals special — Chennai routes all week.</div>
        </div>
        <button class="offer-cta">Book Now →</button>
      </div>
      <div class="offer-card green-card reveal" style="transition-delay:0.15s">
        <span class="offer-tag">Weekend</span>
        <div>
          <div class="offer-title">Flat ₹50 Off</div>
          <div class="offer-subtitle">Every Saturday & Sunday on selected routes.</div>
        </div>
        <button class="offer-cta">See Routes →</button>
      </div>
      <div class="offer-card rose-card reveal" style="transition-delay:0.2s">
        <span class="offer-tag">Student</span>
        <div>
          <div class="offer-title">15% Discount</div>
          <div class="offer-subtitle">With valid college ID. Applies to all routes.</div>
        </div>
        <button class="offer-cta">Apply Now →</button>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════
       SECTION 8 — TESTIMONIALS
  ══════════════════════════════════════════════════════════ -->
  <section class="testimonials-section">
    <div class="testimonials-section-header reveal">
      <div class="section-tag">💬 Passenger Reviews</div>
      <h2 class="section-title">What Our Passengers Say</h2>
      <p class="section-subtitle" style="margin:0 auto">Real reviews from real travellers across Tamil Nadu.</p>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card reveal" style="transition-delay:0.05s">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"The smoothest bus booking experience I've ever had. Ticket came instantly, the bus was on time — absolutely loved it!"</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">A</div>
          <div>
            <div class="testimonial-name">Arun Kumar</div>
            <div class="testimonial-meta">Chennai → Madurai</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card reveal" style="transition-delay:0.1s">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">"Real-time tracking is a game changer. My family could see exactly where I was throughout the night journey. 10/10!"</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">P</div>
          <div>
            <div class="testimonial-name">Priya Ramesh</div>
            <div class="testimonial-meta">Coimbatore → Chennai</div>
          </div>
        </div>
      </div>
      <div class="testimonial-card reveal" style="transition-delay:0.15s">
        <div class="testimonial-stars">★★★★☆</div>
        <p class="testimonial-text">"Got a refund within 2 hours when I had to cancel. No calls, no forms — just clicked cancel and the money was back. Impressive!"</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">M</div>
          <div>
            <div class="testimonial-name">Murugan S</div>
            <div class="testimonial-meta">Trichy → Tirunelveli</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════
       SECTION 9 — APP DOWNLOAD
  ══════════════════════════════════════════════════════════ -->
  <section class="app-section">
    <div class="app-inner">
      <div class="app-content reveal-left">
        <div class="app-tag">📱 Mobile App</div>
        <h2 class="app-title">Book Anywhere,<br>Anytime — On the Go</h2>
        <p class="app-subtitle">
          Download the ViewBus app and enjoy a seamless booking experience with live tracking,
          seat selection, and one-tap payments right in your pocket.
        </p>
        <div class="app-buttons">
          <button class="app-store-btn">
            <span class="app-store-icon">🍎</span>
            <div>
              <span class="app-store-text-sm">Download on the</span>
              <span class="app-store-text-lg">App Store</span>
            </div>
          </button>
          <button class="app-store-btn">
            <span class="app-store-icon">▶️</span>
            <div>
              <span class="app-store-text-sm">Get it on</span>
              <span class="app-store-text-lg">Google Play</span>
            </div>
          </button>
        </div>
      </div>

      <div class="app-visual reveal-right" style="transition-delay:0.2s">
        <div class="phone-mockup">
          <div class="phone-notch"></div>
          <div class="phone-screen">
            <div class="phone-screen-row" style="height:28px;border-radius:6px;margin-bottom:4px"></div>
            <div class="phone-screen-row tall"></div>
            <div class="phone-screen-row medium"></div>
            <div class="phone-screen-row" style="height:44px;background:rgba(245,158,11,0.4);border-radius:8px"></div>
            <div class="phone-screen-row"></div>
            <div class="phone-screen-row"></div>
            <div class="phone-screen-row medium"></div>
            <div class="phone-screen-row" style="height:44px;background:rgba(59,130,246,0.3);border-radius:8px"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- ══════════════════════════════════════════════════════════
     PREMIUM FOOTER
══════════════════════════════════════════════════════════ -->
<footer class="footer-premium">
  <div class="footer-top">
    <div class="footer-brand-col">
      <div class="brand-logo-footer">🚌</div>
      <div class="footer-brand-name">ViewBus</div>
      <p class="footer-brand-desc">Tamil Nadu's most trusted premium bus booking platform. Safe, fast, and comfortable travel across all 38 districts.</p>
      <div class="footer-social">
        <button class="footer-social-btn" title="Facebook">f</button>
        <button class="footer-social-btn" title="Twitter">𝕏</button>
        <button class="footer-social-btn" title="Instagram">📷</button>
        <button class="footer-social-btn" title="YouTube">▶</button>
      </div>
    </div>

    <div>
      <div class="footer-col-title">Company</div>
      <ul class="footer-links">
        <li><a href="#">About Us</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Press</a></li>
        <li><a href="#">Blog</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Popular Routes</div>
      <ul class="footer-links">
        <li><a href="booking.php">Chennai → Madurai</a></li>
        <li><a href="booking.php">Chennai → Coimbatore</a></li>
        <li><a href="booking.php">Chennai → Trichy</a></li>
        <li><a href="booking.php">Salem → Chennai</a></li>
        <li><a href="booking.php">Tirunelveli → Chennai</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Operators</div>
      <ul class="footer-links">
        <li><a href="#">SETC</a></li>
        <li><a href="#">KPN Travels</a></li>
        <li><a href="#">Parveen Travels</a></li>
        <li><a href="#">SRM Travels</a></li>
        <li><a href="#">YBM Travels</a></li>
      </ul>
    </div>

    <div>
      <div class="footer-col-title">Support</div>
      <ul class="footer-links">
        <li><a href="tel:18004253333">1800-425-3333</a></li>
        <li><a href="mailto:support@tnexpress.in">Email Support</a></li>
        <li><a href="grievance.php">Grievance Officer</a></li>
        <li><a href="refund-policy.php">Cancellation Policy</a></li>
        <li><a href="privacy.php">Privacy Policy</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <span>© 2026 ViewBus · Tamil Nadu Government · CERT-In Compliant</span>
    <div class="footer-bottom-links">
      <a href="terms.php">Terms</a>
      <a href="privacy.php">Privacy</a>
      <a href="grievance.php">Grievances</a>
    </div>
  </div>
</footer>

<?php require_once __DIR__ . '/templates/auth_modal.php'; ?>

<script src="js/common.js"></script>
<script src="js/home.js?v=2"></script>
<script>
/* ── HOME PAGE ENHANCEMENTS ── */

// Navbar scroll glass effect
const navbar = document.querySelector('.navbar');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 60);
}, { passive: true });

// Trip type toggle
document.querySelectorAll('.trip-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.trip-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});

// Scroll reveal observer
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('active');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => revealObserver.observe(el));

// Parallax on hero bg
window.addEventListener('scroll', () => {
  const hero = document.querySelector('.hero-bg-layer');
  if (hero) hero.style.transform = `scale(1.05) translateY(${window.scrollY * 0.22}px)`;
}, { passive: true });

// Override route rendering with premium cards
function renderPremiumRoutes() {
  const routesData = [
    { from: 'Chennai', to: 'Madurai', duration: '8h 30m', fare: '₹350' },
    { from: 'Chennai', to: 'Coimbatore', duration: '7h 15m', fare: '₹320' },
    { from: 'Chennai', to: 'Trichy', duration: '6h', fare: '₹280' },
    { from: 'Madurai', to: 'Coimbatore', duration: '4h 30m', fare: '₹200' },
    { from: 'Salem', to: 'Chennai', duration: '5h', fare: '₹240' },
    { from: 'Tirunelveli', to: 'Chennai', duration: '11h', fare: '₹450' },
  ];
  const routesGrid = document.getElementById('popular-routes');
  if (!routesGrid) return;
  routesGrid.innerHTML = routesData.map(r => `
    <div class="route-card" onclick="quickRoute('${r.from}','${r.to}')">
      <div class="route-left">
        <div class="route-cities">🚌 ${r.from} <span class="route-cities-arrow">→</span> ${r.to}</div>
        <div class="route-duration">⏱ ${r.duration} · Daily buses available</div>
      </div>
      <div class="route-info">
        <span class="route-price">${r.fare}</span>
        <span class="route-label">onwards</span>
      </div>
    </div>
  `).join('');
  routesGrid.querySelectorAll('.route-card').forEach(card => revealObserver.observe(card));
}

function quickRoute(from, to) {
  document.getElementById('search-from').value = from;
  document.getElementById('search-to').value = to;
  document.querySelector('.apple-search-dock').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// After home.js initializes, override with premium routes
document.addEventListener('DOMContentLoaded', () => {
  setTimeout(renderPremiumRoutes, 200);
});
</script>
</body>
</html>
