<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elite Roleplay Privacy Policy. Learn how we collect, use, and protect your data.">
    <title>Elite Roleplay - Privacy Policy</title>
    
    <!-- Open Graph / Social Media Meta Tags (Disabled to prevent embeds) -->
    <!-- <meta property="og:title" content="Elite Roleplay - Privacy Policy"> -->
    <!-- <meta property="og:description" content="Data protection and privacy standards for the Elite Roleplay community."> -->
    <!-- <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/bg.jpg"> -->
    <!-- <meta property="og:url" content="<?php echo SITE_URL; ?>/privacy.php"> -->
    <!-- <meta property="og:type" content="website"> -->
    <meta name="theme-color" content="#88DA22">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="assets/logo.jpg">

    <!-- Anti-Theft Protection -->
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
        .privacy-section {
            padding: 50px 0;
            min-height: 80vh;
        }
        
        .privacy-container {
            background: rgba(13, 13, 13, 0.95);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 50px;
            max-width: 900px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
        }
        
        .privacy-content h3 {
            font-family: var(--font-heading);
            color: #fff;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.5rem;
            border-left: 3px solid var(--accent-green);
            padding-left: 15px;
        }
        
        .privacy-content p {
            color: #ccc;
            line-height: 1.7;
            margin-bottom: 15px;
        }
        
        .privacy-content ul {
            list-style: none;
            padding-left: 20px;
            margin-bottom: 20px;
        }
        
        .privacy-content ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            color: #ccc;
        }
        
        .privacy-content ul li::before {
            content: "•";
            color: var(--accent-green);
            position: absolute;
            left: 0;
            font-weight: bold;
        }
        
        .last-updated {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
            display: block;
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
                <li><a href="index.php#features">FEATURES</a></li>
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

    <div style="padding-top: 100px;"></div>

    <section class="section privacy-section">
        <div class="container">
            <div class="section-title fade-in">
                <h2>PRIVACY <span class="accent">POLICY</span></h2>
                <div class="title-bar"></div>
            </div>

            <div class="privacy-container fade-in-up">
                <span class="last-updated">Last Updated: <?php echo date("F d, Y"); ?></span>
                
                <div class="privacy-content">
                    <p>At <strong>Elite Roleplay</strong>, we value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard the data you provide when using our services.</p>

                    <h3>1. Information We Collect</h3>
                    <p>When you access our website or game server, we may collect the following information:</p>
                    <ul>
                        <li><strong>Platform Identifiers:</strong> Your Steam ID, Discord ID, and FiveM License identifier. These are used strictly for authentication and whitelist verification.</li>
                        <li><strong>User Input:</strong> Information you voluntarily provide in applications, such as your age, roleplay experience, and character details.</li>
                    </ul>

                    <h3>2. How We Use Your Data</h3>
                    <p>The information we collect is used solely for the following purposes:</p>
                    <ul>
                        <li><strong>Authentication:</strong> To verify your identity and ensure you have the necessary permissions (whitelist) to join the server.</li>
                        <li><strong>Server Administration:</strong> To manage bans, warnings, and player records within our database.</li>
                        <li><strong>Improvement:</strong> To analyze player trends and improve server performance and gameplay features.</li>
                    </ul>

                    <h3>3. Data Sharing and Disclosure</h3>
                    <p>We do not sell, trade, or otherwise transfer your personal information to outside parties. Data may be shared only under the following circumstances:</p>
                    <ul>
                        <li><strong>Legal Requirements:</strong> If required by law or to protect the rights and safety of our community.</li>
                        <li><strong>Service Providers:</strong> We may use trusted third-party services (e.g., Discord) to facilitate community management, subject to their own privacy policies.</li>
                    </ul>

                    <h3>4. Data Security</h3>
                    <p>We implement a variety of security measures to maintain the safety of your personal information. Sensitive data is stored in secured databases with restricted access. However, no method of transmission over the internet is involved in 100% security, and we cannot guarantee absolute security.</p>

                    <h3>5. Your Rights</h3>
                    <p>You have the right to request access to the personal data we hold about you. You may also request the deletion of your data from our systems, subject to our need to retain certain information for ban enforcement purposes. To exercise these rights, please contact a staff member via Discord.</p>

                    <h3>6. Changes to This Policy</h3>
                    <p>Elite Roleplay reserves the right to update this Privacy Policy at any time. We will notify the community of significant changes through our Discord server.</p>
                </div>
            </div>
        </div>
    </section>

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

    <script src="js/script.js"></script>
</body>
</html>
