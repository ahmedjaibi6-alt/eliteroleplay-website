<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Apply for the Elite Roleplay Whitelist. Join our serious RP community.">
    <title>Elite Roleplay - Application</title>
    
    <!-- Open Graph / Social Media Meta Tags (Disabled to prevent embeds) -->
    <!-- <meta property="og:title" content="Elite Roleplay - Whitelist Application"> -->
    <!-- <meta property="og:description" content="Join the Elite. Submit your application for our Whitelisted GTA V Server."> -->
    <!-- <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/bg.jpg"> -->
    <!-- <meta property="og:url" content="<?php echo SITE_URL; ?>/application.php"> -->
    <!-- <meta property="og:type" content="website"> -->
    <meta name="theme-color" content="#88DA22">
    <!-- <meta name="twitter:card" content="summary_large_image"> -->

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
        // Disable Right Click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable Keyboard Shortcuts (F12, Ctrl+Shift+I, Ctrl+U)
        document.onkeydown = function(e) {
            if (e.keyCode == 123) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false;
        };
    </script>

    <style>
        .application-section {
            padding: 50px 0;
            min-height: 80vh;
        }
        
        .form-container {
            background: rgba(13, 13, 13, 0.95);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            color: #ddd;
            margin-bottom: 10px;
            font-family: var(--font-heading);
            letter-spacing: 1px;
            font-size: 1.1rem;
        }
        
        .form-input, .form-textarea {
            width: 100%;
            background: #1a1a1a;
            border: 1px solid #333;
            color: #fff;
            padding: 15px;
            border-radius: 6px;
            font-family: var(--font-body);
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--accent-green);
            box-shadow: 0 0 10px rgba(136, 218, 34, 0.1);
        }
        
        .form-textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn-submit {
            background: var(--accent-green);
            color: #000;
            border: none;
            padding: 15px 40px;
            border-radius: 6px;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            width: 100%;
            text-transform: uppercase;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(136, 218, 34, 0.3);
            background: #99ea33;
        }
        
        .info-box {
            background: rgba(88, 101, 242, 0.1); /* Discord Blue tint */
            border-left: 4px solid #5865F2;
            padding: 20px;
            margin-bottom: 30px;
            color: #ccc;
            border-radius: 4px;
        }
        
        .info-box i {
            color: #5865F2;
            margin-right: 10px;
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
                <li><a href="store.php">STORE</a></li>
                <li><a href="application.php" class="active">APPLICATION</a></li>
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

    <section id="application" class="section application-section">
        <div class="container">
            <div class="section-title fade-in">
                <h2>WHITELIST <span class="accent">APPLICATION</span></h2>
                <div class="title-bar"></div>
                <p class="section-subtitle">Take the first step towards joining our premium roleplay community.</p>
            </div>

            <div class="form-container fade-in-up">
                
                <form id="applicationForm" action="api/applications/submit.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Discord Username</label>
                        <input type="text" class="form-input" name="discord_name" required
                               value="<?php echo isset($_SESSION['discord_user']['username']) ? htmlspecialchars($_SESSION['discord_user']['username']) : ''; ?>" 
                               placeholder="Example: User#1234 or User">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Discord ID</label>
                        <input type="text" class="form-input" name="discord_id" required
                               value="<?php echo isset($_SESSION['discord_user']['id']) ? htmlspecialchars($_SESSION['discord_user']['id']) : ''; ?>" 
                               placeholder="Example: 123456789012345678">
                        <small style="color: #666; font-size: 0.8rem; margin-top: 5px; display: block;">You can find your ID by enabling Developer Mode on Discord and right-clicking your profile.</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Steam Name / Hex</label>
                        <input type="text" class="form-input" name="steam_name" required
                               value="<?php echo isset($_SESSION['steam_data']['personaname']) ? htmlspecialchars($_SESSION['steam_data']['personaname']) : ''; ?>" 
                               placeholder="Steam Name or Hex ID">
                    </div>

                    <div class="form-group">
                        <label class="form-label">OOC Age (18+ Required)</label>
                        <input type="number" class="form-input" name="age" min="18" max="99" required placeholder="Enter your real age">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Character Name</label>
                        <input type="text" class="form-input" name="char_name" required placeholder="First Last (e.g. John Doe)">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Character Ethnicity</label>
                        <input type="text" class="form-input" name="char_ethnicity" required placeholder="e.g. Caucasian, Hispanic, Asian, etc.">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Character Backstory</label>
                        <textarea class="form-textarea" name="char_backstory" required placeholder="Write a brief history of your character (minimum 30 characters)..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Character Objectives</label>
                        <textarea class="form-textarea" name="char_objectives" required placeholder="What are your character's goals or aspirations in our city?"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">How did you find us?</label>
                        <select class="form-input" name="source" required>
                            <option value="" disabled selected>Select an option...</option>
                            <option value="FiveM Server List">FiveM Server List</option>
                            <option value="TikTok">TikTok</option>
                            <option value="YouTube">YouTube</option>
                            <option value="Friend">Friend / Word of Mouth</option>
                            <option value="Discord">Discord Discovery</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Why do you want to join Elite Roleplay?</label>
                        <textarea class="form-textarea" name="reason" required placeholder="Tell us why you think you would be a good fit for our community..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Previous Roleplay Experience</label>
                        <textarea class="form-textarea" name="experience" required placeholder="List servers you have played on and your experience level..."></textarea>
                    </div>

                    <div id="formMessage" style="margin-bottom: 20px; padding: 15px; border-radius: 6px; display: none;"></div>
                    
                    <!-- Progress Indicator -->
                    <div id="progressIndicator" style="display: none; margin-bottom: 20px; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
                        <div style="margin-bottom: 15px; color: #88DA22; font-weight: 600; font-family: var(--font-heading);">
                            <i class="fas fa-spinner fa-spin"></i> SUBMITTING APPLICATION...
                        </div>
                        <div class="progress-step" id="progressDiscord" style="margin: 10px 0; color: #666; font-size: 0.9rem;">
                            <i class="fas fa-circle" style="font-size: 8px; margin-right: 8px;"></i>
                            <span>Sending to Discord...</span>
                        </div>
                        <div class="progress-step" id="progressDatabase" style="margin: 10px 0; color: #666; font-size: 0.9rem;">
                            <i class="fas fa-circle" style="font-size: 8px; margin-right: 8px;"></i>
                            <span>Saving to database...</span>
                        </div>
                        <div class="progress-step" id="progressSheets" style="margin: 10px 0; color: #666; font-size: 0.9rem;">
                            <i class="fas fa-circle" style="font-size: 8px; margin-right: 8px;"></i>
                            <span>Logging to Google Sheets...</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">SUBMIT APPLICATION</button>
                </form>
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

            // Application form handler
            const form = document.getElementById('applicationForm');
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');
            const progressIndicator = document.getElementById('progressIndicator');

            if (form) {
                // Auto-fill from localStorage if available (form preservation)
                const savedData = localStorage.getItem('eliteRP_applicationDraft');
                if (savedData) {
                    try {
                        const data = JSON.parse(savedData);
                        Object.keys(data).forEach(key => {
                            const input = form.elements[key];
                            if (input && !input.value) {
                                input.value = data[key];
                            }
                        });
                    } catch (e) {
                        console.error('Failed to restore form data:', e);
                    }
                }

                // Save form data to localStorage on input (auto-save draft)
                form.addEventListener('input', () => {
                    const formData = new FormData(form);
                    const data = {};
                    for (const [key, value] of formData.entries()) {
                        data[key] = value;
                    }
                    localStorage.setItem('eliteRP_applicationDraft', JSON.stringify(data));
                });

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'SUBMITTING...';
                    formMessage.style.display = 'none';
                    progressIndicator.style.display = 'block';

                    // Reset progress indicators
                    resetProgressStep('progressDiscord');
                    resetProgressStep('progressDatabase');
                    resetProgressStep('progressSheets');

                    try {
                        const formData = new FormData(form);
                        const response = await fetch('api/applications/submit.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();

                        // Update progress based on backend response
                        if (result.progress) {
                            if (result.progress.discord) {
                                markStepComplete('progressDiscord', 'Sent to Discord ✓');
                            } else {
                                markStepFailed('progressDiscord', 'Discord failed (non-critical)');
                            }

                            if (result.progress.database) {
                                markStepComplete('progressDatabase', 'Saved to database ✓');
                            } else {
                                markStepFailed('progressDatabase', 'Database failed (non-critical)');
                            }

                            if (result.progress.sheets) {
                                markStepComplete('progressSheets', 'Logged to sheets ✓');
                            } else {
                                markStepFailed('progressSheets', 'Sheets logging failed (non-critical)');
                            }
                        }

                        if (result.success) {
                            formMessage.style.display = 'block';
                            formMessage.style.background = 'rgba(136, 218, 34, 0.1)';
                            formMessage.style.border = '1px solid #88DA22';
                            formMessage.style.color = '#88DA22';
                            formMessage.innerHTML = '<i class="fas fa-check-circle"></i> ' + result.message;
                            
                            // Clear saved draft on success
                            localStorage.removeItem('eliteRP_applicationDraft');
                            form.reset();

                            // Hide progress after 3 seconds
                            setTimeout(() => {
                                progressIndicator.style.display = 'none';
                            }, 3000);
                        } else {
                            formMessage.style.display = 'block';
                            formMessage.style.background = 'rgba(255, 68, 68, 0.1)';
                            formMessage.style.border = '1px solid #ff4444';
                            formMessage.style.color = '#ff4444';
                            formMessage.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + (result.error || result.errors?.join(', ') || 'Submission failed');
                            progressIndicator.style.display = 'none';
                            // Form data is preserved in localStorage
                        }
                    } catch (error) {
                        formMessage.style.display = 'block';
                        formMessage.style.background = 'rgba(255, 68, 68, 0.1)';
                        formMessage.style.border = '1px solid #ff4444';
                        formMessage.style.color = '#ff4444';
                        formMessage.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Network error. Please try again. Your data has been saved.';
                        progressIndicator.style.display = 'none';
                        // Form data is preserved in localStorage
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'SUBMIT APPLICATION';
                    }
                });

                function resetProgressStep(id) {
                    const step = document.getElementById(id);
                    if (step) {
                        step.style.color = '#666';
                        const icon = step.querySelector('i');
                        if (icon) {
                            icon.className = 'fas fa-circle';
                            icon.style.fontSize = '8px';
                        }
                    }
                }

                function markStepComplete(id, text) {
                    const step = document.getElementById(id);
                    if (step) {
                        step.style.color = '#88DA22';
                        const icon = step.querySelector('i');
                        const span = step.querySelector('span');
                        if (icon) {
                            icon.className = 'fas fa-check-circle';
                            icon.style.fontSize = '12px';
                        }
                        if (span) span.textContent = text;
                    }
                }

                function markStepFailed(id, text) {
                    const step = document.getElementById(id);
                    if (step) {
                        step.style.color = '#ff8800';
                        const icon = step.querySelector('i');
                        const span = step.querySelector('span');
                        if (icon) {
                            icon.className = 'fas fa-exclamation-circle';
                            icon.style.fontSize = '12px';
                        }
                        if (span) span.textContent = text;
                    }
                }
            }
        });
    </script>
</body>
</html>
