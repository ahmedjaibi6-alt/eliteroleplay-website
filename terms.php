<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elite Roleplay Terms of Service. Review our user agreement and policies.">
    <title>Elite Roleplay - Terms of Service</title>
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="Elite Roleplay - Terms of Service">
    <meta property="og:description" content="User Agreement and Terms for Elite Roleplay Server.">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/bg.jpg">
    <meta property="og:url" content="<?php echo SITE_URL; ?>/terms.php">
    <meta property="og:type" content="website">
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
        .tos-section {
            padding: 50px 0;
            min-height: 80vh;
        }
        
        .tos-container {
            background: rgba(13, 13, 13, 0.95);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 50px;
            max-width: 900px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
        }
        
        .tos-content h3 {
            font-family: var(--font-heading);
            color: #fff;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.5rem;
            border-left: 3px solid var(--accent-green);
            padding-left: 15px;
        }
        
        .tos-content p {
            color: #ccc;
            line-height: 1.7;
            margin-bottom: 15px;
        }
        
        .tos-content ul {
            list-style: none;
            padding-left: 20px;
            margin-bottom: 20px;
        }
        
        .tos-content ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            color: #ccc;
        }
        
        .tos-content ul li::before {
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

    <section class="section tos-section">
        <div class="container">
            <div class="section-title fade-in">
                <h2>TERMS OF <span class="accent">SERVICE</span></h2>
                <div class="title-bar"></div>
            </div>

            <div class="tos-container fade-in-up">
                <span class="last-updated">Last Updated: <?php echo date("F d, Y"); ?></span>
                
                <div class="tos-content">
                    <p>Welcome to <strong>Elite Roleplay</strong>. These Terms of Service ("Terms") govern your access to and use of our GTA V FiveM server, website, and related community platforms. By accessing our services, you agree to be bound by these Terms, our Privacy Policy, and our Server Rules.</p>

                    <h3>1. General Terms</h3>
                    <p>Elite Roleplay ("EliteRP") reserves the right to modify, update, or discontinue these Terms or any part of our services at any time without prior notice. Continued use of our services constitutes acceptance of any changes.</p>
                    <p>We are an independent community and are not affiliated with, endorsed by, or connected to Rockstar Games, Take-Two Interactive, or any of their subsidiaries.</p>

                    <h3>2. Prohibited Conduct</h3>
                    <p>To maintain a safe and immersive environment, you agree strictly to the following:</p>
                    <ul>
                        <li><strong>Illegal Use:</strong> You may not use our services for any unlawful purpose or to facilitate illegal activities.</li>
                        <li><strong>Harassment:</strong> Bullying, threats, hate speech, and harassment of other players or staff are strictly prohibited and will result in immediate termination of access.</li>
                        <li><strong>Exploits:</strong> The use of bugs, glitches, or external software (cheats/hacks) to gain an unfair advantage is forbidden. All discovered issues must be reported to staff immediately.</li>
                        <li><strong>Intellectual Property:</strong> You may not claim ownership of any assets derived from Grand Theft Auto V or FiveM.</li>
                        <li><strong>Age Requirement:</strong> You must be at least 18 years of age to access or play on our server.</li>
                    </ul>

                    <h3>3. Disclaimer of Warranties</h3>
                    <p>Our services are provided on an "as-is" and "as-available" basis. Elite Roleplay makes no warranties, express or implied, regarding the reliability, accuracy, or availability of our services. We do not guarantee that the server will be uninterrupted, error-free, or secure.</p>
                    <p>We are not responsible for any data loss, character resets, or service interruptions.</p>

                    <h3>4. Limitation of Liability</h3>
                    <p>In no event shall Elite Roleplay, its administrators, or staff be liable for any direct, indirect, incidental, special, or consequential damages arising from your use of, or inability to use, our services. This includes, but is not limited to, loss of data, loss of account access, or reliance on information obtained through the service.</p>

                    <h3>5. Indemnification</h3>
                    <p>You agree to indemnify, defend, and hold harmless Elite Roleplay and its team from any claims, liabilities, damages, losses, or expenses arising out of or in any way connected with your access to or use of our services or your violation of these Terms.</p>

                    <h3>6. Entire Agreement</h3>
                    <p>These Terms of Service, together with our Privacy Policy and Server Rules, constitute the entire agreement between you and Elite Roleplay regarding your use of our services, superseding any prior agreements.</p>
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
    <script>
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
