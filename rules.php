<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Official rules and community standards for Elite Roleplay. Read our guidelines on conduct, criminal activity, and roleplay etiquette.">
    <title>Elite Roleplay - Rules</title>
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="Elite Roleplay - Server Rules">
    <meta property="og:description" content="Read our community standards and rules before joining. Serious RP, High Standards.">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/bg.jpg">
    <meta property="og:url" content="<?php echo SITE_URL; ?>/rules.php">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#88DA22">
    <meta name="twitter:card" content="summary_large_image">

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
                <li><a href="application.php">APPLICATION</a></li>
                <li><a href="rules.php" class="active">RULES</a></li>
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

    <section id="rules" class="section rules-section">
        <div class="container">
            <div class="section-title fade-in">
                <h2>SERVER <span class="accent">RULES</span></h2>
                <div class="title-bar"></div>
                <p class="section-subtitle">Please read and understand our community standards before joining.</p>
            </div>

            <!-- CATEGORY: SERVER RULES -->
            <div class="rule-category fade-in-up">
                <h3 class="category-title">CORE PRINCIPLES</h3>
                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-heart"></i></div>
                        <h3>Healthy Environment</h3>
                        <p>Our aim is to create an environment where losing a gunfight or chase doesn't penalize the player—instead, it rewards everyone involved with a fun and immersive RP experience.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-gavel"></i></div>
                        <h3>Engaging Ruleset</h3>
                        <p>We prioritize genuine RP over strict regulation adherence. Staff will evaluate violations based on real harm. If a situation creates an enjoyable RP outcome, we won't interfere. Our goal is to cultivate positive experiences.</p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY: ELITE COMMUNITY RULES -->
            <div class="rule-category fade-in-up">
                <h3 class="category-title">COMMUNITY STANDARDS</h3>
                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-ban"></i></div>
                        <h3>No Hate Speech</h3>
                        <p>Zero tolerance for racism, sexism, homophobia, real-world politics or bigotry. Breaking this results in a permanent ban.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-user-shield"></i></div>
                        <h3>No Harassment</h3>
                        <p>Harassment via Discord, DMs, or other channels is prohibited. We do not mediate personal disputes, but we will ban off-server actions that endanger safety or foster toxicity.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-comments"></i></div>
                        <h3>No Toxicity</h3>
                        <p>Criticism is allowed; toxicity is not. Abuse towards the community or staff will not be tolerated.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon">18+</div>
                        <h3>Adult Server</h3>
                        <p>This server is strictly 18+. Expect adult-themed humor and discussions.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-ticket-alt"></i></div>
                        <h3>Ticket Usage</h3>
                        <p>Use tickets for designated purposes only. Concise, courteous reports. No spamming or arguing with staff.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-id-card"></i></div>
                        <h3>Naming Policy</h3>
                        <p>Usernames and profiles must align with standards. no slurs, impersonation, or offensive content.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-ad"></i></div>
                        <h3>No Advertising</h3>
                        <p>Do not promote other communities or servers without staff approval.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-peace"></i></div>
                        <h3>Leave Drama at the Door</h3>
                        <p>Keep OOC conflicts out of public channels. You don't have to encourage everyone, but you must behave like an adult.</p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY: FIVEM SERVER RULES -->
            <div class="rule-category fade-in-up">
                <h3 class="category-title">IN-GAME CONDUCT</h3>
                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-theater-masks"></i></div>
                        <h3>Roleplay First</h3>
                        <p>Stay in character at all times. Respond to RP initiated by others, even if busy. Surrender isn't required, but improved interaction is.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-theater-masks"></i></div>
                        <h3>No Breaking Character</h3>
                        <p>Never exit character mid-scene. Report violations afterwards. Exceptions only for severe safety issues.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-shield-alt"></i></div>
                        <h3>No Exploiting</h3>
                        <p>Do not abuse mechanics, glitch for wealth, combat log, or transfer items between characters (metagaming). Report bugs immediately.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-praying-hands"></i></div>
                        <h3>Value Your Life (NVL)</h3>
                        <p>Cherish your character's life. Surrender when at gunpoint or overwhelmed unless you accept permadeath or severe consequences.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-brain"></i></div>
                        <h3>No Metagaming</h3>
                        <p>Using OOC knowledge in-character is banned. No 3rd party comms for server info while in-game.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-video"></i></div>
                        <h3>No Stream Sniping</h3>
                        <p>Never use streams for in-game info. Keep encounters authentic.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-fist-raised"></i></div>
                        <h3>No Powergaming</h3>
                        <p>Do not force outcomes on others. Allow reaction time. /do commands cannot determine success, only actions.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <h3>Fail RP</h3>
                        <p>Low-effort, obnoxious, or unserious behavior is not allowed. Dress your character realistically.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-handshake-slash"></i></div>
                        <h3>Roleplay Over Gunplay</h3>
                        <p>Prioritize interaction before combat. Weapons are a last resort.</p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY: ILLEGAL RP -->
            <div class="rule-category fade-in-up">
                <h3 class="category-title">CRIMINAL GUIDELINES</h3>
                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-skull"></i></div>
                        <h3>No RDM / VDM</h3>
                        <p>Random Deathmatch and Vehicle Deathmatch are prohibited. Initiate RP before attacking.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-hand-holding-usd"></i></div>
                        <h3>No Pocket Wiping</h3>
                        <p>Taking all items without RP justification is griefing. Take valuables/illegal items, not food or junk.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-clock"></i></div>
                        <h3>Conflict Cooldown</h3>
                        <p>Repeated large-scale shootouts within hours qualify as Fail RP.</p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY: MEDICAL & DEATH -->
            <div class="rule-category fade-in-up">
                <h3 class="category-title">DEATH & MEMORY</h3>
                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-notes-medical"></i></div>
                        <h3>Post-Conflict Behavior</h3>
                        <p>Stay in character when downed. No OOC trash talk. React to injuries appropriately.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-memory"></i></div>
                        <h3>New Life Rule (NLR)</h3>
                        <p>If executed/respawned, you forget specific details of your attacker but may recall the broad reason. Treat it as a hazy trauma.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-water"></i></div>
                        <h3>Ocean Dumping</h3>
                        <p>Permitted for narrative but cannot enforce permadeath. Bodies may guide police to avoid evidence abuse.</p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY: GRAPHIC CONTENT -->
            <div class="rule-category fade-in-up">
                <h3 class="category-title">SENSITIVE CONTENT</h3>
                <div class="rules-grid">
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-heart-broken"></i></div>
                        <h3>No ERP</h3>
                        <p>Erotic Roleplay is strictly prohibited in all forms.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-biohazard"></i></div>
                        <h3>Mutilation & Torture</h3>
                        <p>Requires explicit prior consent from all parties involved.</p>
                    </div>
                    <div class="rule-card">
                        <div class="rule-icon"><i class="fas fa-ban"></i></div>
                        <h3>Bad Taste RP</h3>
                        <p>No RP depicting sexual assault, extreme self-harm, recent real-world tragedies, or pregnancy loss without consent/approval.</p>
                    </div>
                </div>
            </div>
            
            <div class="rules-footer fade-in-up" style="text-align: center; margin-top: 60px;">
                <a href="<?php echo DISCORD_INVITE_URL; ?>" target="_blank" class="btn btn-glass" style="display: inline-flex; width: 100%; max-width: 350px; justify-content: center; border-color: var(--accent-green); color: var(--accent-green); padding: 18px 30px; border-radius: 8px; font-size: 1.1rem; letter-spacing: 2px;">
                    <i class="fab fa-discord" style="margin-right: 12px; font-size: 1.3rem;"></i> JOIN OUR DISCORD
                </a>
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
                .catch(err => console.log('Auth check skipped on rules page'));
        });
    </script>
</body>

</html>
