<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elite Roleplay - A Premium GTA V Roleplay Experience.">
    <meta name="robots" content="nosnippet">
    <title>Elite Roleplay</title>
    
    <!-- Open Graph / Social Media Meta Tags (Disabled to prevent embeds) -->
    <!-- <meta property="og:title" content="Elite Roleplay"> -->
    <!-- <meta property="og:description" content="A Premium GTA V Roleplay Experience. Join the chaos, build your legacy, and define your story in Los Santos."> -->
    <!-- <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/bg.jpg"> -->
    <!-- <meta property="og:url" content="<?php echo SITE_URL; ?>"> -->
    <!-- <meta property="og:type" content="website"> -->
    <meta name="theme-color" content="#88DA22">
    <!-- <meta name="twitter:card" content="summary_large_image"> -->

    <!-- Google Fonts: Oswald (Headings) & Geist/Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/style.css?v=1.0.3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="assets/logo.jpg">

    <script>
        window.SERVER_OPEN = <?php echo SERVER_OPEN ? 'true' : 'false'; ?>;
        window.HIDE_COUNTDOWN = <?php echo HIDE_COUNTDOWN ? 'true' : 'false'; ?>;
        
        // Disable Right Click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable Keyboard Shortcuts (F12, Ctrl+Shift+I, Ctrl+U)
        document.onkeydown = function(e) {
            if (e.keyCode == 123) return false; // F12
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false; // Inspect
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false; // Console
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false; // View Source
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false; // Elements
        };
    </script>
</head>

