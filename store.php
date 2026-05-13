<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elite Roleplay Store - Browse our catalog of premium business opportunities.">
    <title>Elite Roleplay - Store</title>
    
    <meta name="theme-color" content="#88DA22">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="assets/logo.jpg">

    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.onkeydown = function(e) {
            if (e.keyCode == 123) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false;
        };
    </script>
    
    <style>
        .store-section {
            padding: 50px 0;
            min-height: 80vh;
        }
        
        .store-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .store-nav-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            font-family: var(--font-heading);
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .store-nav-btn.active {
            background: var(--accent-green);
            color: #000;
            border-color: var(--accent-green);
            box-shadow: 0 0 15px rgba(136, 218, 34, 0.3);
        }
        
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            display: none;
        }
        
        .catalog-grid.active {
            display: grid;
            animation: fadeInUp 0.5s ease forwards;
        }
        
        .product-card {
            background: rgba(13, 13, 13, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-green);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        
        .product-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-green);
            color: #000;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 700;
            font-family: var(--font-heading);
        }
        
        .product-info {
            padding: 25px;
        }
        
        .product-category {
            color: var(--accent-green);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
            display: block;
        }
        
        .product-title {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            color: #fff;
            margin-bottom: 12px;
        }
        
        .product-features {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
        }
        
        .product-features li {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }
        
        .product-features li i {
            color: var(--accent-green);
            margin-right: 10px;
            font-size: 0.8rem;
        }
        
        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .price-tag {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            color: #fff;
        }
        
        .btn-view {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px 20px;
            border-radius: 5px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .btn-view:hover {
            background: var(--accent-green);
            color: #000;
        }

        .store-header {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
            padding: 60px 20px;
            border-radius: 30px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.02) 0%, rgba(255, 255, 255, 0) 100%);
            border: 1px solid rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(5px);
            overflow: hidden;
        }
        
        .header-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(136, 218, 34, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            z-index: -1;
            pointer-events: none;
        }

        .store-title {
            font-family: var(--font-heading);
            font-size: 4rem;
            letter-spacing: 8px;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: #fff;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }

        .store-title span {
            color: var(--accent-green);
            text-shadow: 0 0 30px rgba(136, 218, 34, 0.3);
        }

        .title-accent {
            width: 80px;
            height: 4px;
            background: var(--accent-green);
            margin: 0 auto 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px var(--accent-green);
            position: relative;
            overflow: hidden;
        }

        .title-accent::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            animation: accent-shimmer 3s infinite;
        }

        @keyframes accent-shimmer {
            100% { left: 100%; }
        }

        @media (max-width: 768px) {
            .store-title {
                font-size: 2.5rem;
                letter-spacing: 4px;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal-container {
            width: 94%;
            max-width: 1200px;
            background: #0d0d0d;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-overlay.active .modal-container {
            transform: scale(1);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 10;
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: 0.3s;
        }

        .modal-close:hover {
            background: var(--accent-green);
            color: #000;
        }

        .modal-content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .modal-content-grid {
                grid-template-columns: 1fr;
            }
        }

        .modal-image-viewer {
            position: relative;
            height: 100%;
            min-height: 400px;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-modal-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .dot {
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
        }

        .dot.active {
            background: var(--accent-green);
            width: 30px;
            border-radius: 10px;
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            z-index: 15;
            transition: 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            user-select: none;
        }

        .nav-arrow:hover {
            background: var(--accent-green);
            color: #000;
            border-color: var(--accent-green);
        }

        .arrow-left { left: 20px; }
        .arrow-right { right: 20px; }

        .modal-details {
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .modal-tag {
            color: var(--accent-green);
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .modal-title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 20px;
        }

        .modal-desc {
            color: #888;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .modal-features-list {
            margin-bottom: 40px;
        }

        .modal-feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            color: #fff;
        }

        .modal-feature-item i {
            color: var(--accent-green);
        }

        .modal-footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modal-price {
            font-family: var(--font-heading);
            font-size: 2rem;
            color: var(--accent-green);
        }

        .btn-modal-action {
            background: var(--accent-green);
            color: #000;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-family: var(--font-heading);
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .btn-modal-action:hover {
            box-shadow: 0 0 20px rgba(136, 218, 34, 0.4);
            transform: translateY(-3px);
        }
    </style>
</head>

<body>

    <div class="ambient-glow"></div>
    <div class="bg-pattern"></div>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="index.php">
                    <img src="assets/logo.png" alt="EliteRP Logo" class="nav-logo" width="40" height="40" style="max-height: 40px; width: auto;">
                </a>
            </div>

            <ul class="nav-links">
                <li><a href="index.php">HOME</a></li>
                <li><a href="index.php#about">ABOUT US</a></li>
                <li><a href="index.php#gallery">FEATURES</a></li>
                <li><a href="store.php" class="active">STORE</a></li>
                <li><a href="application.php">APPLICATION</a></li>
                <li><a href="rules.php">RULES</a></li>
                <li><a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank">DISCORD</a></li>
            </ul>

            <div class="nav-action">
                <div class="user-auth" id="userAuthDisplay">
                    <button class="btn-login" onclick="window.location.href='index.php?login=true'">
                        <i class="fas fa-sign-in-alt"></i> LOGIN
                    </button>
                </div>
            </div>

            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <div style="padding-top: 120px;"></div>

    <section class="section store-section">
        <div class="container">
            <div class="store-header fade-in">
                <div class="header-bg"></div>
                <h2 class="store-title">ELITE <span>STORE</span></h2>
                <div class="title-accent"></div>
                <p class="section-subtitle" style="font-size: 1.1rem; color: #aaa; max-width: 600px; margin: 0 auto; line-height: 1.6;">Premium assets and opportunities to elevate your experience in Los Santos. Browse our exclusive collections below.</p>
            </div>

            <div class="acquisition-steps fade-in" style="display: flex; justify-content: center; gap: 40px; margin-bottom: 60px; flex-wrap: wrap;">
                <div class="step-item" style="text-align: center; max-width: 200px;">
                    <div style="background: rgba(136, 218, 34, 0.1); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; border: 1px solid rgba(136, 218, 34, 0.3);">
                        <i class="fas fa-search" style="color: #88DA22; font-size: 1.2rem;"></i>
                    </div>
                    <h4 style="color: #fff; margin-bottom: 8px; font-family: var(--font-heading);">1. BROWSE</h4>
                    <p style="color: #666; font-size: 0.85rem;">Review the catalog details.</p>
                </div>
                <div class="step-item" style="text-align: center; max-width: 200px;">
                    <div style="background: rgba(136, 218, 34, 0.1); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; border: 1px solid rgba(136, 218, 34, 0.3);">
                        <i class="fab fa-discord" style="color: #88DA22; font-size: 1.2rem;"></i>
                    </div>
                    <h4 style="color: #fff; margin-bottom: 8px; font-family: var(--font-heading);">2. JOIN DISCORD</h4>
                    <p style="color: #666; font-size: 0.85rem;">Join our community server.</p>
                </div>
                <div class="step-item" style="text-align: center; max-width: 200px;">
                    <div style="background: rgba(136, 218, 34, 0.1); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; border: 1px solid rgba(136, 218, 34, 0.3);">
                        <i class="fas fa-ticket-alt" style="color: #88DA22; font-size: 1.2rem;"></i>
                    </div>
                    <h4 style="color: #fff; margin-bottom: 8px; font-family: var(--font-heading);">3. OPEN TICKET</h4>
                    <p style="color: #666; font-size: 0.85rem;">Create a shop ticket to buy.</p>
                </div>
            </div>

            <div class="store-nav fade-in">
                <!-- <button class="store-nav-btn active" onclick="switchTab('cars')">VEHICLE CATALOG</button> -->
                <button class="store-nav-btn active" onclick="switchTab('businesses')">BUSINESS OPPORTUNITIES</button>
            </div>

            <!-- Vehicles Catalog (Disabled)
            <div id="cars-catalog" class="catalog-grid active">
                <div class="product-card">
                    <div class="product-image" style="background-image: url('assets/4.jpg');">
                        <div class="product-badge">NEW</div>
                    </div>
                    <div class="product-info">
                        <span class="product-category">Supercar</span>
                        <h3 class="product-title">Pegassi Zentorno S</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Custom Engine Tuning</li>
                            <li><i class="fas fa-check"></i> Exclusive Livery Options</li>
                            <li><i class="fas fa-check"></i> Advanced Handling Kit</li>
                        </ul>
                        <div class="product-price">
                            <span class="price-tag">$1,250,000</span>
                            <a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" class="btn-view">INQUIRE</a>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image" style="background-image: url('assets/4.jpg'); filter: hue-rotate(180deg);">
                    </div>
                    <div class="product-info">
                        <span class="product-category">Sport Classic</span>
                        <h3 class="product-title">Grotti Brioso Custom</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Widebody Kit</li>
                            <li><i class="fas fa-check"></i> Track-Ready Suspension</li>
                            <li><i class="fas fa-check"></i> Custom Interior</li>
                        </ul>
                        <div class="product-price">
                            <span class="price-tag">$850,000</span>
                            <a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" class="btn-view">INQUIRE</a>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image" style="background-image: url('assets/4.jpg'); filter: saturate(0.5) brightness(0.8);">
                    </div>
                    <div class="product-info">
                        <span class="product-category">Luxury SUV</span>
                        <h3 class="product-title">Enus Jubilee VIP</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Armored Windows</li>
                            <li><i class="fas fa-check"></i> Executive Lounge Rear</li>
                            <li><i class="fas fa-check"></i> Discreet Security Tech</li>
                        </ul>
                        <div class="product-price">
                            <span class="price-tag">$1,500,000</span>
                            <a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" class="btn-view">INQUIRE</a>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <div id="businesses-catalog" class="catalog-grid active">
                <!-- Business 1: Pearls Resort -->
                <div class="product-card" onclick="openProductModal('pearls_resort')">
                    <div class="product-image" style="background-image: url('assets/pearl 1.jpg');">
                        <div class="product-badge">PREMIUM</div>
                    </div>
                    <div class="product-info">
                        <span class="product-category">Coastal Resort</span>
                        <h3 class="product-title">Pearls Resort – Vespucci Beach</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Resort Clubhouse & Fine Dining</li>
                            <li><i class="fas fa-check"></i> Infinity Pool & Ocean Lounge</li>
                            <li><i class="fas fa-check"></i> Private Overwater Villas</li>
                        </ul>
                        <div class="product-price">
                            <span class="price-tag" style="font-size: 1.1rem;">150 TND / 45 EUR</span>
                            <button class="btn-view">DETAILS</button>
                        </div>
                    </div>
                </div>

                <!-- Business 2: Smoking Vape Store -->
                <div class="product-card" onclick="openProductModal('vape_store')">
                    <div class="product-image" style="background-image: url('assets/smoking.jpg');">
                    </div>
                    <div class="product-info">
                        <span class="product-category">Specialized Retail</span>
                        <h3 class="product-title">Smoking Vape Store</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Editable 3D Sign System</li>
                            <li><i class="fas fa-check"></i> Immersive Interior Audio</li>
                            <li><i class="fas fa-check"></i> Precision Door Tuning</li>
                        </ul>
                        <div class="product-price">
                            <span class="price-tag" style="font-size: 1.1rem;">150 TND / 35 EUR</span>
                            <button class="btn-view">DETAILS</button>
                        </div>
                    </div>
                </div>

                <!-- Business 3: PDM -->
                <div class="product-card" style="opacity: 0.8; position: relative;" onclick="openProductModal('pdm')">
                    <div class="product-image" style="background-image: url('assets/pdm 1.jpg');">
                        <div class="product-badge" style="background: #ff3333; color: #fff; box-shadow: 0 0 15px rgba(255,51,51,0.4);">SOLD OUT</div>
                    </div>
                    <div class="product-info">
                        <span class="product-category">Automotive Dealership</span>
                        <h3 class="product-title">Premium Deluxe Motorsport</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Sophisticated Modern Showroom</li>
                            <li><i class="fas fa-check"></i> Advanced Service & Upgrade Bay</li>
                            <li><i class="fas fa-check"></i> Executive Offices & VIP Lounge</li>
                        </ul>
                        <div class="product-price">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 0.7rem; color: #ff3333; letter-spacing: 1px; margin-bottom: 2px;">ACQUISITION CLOSED</span>
                                <span class="price-tag" style="font-size: 1.1rem; opacity: 0.5;">SOLD OUT</span>
                            </div>
                            <button class="btn-view">DETAILS</button>
                        </div>
                    </div>
                </div>

                <!-- Business 4: Tuner Shop -->
                <div class="product-card" onclick="openProductModal('tunershop')">
                    <div class="product-image" style="background-image: url('assets/tuner 1.jpg');">
                    </div>
                    <div class="product-info">
                        <span class="product-category">Tuning & Customs</span>
                        <h3 class="product-title">RED's Tunershop</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Modern Workshop & Bays</li>
                            <li><i class="fas fa-check"></i> Dedicated Meet Space</li>
                            <li><i class="fas fa-check"></i> Street Racing Aesthetics</li>
                        </ul>
                        <div class="product-price">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 0.7rem; color: #88DA22; letter-spacing: 1px; margin-bottom: 2px;">STARTING AUCTION</span>
                                <span class="price-tag" style="font-size: 1.1rem;">200 TND / 59 EUR</span>
                            </div>
                            <button class="btn-view">DETAILS</button>
                        </div>
                    </div>
                </div>

                <!-- Business 5: Lake Restaurant -->
                <div class="product-card" onclick="openProductModal('lake_restaurant')">
                    <div class="product-image" style="background-image: url('assets/lake 1.jpg');">
                    </div>
                    <div class="product-info">
                        <span class="product-category">Dining & Events</span>
                        <h3 class="product-title">Lake Restaurant</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Spacious 2-Floor Layout</li>
                            <li><i class="fas fa-check"></i> Custom Prop Assets</li>
                            <li><i class="fas fa-check"></i> Panoramic Lakefront Views</li>
                        </ul>
                        <div class="product-price">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 0.7rem; color: #88DA22; letter-spacing: 1px; margin-bottom: 2px;">STARTING AUCTION</span>
                                <span class="price-tag" style="font-size: 1.1rem;">120 TND / 35 EUR</span>
                            </div>
                            <button class="btn-view">DETAILS</button>
                        </div>
                    </div>
                </div>

                <!-- Business 6: Tropical Heights -->
                <div class="product-card" style="opacity: 0.8; position: relative;" onclick="openProductModal('tropical_heights')">
                    <div class="product-image" style="background-image: url('assets/tropical 1.jpg');">
                        <div class="product-badge" style="background: #ff3333; color: #fff; box-shadow: 0 0 15px rgba(255,51,51,0.4);">SOLD OUT</div>
                    </div>
                    <div class="product-info">
                        <span class="product-category">Tropical Hub</span>
                        <h3 class="product-title">Tropical Heights</h3>
                        <ul class="product-features">
                            <li><i class="fas fa-check"></i> Retro-Futuristic Lobby</li>
                            <li><i class="fas fa-check"></i> Luxury Pool & Rooftop Deck</li>
                            <li><i class="fas fa-check"></i> Pulse-Pumping Nightclub Area</li>
                        </ul>
                        <div class="product-price">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 0.7rem; color: #ff3333; letter-spacing: 1px; margin-bottom: 2px;">ACQUISITION CLOSED</span>
                                <span class="price-tag" style="font-size: 1.1rem; opacity: 0.5;">SOLD OUT</span>
                            </div>
                            <button class="btn-view">DETAILS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
            </div>
        </div>
    </section>
            </div>
        </div>
    </section>

    <!-- Product Details Modal -->
    <div id="productModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-close" onclick="closeProductModal()"><i class="fas fa-times"></i></div>
            <div class="modal-content-grid">
                <div class="modal-image-viewer">
                    <div class="nav-arrow arrow-left" onclick="changeImage(-1)"><i class="fas fa-chevron-left"></i></div>
                    <div class="nav-arrow arrow-right" onclick="changeImage(1)"><i class="fas fa-chevron-right"></i></div>
                    <img id="modalMainImg" src="" alt="Business Detail" class="main-modal-img">
                    <div id="imageNav" class="image-nav">
                        <!-- Dots injected via JS -->
                    </div>
                </div>
                <div class="modal-details">
                    <span id="modalTag" class="modal-tag"></span>
                    <h2 id="modalTitle" class="modal-title"></h2>
                    <p id="modalDesc" class="modal-desc"></p>
                    
                    <div id="modalFeatures" class="modal-features-list">
                        <!-- Features injected via JS -->
                    </div>

                    <div class="modal-footer">
                        <div class="modal-price" id="modalPrice"></div>
                        <div style="text-align: right;">
                            <a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" class="btn-modal-action" id="modalActionButton">OPEN DISCORD TICKET</a>
                            <p style="color: #666; font-size: 0.75rem; margin-top: 10px; font-style: italic;">To acquire this business, please join our Discord and open a "Shop" ticket.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Footer -->
    <footer class="main-footer" style="background: #0a0a0a; border-top: 1px solid #222; padding: 60px 0 30px;">
        <div class="container">
            <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px;">
                
                <div class="footer-col">
                    <h2 style="font-family: var(--font-heading); margin-bottom: 20px;">ELITE <span class="accent">RP</span></h2>
                    <p style="color: #888; margin-bottom: 20px; line-height: 1.6;">The premier GTA V roleplay experience. Join a world of limitless possibilities.</p>
                    <div class="server-status-pill" style="display: inline-flex; align-items: center; background: rgba(136, 218, 34, 0.1); padding: 8px 15px; border-radius: 50px; border: 1px solid rgba(136, 218, 34, 0.2);">
                        <span class="status-dot" style="width: 8px; height: 8px; background: #88DA22; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 10px #88DA22; animation: items-pulse 2s infinite;"></span>
                        <span style="color: #fff; font-size: 0.9rem; font-weight: 600;">FiveM Server Online</span>
                    </div>
                </div>

                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Navigation</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="index.php" style="color: #888; text-decoration: none; transition: 0.3s;">Home</a></li>
                        <li><a href="store.php" style="color: #888; text-decoration: none; transition: 0.3s;">Store</a></li>
                        <li><a href="application.php" style="color: #888; text-decoration: none; transition: 0.3s;">Apply for Whitelist</a></li>
                        <li><a href="rules.php" style="color: #888; text-decoration: none; transition: 0.3s;">Server Rules</a></li>
                        <li><a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" style="color: #888; text-decoration: none; transition: 0.3s;">Discord Community</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Legal</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="terms.php" style="color: #888; text-decoration: none; transition: 0.3s;">Terms of Service</a></li>
                        <li><a href="privacy.php" style="color: #888; text-decoration: none; transition: 0.3s;">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Connect</h4>
                    <div class="social-icons" style="display: flex; gap: 15px;">
                        <a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" style="width: 40px; height: 40px; background: #1a1a1a; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff; text-decoration: none; transition: 0.3s;"><i class="fab fa-discord"></i></a>
                        <a href="<?php echo INSTAGRAM_URL; ?>" target="_blank" style="width: 40px; height: 40px; background: #1a1a1a; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff; text-decoration: none; transition: 0.3s;"><i class="fab fa-instagram"></i></a>
                        <a href="<?php echo YOUTUBE_URL; ?>" target="_blank" style="width: 40px; height: 40px; background: #1a1a1a; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff; text-decoration: none; transition: 0.3s;"><i class="fab fa-youtube"></i></a>
                        <a href="<?php echo TIKTOK_URL; ?>" target="_blank" style="width: 40px; height: 40px; background: #1a1a1a; display: flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff; text-decoration: none; transition: 0.3s;"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom" style="border-top: 1px solid #1a1a1a; padding-top: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <p style="color: #666; font-size: 0.9rem;">&copy; <?php echo date("Y"); ?> Elite Roleplay. All Rights Reserved.</p>
                <p style="color: #666; font-size: 0.9rem;">Not affiliated with Rockstar Games or Take-Two Interactive.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script>
        const products = {
            'pearls_resort': {
                tag: 'Coastal Resort Opportunity',
                title: 'Pearls Resort – Vespucci Beach',
                desc: 'Experience pure luxury at Vespucci Beach. Pearls Resort is a masterpiece of modern architecture, combining fine dining, world-class amenities, and breathtaking ocean views. This is the ultimate destination for those who demand the finest in beachside living and hospitality.',
                price: '150 TND / 45 EUR',
                images: ['assets/pearl 1.jpg', 'assets/pearl 2.jpg', 'assets/pearl 3.jpg', 'assets/pearl 4.jpg'],
                features: [
                    'Resort Clubhouse: Fine dining & premium bar',
                    'Infinity Pool & Lounge: Ambient night lighting',
                    'Overwater Villas: Private terraces & plunge pools',
                    'Docking Access: Boat-ready piers for arrivals',
                    'High-End Design: Glass, stone, and wood details'
                ]
            },
            'pdm': {
                tag: 'Automotive Dealership Opportunity - SOLD',
                title: 'Premium Deluxe Motorsport (PDM)',
                desc: 'Step into the world of elite automotive sales. Premium Deluxe Motorsport offers a bold and modern facade that reflects the elegance and professionalism of the brand. This fully-featured dealership is ready to showcase the finest vehicles Los Santos has to offer.',
                price: 'SOLD OUT',
                isSold: true,
                images: ['assets/pdm 1.jpg', 'assets/pdm 2.jpg', 'assets/pdm 3.jpg', 'assets/pdm 4.jpg'],
                features: [
                    'Sophisticated Showroom: Spacious & modern finishes',
                    'Executive Offices: Ideal for professional consultations',
                    'VIP Lounge: Refreshments & upscale waiting area',
                    'Advanced Service Bay: Vehicle maintenance & upgrades',
                    'Interactive Displays: Financing & details panels',
                    'Customer Parking: Easy dealership access',
                    'Exterior Design: Bold & elegant facade'
                ]
            },
            'tunershop': {
                tag: 'Street Racing Opportunity',
                title: 'RED\'s Tunershop',
                desc: 'Unleash your inner speed demon. RED\'s Tunershop is more than just a workshop; it\'s a hub for underground racing culture. Featuring bold red and black tones with neon highlights, this hub is the definitive place for hosting car meets and planning the city\'s most daring races.',
                price: '200 TND / 59 EUR (Starting Bid - Auction on Discord)',
                images: ['assets/tuner 1.jpg', 'assets/tuner 2.jpg', 'assets/tuner 3.jpg', 'assets/tuner 4.jpg'],
                features: [
                    'Modern Workshop: Tool stations & tuning bays',
                    'Showroom: Sleek vehicle display lighting',
                    'Street Vibes: Red/black tones & neon highlights',
                    'Chill Zone: Lounge for deals & race planning',
                    'Meet Space: Dedicated underground car meets',
                    'Custom Exterior: Gritty urban aesthetic'
                ]
            },
            'lake_restaurant': {
                tag: 'Dining & Hospitality Opportunity',
                title: 'Lake Restaurant',
                desc: 'Escape the chaos of the city and dine in style. The Lake Restaurant offers a serene, multi-level experience with panoramic views of the water. With custom prop assets and high-end interior design, this is the premier venue for social gatherings and sophisticated fine dining.',
                price: '120 TND / 35 EUR (Starting Bid - Auction on Discord)',
                images: ['assets/lake 1.jpg', 'assets/lake 2.jpg', 'assets/lake 3.jpg', 'assets/lake 4.jpg'],
                features: [
                    'Spacious 2-Floor Layout: Multi-level dining',
                    'Custom Prop Assets: Unique interior details',
                    'Panoramic Views: Scenic lakefront dining',
                    'Outdoor Deck: Perfect for lakeside social events',
                    'Modern Kitchen: Fully equipped for high-end dining',
                    'Ample Parking: Convenient client access'
                ]
            },
            'tropical_heights': {
                tag: 'Tropical Lifestyle Opportunity - SOLD',
                title: 'Tropical Heights',
                desc: 'Step into a retro-futuristic oasis. Tropical Heights is the beating heart of social life, where neon accents meet crystal-clear waters. From its expertly crafted nightclub area to its panoramic rooftop views of Los Santos, this bespoke hub is fully customizable to your personal brand.',
                price: 'SOLD OUT',
                isSold: true,
                images: [
                    'assets/tropical 1.jpg', 
                    'assets/tropical 2.jpg', 
                    'assets/tropical 3.jpg', 
                    'assets/tropical 4.jpg', 
                    'assets/tropical 5.jpg', 
                    'assets/tropical 6.jpg', 
                    'assets/tropical 7.jpg'
                ],
                features: [
                    'Retro-Futurism Lobby: Neon accents & sleek design',
                    'Bar & Nightclub Area: Beating heart of the hub',
                    'Office Room: Quiet oasis for retreats',
                    'Luxury Swimming Pool: Refreshing city escape',
                    'Rooftop Area: Panoramic Los Santos views',
                    'Customizable: Animated lights & logos settings'
                ]
            },
            'vape_store': {
                tag: 'Specialized Retail Opportunity',
                title: 'Smoking Vape Store',
                desc: 'The city\'s definitively modern retail experience. The Smoking Vape Store features an interactive interior with precision audio occlusion and custom prop assets. Whether you’re looking to establish a niche retail brand or a social storefront, this editable property offers a unique layer of immersion.',
                price: '150 TND / 35 EUR',
                images: ['assets/smoking.jpg', 'assets/smoking 2.jpg', 'assets/smoking 3.jpg'],
                features: [
                    'Editable 3D Sign: Custom brand identification',
                    'Audio Occlusion: Immersive realistic sound environment',
                    'Vape Props: High-resolution custom model integration',
                    'Door Tuning: Precision door physics and sounds',
                    'Modern Interior: Sleek, high-end retail aesthetic'
                ]
            }
        };

        function openProductModal(id) {
            const product = products[id];
            if (!product) return;

            document.getElementById('modalTag').innerText = product.tag;
            document.getElementById('modalTitle').innerText = product.title;
            document.getElementById('modalDesc').innerText = product.desc;
            document.getElementById('modalPrice').innerText = product.price;

            const actionBtn = document.getElementById('modalActionButton');
            if (product.isSold) {
                actionBtn.innerText = 'ACQUISITION CLOSED';
                actionBtn.style.background = '#333';
                actionBtn.style.color = '#888';
                actionBtn.style.pointerEvents = 'none';
                document.getElementById('modalPrice').style.color = '#ff3333';
                document.getElementById('modalTag').style.color = '#ff3333';
            } else {
                actionBtn.innerText = 'OPEN DISCORD TICKET';
                actionBtn.style.background = 'var(--accent-green)';
                actionBtn.style.color = '#000';
                actionBtn.style.pointerEvents = 'all';
                document.getElementById('modalPrice').style.color = 'var(--accent-green)';
                document.getElementById('modalTag').style.color = 'var(--accent-green)';
            }

            // Features
            const featuresDiv = document.getElementById('modalFeatures');
            featuresDiv.innerHTML = '';
            product.features.forEach(f => {
                featuresDiv.innerHTML += `
                    <div class="modal-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>${f}</span>
                    </div>
                `;
            });

            // Images
            const mainImg = document.getElementById('modalMainImg');
            mainImg.src = product.images[0];
            
            const nav = document.getElementById('imageNav');
            nav.innerHTML = '';
            product.images.forEach((img, index) => {
                const dot = document.createElement('div');
                dot.className = 'dot' + (index === 0 ? ' active' : '');
                dot.onclick = (e) => {
                    e.stopPropagation();
                    mainImg.src = img;
                    document.querySelectorAll('.dot').forEach(d => d.classList.remove('active'));
                    dot.classList.add('active');
                };
                nav.appendChild(dot);
            });

            document.getElementById('productModal').classList.add('active');
            document.body.style.overflow = 'hidden';

            // Store current product data for arrows
            window.currentModalImages = product.images;
            window.currentImageIndex = 0;
        }

        function changeImage(dir) {
            if (!window.currentModalImages) return;
            
            window.currentImageIndex += dir;
            if (window.currentImageIndex >= window.currentModalImages.length) window.currentImageIndex = 0;
            if (window.currentImageIndex < 0) window.currentImageIndex = window.currentModalImages.length - 1;
            
            const mainImg = document.getElementById('modalMainImg');
            mainImg.src = window.currentModalImages[window.currentImageIndex];
            
            // Update dots
            document.querySelectorAll('.dot').forEach((d, i) => {
                d.classList.toggle('active', i === window.currentImageIndex);
            });
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close on click outside
        window.onclick = function(event) {
            const modal = document.getElementById('productModal');
            if (event.target == modal) {
                closeProductModal();
            }
        }

        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.store-nav-btn').forEach(btn => btn.classList.remove('active'));
            if (event) event.target.classList.add('active');
            
            // Update catalogs
            document.querySelectorAll('.catalog-grid').forEach(grid => grid.classList.remove('active'));
            const target = document.getElementById(tab + '-catalog');
            if (target) target.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetch('api/auth/profile.php')
                .then(res => res.json())
                .then(data => {
                    if (data.authenticated) {
                        const authDiv = document.getElementById('userAuthDisplay');
                        authDiv.innerHTML = `
                            <div class="user-profile">
                                <img src="${data.steam.avatar}" alt="Avatar" class="user-avatar">
                                <span class="user-name">${data.steam.personaname}</span>
                            </div>
                        `;
                    }
                })
                .catch(err => console.log('Auth check skipped'));
        });
    </script>
</body>

</html>