<body>

    <!-- Background Ambience -->
    <div class="ambient-glow"></div>
    <div class="bg-pattern"></div>

    <!-- Floating Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="index.php">
                    <img src="assets/logo.png" alt="EliteRP Logo" class="nav-logo" width="40" height="40" style="max-height: 40px; width: auto;">
                </a>
            </div>

            <ul class="nav-links">
                <li><a href="#hero" class="active">HOME</a></li>
                <li><a href="#about">ABOUT US</a></li>
                <li><a href="#gallery">FEATURES</a></li>

                <li><a href="store.php">STORE</a></li>
                <li><a href="application.php">APPLICATION</a></li>
                <li><a href="rules.php">RULES</a></li>
                <li><a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank">DISCORD</a></li>
            </ul>

            <div class="nav-action">
                <!-- Login / User Profile Container -->
                <div class="user-auth" id="userAuthDisplay">
                    <button class="btn-login" onclick="startLoginProcess()">
                        <i class="fas fa-sign-in-alt"></i> LOGIN
                    </button>
                    <!-- Will be replaced by JS if logged in -->
                </div>
            </div>

            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Split Layout) -->
    <header id="hero" class="hero-section">
        <div class="container hero-container">
            <div class="hero-text fade-in-left">
                <!-- Countdown Timer -->
                <div class="countdown-status" style="font-family: var(--font-heading); color: var(--accent-green); font-size: 0.8rem; letter-spacing: 2px; margin-bottom: 10px; opacity: 0.8;">
                    <i class="fas fa-microchip fa-spin" style="margin-right: 8px;"></i> SYSTEM DECRYPTING...
                </div>
                <div class="hero-countdown" id="releaseCountdown">
                    <div class="time-block">
                        <span id="days">00</span>
                        <small>DAYS</small>
                    </div>
                    <div class="sep">:</div>
                    <div class="time-block">
                        <span id="hours">00</span>
                        <small>HRS</small>
                    </div>
                    <div class="sep">:</div>
                    <div class="time-block">
                        <span id="minutes">00</span>
                        <small>MIN</small>
                    </div>
                    <div class="sep">:</div>
                    <div class="time-block">
                        <span id="seconds">00</span>
                        <small>SEC</small>
                    </div>
                </div>
                <h1>JOIN INTO A WORLD<br><span class="text-stroke">UNSEEN</span></h1>
                <p class="hero-sub">In a city where every choice casts a shadow, power lies not in what you see, but in what you discover. Look beneath the surface.</p>

                <div class="hero-buttons">
                    <?php if (SERVER_OPEN): ?>
                        <a href="#" class="btn btn-primary" id="playNowBtn" onclick="openQueueDashboard(event)">
                            <i class="fas fa-play"></i> PLAY NOW
                        </a>
                    <?php else: ?>
                        <button class="btn btn-primary btn-disabled" style="cursor: not-allowed; opacity: 0.8;" title="Server is not open yet!">
                            <i class="fas fa-rocket"></i> LAUNCHING SOON
                        </button>
                    <?php endif; ?>
                    <a href="rules.php" class="btn btn-glass">
                        <i class="fas fa-book"></i> READ OUR RULES
                    </a>
                </div>

                <div class="server-stats">
                    <div class="stat-item">
                        <span class="stat-val" id="heroPlayerCount">Loading...</span>
                        <span class="stat-label">PLAYERS ONLINE</span>
                    </div>

                </div>
            </div>

            <div class="hero-visual fade-in-up">
                <!-- Placeholder for a Character/Highlight Image -->
                <div class="visual-card">
                    <img src="assets/hero_character.png" alt="Elite RP Character" class="hero-img">
                    <div class="visual-glow"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="section about-section">
        <div class="container">
            <div class="section-title fade-in">
                <h2>ABOUT <span class="accent">ELITE RP</span></h2>
                <div class="title-bar"></div>
            </div>

            <div class="about-grid">
                <div class="about-card large fade-in-up">
                    <div class="card-bg" style="background-image: url('assets/hierarchy_bg.jpg');"></div>
                    <div class="card-content">
                        <h3>IMMERSIVE REALISM</h3>
                        <p>We prioritize a serious, high-standards roleplay environment. This is not a place for "shoot-first" mentalities; it is a stage for complex storytelling, character development, and meaningful interactions where your choices truly matter.</p>
                    </div>
                </div>

                <div class="about-card fade-in-up" style="transition-delay: 0.1s;">
                    <div class="card-icon"><i class="fas fa-check-double"></i></div>
                    <h3>STRICT STANDARDS</h3>
                    <p>Quality over quantity. We maintain strict whitelisting and rule enforcement to ensure every player is here to create, not to disrupt. We value the narrative over the win.</p>
                </div>

                <div class="about-card fade-in-up" style="transition-delay: 0.2s;">
                    <div class="card-icon"><i class="fas fa-user-shield"></i></div>
                    <h3>MATURE COMMUNITY</h3>
                    <p>An 18+ environment designed for adults. We foster a toxicity-free community where respect, creativity, and immersion define your reputation in the city.</p>
                </div>
            </div>
            

        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section gallery-section">
        <div class="container">
            <div class="section-title fade-in">
                <h2>EXPERIENCE <span class="accent">LOS SANTOS</span></h2>
                <div class="title-bar"></div>
                <p class="section-subtitle">Immerse yourself in a living, breathing city where every choice matters.</p>
            </div>

            <div class="gallery-grid">
                <!-- Gallery Card 1: Law Enforcement -->
                <div class="gallery-card fade-in-up">
                    <div class="gallery-image" style="background-image: url('assets/1.jpg');">
                        <div class="gallery-overlay">
                            <div class="gallery-icon"><i class="fas fa-shield-alt"></i></div>
                            <h3>Law Enforcement</h3>
                            <p>Protect and serve as LSPD. Uphold the law in a city of chaos.</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Card 2: Criminal Empire -->
                <div class="gallery-card fade-in-up" style="transition-delay: 0.1s;">
                    <div class="gallery-image" style="background-image: url('assets/2.jpg');">
                        <div class="gallery-overlay">
                            <div class="gallery-icon"><i class="fas fa-user-secret"></i></div>
                            <h3>Criminal Empire</h3>
                            <p>Establish your legacy. Control territories, orchestrate operations, and rise to power.</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Card 3: Business Mogul -->
                <div class="gallery-card fade-in-up" style="transition-delay: 0.2s;">
                    <div class="gallery-image" style="background-image: url('assets/3.jpg');">
                        <div class="gallery-overlay">
                            <div class="gallery-icon"><i class="fas fa-briefcase"></i></div>
                            <h3>Business Mogul</h3>
                            <p>Own legitimate businesses, manage employees, and dominate the economy legally.</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Card 4: Street Racing -->
                <div class="gallery-card fade-in-up" style="transition-delay: 0.3s;">
                    <div class="gallery-image" style="background-image: url('assets/4.jpg');">
                        <div class="gallery-overlay">
                            <div class="gallery-icon"><i class="fas fa-flag-checkered"></i></div>
                            <h3>Street Racing</h3>
                            <p>Customize your ride and compete in underground races. Speed, style, and reputation.</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Card 5: Medical Services -->
                <div class="gallery-card fade-in-up" style="transition-delay: 0.4s;">
                    <div class="gallery-image" style="background-image: url('assets/5.jpg');">
                        <div class="gallery-overlay">
                            <div class="gallery-icon"><i class="fas fa-heartbeat"></i></div>
                            <h3>Medical Services</h3>
                            <p>Save lives as EMS. Respond to emergencies and provide critical care across the city.</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Card 6: Civilian Life -->
                <div class="gallery-card fade-in-up" style="transition-delay: 0.5s;">
                    <div class="gallery-image" style="background-image: url('assets/6.jpg');">
                        <div class="gallery-overlay">
                            <div class="gallery-icon"><i class="fas fa-users"></i></div>
                            <h3>Civilian Life</h3>
                            <p>Live an honest life. Work jobs, socialize, and create your own unique story.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>






    <!-- Rules Section -->


    <!-- Login Modal -->
    <div id="loginModal" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal" onclick="closeLoginModal()">&times;</span>
            <h2>AUTHENTICATION</h2>
            <div class="auth-steps">
                <!-- Step 1: Steam -->
                <div class="auth-step active" id="stepSteam">
                    <div class="step-icon"><i class="fab fa-steam"></i></div>
                    <h3>Step 1: Steam</h3>
                    <p>Connect your Steam account to verify your identity.</p>
                    <button class="btn-steam" onclick="startSteamLogin()">
                        <i class="fab fa-steam"></i> CONNECT STEAM
                    </button>
                </div>
                
                <!-- Step 2: Discord -->
                <div class="auth-step disabled" id="stepDiscord">
                    <div class="step-icon"><i class="fab fa-discord"></i></div>
                    <h3>Step 2: Discord</h3>
                    <p>Connect Discord to check for Whitelist roles.</p>
                    <button class="btn-discord-auth" disabled id="btnDiscordAuth" onclick="startDiscordLogin()">
                        <i class="fab fa-discord"></i> CONNECT DISCORD
                    </button>
                </div>
            </div>
            <div id="authStatus" class="auth-status"></div>
        </div>
    </div>

    <!-- Features / Whitelist Section -->
    <section id="features" class="section apply-section">
        <div class="container">
            <div class="apply-section fade-in-up" style="position: relative; border-radius: 12px; overflow: hidden; padding: 60px 40px; border: 1px solid rgba(136, 218, 34, 0.3);">
                <!-- Background Image -->
                <div class="apply-bg" style="position: absolute; top:0; left:0; width: 100%; height: 100%; background: url('assets/apply_banner.png') center/cover no-repeat; filter: brightness(0.4);"></div>
                
                <!-- Content Overlay -->
                <div class="apply-content" style="position: relative; z-index: 2; max-width: 800px; margin: 0 auto; text-align: center;">
                    <h2 style="font-family: var(--font-heading); font-size: 3rem; margin-bottom: 20px; text-shadow: 0 4px 10px rgba(0,0,0,0.8);">BEGIN YOUR <span class="accent">JOURNEY</span></h2>
                    <p style="color: #ddd; margin-bottom: 30px; font-size: 1.1rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                        Access to Elite Roleplay is restricted to those willing to provide high-quality roleplay. Submit your application to join the whitelist.
                    </p>

                    <!-- Perks List (Centered Grid) -->
                    <ul class="perks-list" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; list-style: none; padding: 0;">
                        <li style="background: rgba(0,0,0,0.4); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);"><i class="fas fa-check-circle accent"></i> Exclusive Custom Scripts</li>
                        <li style="background: rgba(0,0,0,0.4); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);"><i class="fas fa-check-circle accent"></i> Balanced Economy</li>
                        <li style="background: rgba(0,0,0,0.4); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);"><i class="fas fa-check-circle accent"></i> Experienced Staff Team</li>

                    </ul>
                    
                    <a href="application.php" class="btn btn-glass" style="display: inline-flex; border-color: var(--accent-green); color: var(--accent-green); font-size: 1.2rem; padding: 15px 50px; background: rgba(0,0,0,0.6); text-decoration: none;">
                        APPLY FOR WHITELIST
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section id="partners" class="section partners-section">
        <div class="container">
            <div class="section-title fade-in-up">
                <h2>OFFICIAL <span class="accent">PARTNERS</span></h2>
                <div class="title-bar"></div>
            </div>
            <div class="partners-grid fade-in-up">
                <a href="https://rcore.cz" target="_blank" class="partner-card">
                    <div class="partner-logo-container">
                        <img src="assets/partners/rcoreLogo.svg" alt="rcore.cz Logo" class="partner-logo">
                    </div>
                    <div class="partner-info">
                        <h3>RCORE.CZ</h3>
                        <p>Premium FiveM Scripts & Tools</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- Enhanced Footer -->
    <footer class="main-footer" style="background: #0a0a0a; border-top: 1px solid #222; padding: 60px 0 30px;">
        <div class="container">
            <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 40px;">
                
                <!-- Brand & Status -->
                <div class="footer-col">
                    <h2 style="font-family: var(--font-heading); margin-bottom: 20px;">ELITE <span class="accent">RP</span></h2>
                    <p style="color: #888; margin-bottom: 20px; line-height: 1.6;">The premier GTA V roleplay experience. Join a world of limitless possibilities.</p>
                    <div class="server-status-pill" style="display: inline-flex; align-items: center; background: rgba(136, 218, 34, 0.1); padding: 8px 15px; border-radius: 50px; border: 1px solid rgba(136, 218, 34, 0.2);">
                        <span class="status-dot" style="width: 8px; height: 8px; background: #88DA22; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 10px #88DA22; animation: items-pulse 2s infinite;"></span>
                        <span style="color: #fff; font-size: 0.9rem; font-weight: 600;">FiveM Server Online</span>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Navigation</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="index.php" style="color: #888; text-decoration: none; transition: 0.3s;">Home</a></li>
                        <li><a href="application.php" style="color: #888; text-decoration: none; transition: 0.3s;">Apply for Whitelist</a></li>
                        <li><a href="rules.php" style="color: #888; text-decoration: none; transition: 0.3s;">Server Rules</a></li>
                        <li><a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" style="color: #888; text-decoration: none; transition: 0.3s;">Discord Community</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div class="footer-col">
                    <h4 style="color: #fff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Legal</h4>
                    <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 10px;">
                        <li><a href="terms.php" style="color: #888; text-decoration: none; transition: 0.3s;">Terms of Service</a></li>
                        <li><a href="privacy.php" style="color: #888; text-decoration: none; transition: 0.3s;">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Socials -->
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

    <!-- Queue Dashboard Overlay -->
    <div id="queueOverlay" class="queue-overlay hidden">
        <div class="queue-container">
            <div class="queue-header">
                <div class="header-left">
                    <img src="assets/logo.png" alt="Logo" class="queue-logo">
                    <span>Elite Roleplay</span>
                </div>
                <button id="closeQueue" class="btn-close"><i class="fas fa-times"></i></button>
            </div>

            <div class="queue-content">
                <!-- Left Sidebar: Music Only -->
                <div class="queue-sidebar">
                    <div class="widget music-widget">
                        <h4><i class="fas fa-music"></i> Elite Radio</h4>

                        <!-- Audio Elements -->
                        <audio id="bgMusic" loop></audio>

                        <!-- Album Art (decorative) -->
                        <div class="album-wrapper">
                            <div class="album-art"></div>
                            <div class="play-overlay" style="pointer-events:none; background:rgba(0,0,0,0.25);">
                                <i class="fas fa-music" style="font-size:1.4rem; color:var(--accent-green); opacity:0.8;"></i>
                            </div>
                        </div>

                        <!-- Track Info -->
                        <div style="text-align:center; padding: 12px 8px 4px;">
                            <span id="currentTrackName" style="display:block; font-size:0.95rem; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; letter-spacing:0.5px;"></span>
                            <span id="currentArtistName" style="display:block; font-size:0.8rem; color:#888; margin-top:4px;"></span>
                        </div>

                        <!-- Controls: Prev / Pause / Next -->
                        <div style="display:flex; align-items:center; justify-content:center; gap:20px; margin: 14px 0 12px;">
                            <button onclick="prevTrack()" title="Previous" style="background:none; border:none; color:#888; cursor:pointer; font-size:1.05rem; padding:8px; border-radius:50%; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">
                                <i class="fas fa-step-backward"></i>
                            </button>
                            <button id="playPauseBtn" onclick="togglePlayPause()" title="Play / Pause" style="background:var(--accent-green); border:none; color:#000; cursor:pointer; font-size:1rem; width:42px; height:42px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 0 14px rgba(136,218,34,0.45); transition:all 0.2s; flex-shrink:0;">
                                <i class="fas fa-pause" id="playIcon"></i>
                            </button>
                            <button onclick="nextTrack()" title="Next" style="background:none; border:none; color:#888; cursor:pointer; font-size:1.05rem; padding:8px; border-radius:50%; transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#888'">
                                <i class="fas fa-step-forward"></i>
                            </button>
                        </div>

                        <!-- Volume -->
                        <div class="volume-row">
                            <i class="fas fa-volume-up" id="muteBtn"></i>
                            <div class="volume-track" id="volTrack">
                                <div class="volume-fill" style="width:20%"></div>
                                <div class="volume-handle" style="left:20%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content: Queue Logic -->
                <div class="queue-main">
                    <!-- New View: Home / Landing -->
                    <div id="viewHome" class="queue-view active">
                        <div class="dashboard-greeting">
                            <h3>Welcome back, <span class="accent user-name-display">Player</span></h3>
                            <p>Ready to hit the streets? Join the queue to enter the city.</p>
                        </div>
                        
                        <div class="dashboard-actions">
                            <button class="btn-dashboard-large" onclick="switchView('servers')">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>JOIN QUEUE</span>
                            </button>
                            
                            <div class="dashboard-stats-row">
                                <div class="dash-stat">
                                    <i class="fas fa-users"></i>
                                    <div class="stat-info">
                                        <span class="stat-value" id="dashPlayerCount">--</span>
                                        <span class="stat-label">Online</span>
                                    </div>
                                </div>
                                <div class="dash-stat">
                                    <i class="fas fa-server"></i>
                                    <div class="stat-info">
                                        <span class="stat-value">Online</span>
                                        <span class="stat-label">Status</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="viewServers" class="queue-view">
                        <div class="view-header">
                            <button class="btn-back" onclick="switchView('home')"><i class="fas fa-arrow-left"></i> Back</button>
                            <h3>SELECT SERVER</h3>
                        </div>
                        <div class="server-list">
                            <button class="server-card wide" id="mainServerCard" onclick="selectServer('main')">
                                <div class="server-icon-large"><img src="assets/logo.jpg" alt="Icon"></div>
                                <div class="server-info-col">
                                    <span class="server-name">ELITE ROLEPLAY</span>
                                    <span class="server-desc">Serious RP • Custom Vehicles • Drugs • Gangs</span>
                                </div>
                                <div class="server-status-col">
                                    <span class="player-count" id="serverPlayerCount">Loading...</span>
                                    <span class="status-badge online" id="serverStatusBadge">ONLINE</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div id="viewQueue" class="queue-view">
                        <h3 id="queueTitle">Elite RP Main - Queue</h3>
                        <div class="queue-status-box">
                            <div class="queue-header-inner">
                                <span>CURRENT POSITION</span>
                                <button class="btn-leave" onclick="leaveQueue()">Leave Queue</button>
                            </div>
                            <div class="position-display">
                                <span id="queuePos">1</span><span class="total-pos">/ 1</span>
                            </div>
                            <div class="queue-footer">
                                <span><i class="far fa-clock"></i> TIME IN QUEUE</span>
                                <span id="queueTime">00:00</span>
                            </div>
                            <div class="queue-status-indicator">
                                <i class="fas fa-circle pulse-dot"></i>
                                <span id="lastUpdated">Connecting...</span>
                            </div>
                        </div>
                    </div>

                    <div id="viewReady" class="queue-view">
                        <h3>Elite RP Main - Ready</h3>
                        <div class="queue-status-box ready-glow">
                            <div class="ready-content">
                                <span class="timer-label"><i class="far fa-clock"></i> TIME TO ACCEPT</span>
                                <span class="accept-timer">02:00</span>
                                <h1 class="ready-title">ACCEPT JOIN OFFER</h1>
                                <div class="ready-actions">
                                    <button class="btn-leave" onclick="leaveQueue()">Decline</button>
                                    <a href="fivem://connect/eliterp.serverloom.com" class="btn-confirm" onclick="confirmJoin()">Connect Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View 4: Already Connected -->
                    <div id="viewConnected" class="queue-view">
                        <h3>Elite RP Main - Status</h3>
                        <div class="queue-status-box" style="border-color: #00ff88; box-shadow: 0 0 20px rgba(0,255,136,0.1);">
                            <div class="ready-content">
                                <span style="color: #00ff88; font-size: 1.2rem; display: block; margin-bottom: 20px;">
                                    <i class="fas fa-check-circle"></i> CONNECTED
                                </span>
                                <h1 style="font-size: 2rem; margin-bottom: 30px;">YOU ARE IN GAME</h1>
                                <div class="ready-actions">
                                    <button class="btn-leave" onclick="resetConnection()">Disconnect / Re-Queue</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="js/script.js"></script>
</body>

</html>