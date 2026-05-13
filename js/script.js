/*! 
 * ⚠️ LEGAL NOTICE ⚠️
 * 
 * This code is proprietary and confidential.
 * Copyright © 2026 Elite Roleplay. All Rights Reserved.
 * 
 * UNAUTHORIZED COPYING, MODIFICATION, DISTRIBUTION, OR USE
 * OF THIS CODE IS STRICTLY PROHIBITED AND MAY RESULT IN
 * SEVERE CIVIL AND CRIMINAL PENALTIES.
 * 
 * This code is protected under international copyright law.
 * Violators will be prosecuted to the fullest extent of the law.
 * 
 * By accessing this file, you agree that you will not copy,
 * modify, reverse engineer, or distribute any part of this code.
 */

// Mobile Menu Toggle
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');

        // Toggle Icon
        const icon = hamburger.querySelector('i');
        if (icon) {
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    });

    // Close menu when clicking a link
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            const icon = hamburger.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    });
}



// CONFIGURATION
const API_BASE = "api/";

// Global State
let userState = {
    authenticated: false,
    steam: null,
    discord: null,
    whitelisted: false
};

// Global Queue & Music Variables
let bgMusic = null;
let notifySound = null;
let queueTimer = null;
let queueSeconds = 0;
let serverOnline = false; // Track server status

// --- INITIALIZATION ---
document.addEventListener('DOMContentLoaded', () => {
    bgMusic = document.getElementById('bgMusic');
    notifySound = document.getElementById('notifySound');

    // Load saved volume preferences
    loadVolumePreferences();

    checkAuthStatus();
    handleUrlParams();
    checkServerStatus(); // Check server status on load
    setInterval(checkServerStatus, 30000); // Check every 30 seconds

    // ESC key to close queue dashboard
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' || e.key === 'Esc') {
            const overlay = document.getElementById('queueOverlay');
            if (overlay && !overlay.classList.contains('hidden')) {
                closeQueueDashboard();
            }
        }
    });
});

// Load volume preferences from localStorage
function loadVolumePreferences() {
    const savedVolume = localStorage.getItem('eliteRP_volume');
    const savedMuted = localStorage.getItem('eliteRP_muted');

    if (bgMusic) {
        if (savedVolume !== null) {
            bgMusic.volume = parseFloat(savedVolume);
            updateVolumeUI(bgMusic.volume);
        }
        if (savedMuted === 'true') {
            bgMusic.muted = true;
            const muteIcon = document.getElementById('muteBtn');
            if (muteIcon) muteIcon.className = 'fas fa-volume-mute';
        }
    }
}

// Save volume preferences to localStorage
function saveVolumePreferences() {
    if (bgMusic) {
        localStorage.setItem('eliteRP_volume', bgMusic.volume);
        localStorage.setItem('eliteRP_muted', bgMusic.muted);
    }
}

// Update volume UI elements
function updateVolumeUI(volume) {
    const percent = volume * 100;
    const fill = document.querySelector('.volume-fill');
    const handle = document.querySelector('.volume-handle');
    if (fill) fill.style.width = percent + '%';
    if (handle) handle.style.left = percent + '%';
}

// Check Server Status
async function checkServerStatus() {
    try {
        const res = await fetch('api/server_status.php');
        const data = await res.json();

        serverOnline = data.online;

        // Update Play Now button
        const playNowBtn = document.getElementById('playNowBtn');
        if (playNowBtn) {
            if (!serverOnline) {
                playNowBtn.classList.add('btn-disabled');
                playNowBtn.style.opacity = '0.5';
                playNowBtn.style.cursor = 'not-allowed';
                playNowBtn.style.pointerEvents = 'none';
                playNowBtn.setAttribute('data-offline', 'true');
            } else {
                playNowBtn.classList.remove('btn-disabled');
                playNowBtn.style.opacity = '1';
                playNowBtn.style.cursor = 'pointer';
                playNowBtn.style.pointerEvents = 'auto';
                playNowBtn.removeAttribute('data-offline');
            }
        }

        // Update player count displays
        const heroPlayerCount = document.getElementById('heroPlayerCount');
        const serverPlayerCount = document.getElementById('serverPlayerCount');
        const serverStatusBadge = document.getElementById('serverStatusBadge');

        if (heroPlayerCount) {
            if (window.SERVER_OPEN === false) {
                heroPlayerCount.textContent = 'Launching Soon';
            } else {
                heroPlayerCount.textContent = serverOnline ? `${data.players}/${data.max_players}` : 'Under Maintenance';
            }
        }

        if (serverPlayerCount) {
            serverPlayerCount.textContent = serverOnline ? `${data.players}/${data.max_players} PLAYERS` : 'UNDER MAINTENANCE';
        }

        if (serverStatusBadge) {
            if (serverOnline) {
                serverStatusBadge.textContent = 'ONLINE';
                serverStatusBadge.className = 'status-badge online';
            } else {
                serverStatusBadge.textContent = 'MAINTENANCE';
                serverStatusBadge.className = 'status-badge offline';
            }
        }
    } catch (error) {
        console.error('Server status check failed:', error);
        serverOnline = false;
    }
}

// Check Auth Status on Load
async function checkAuthStatus() {
    try {
        const res = await fetch(API_BASE + 'auth/profile.php');
        const data = await res.json();
        userState = data;

        if (userState.authenticated) {
            updateNavbarUser();
        }

        // If getting profile fails or not auth, we stay in default state
    } catch (e) {
        console.error("Auth Check Failed:", e);
    }
}

// Handle Redirect Params (e.g. returning from Steam/Discord)
function handleUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const loginStep = params.get('login_step');
    const loginSuccess = params.get('login_success');
    const error = params.get('error');

    if (loginStep === '2') {
        startLoginProcess();
        // Force Steam complete visual
        const stepSteam = document.getElementById('stepSteam');
        const stepDiscord = document.getElementById('stepDiscord');
        const btnSteam = document.querySelector('.btn-steam');
        const btnDiscord = document.getElementById('btnDiscordAuth');

        if (stepSteam) {
            stepSteam.classList.remove('active');
            stepSteam.classList.add('completed');
        }
        if (btnSteam) {
            btnSteam.innerHTML = '<i class="fab fa-steam"></i> CONNECTED';
        }

        // Activate Discord Step
        if (stepDiscord) {
            stepDiscord.classList.remove('disabled');
            stepDiscord.classList.add('active');
        }
        if (btnDiscord) btnDiscord.disabled = false;

        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    if (loginSuccess === '1') {
        // Show Success
        if (authStatus) {
            authStatus.textContent = "LOGIN SUCCESSFUL! WELCOME.";
            authStatus.style.color = "var(--accent-green)";
        }
        // Ideally checking profile will have handled the Navbar update
        setTimeout(() => closeLoginModal(), 2000);
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    if (error) {
        startLoginProcess();
        if (authStatus) {
            if (error === 'not_whitelisted') {
                authStatus.textContent = "ACCESS DENIED: NOT WHITELISTED.";
            } else if (error === 'account_sharing_detected') {
                authStatus.textContent = "SECURITY ALERT: This Discord account is already linked to another Steam account. Account sharing is not allowed.";
            } else {
                authStatus.textContent = "LOGIN ERROR: " + error;
            }
            authStatus.style.color = "#ff3333";
        }
    }
}

// Show Maintenance/Coming Soon Notification
function showMaintenanceNotification() {
    const isClosed = window.SERVER_OPEN === false;
    const overlay = document.createElement('div');
    overlay.style.cssText = `position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9); display: flex; justify-content: center; align-items: center; z-index: 10000; backdrop-filter: blur(10px);`;

    const notification = document.createElement('div');
    notification.style.cssText = `background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%); border: 2px solid ${isClosed ? '#88DA22' : '#ff6b6b'}; border-radius: 12px; padding: 40px; max-width: 500px; text-align: center; box-shadow: 0 20px 60px ${isClosed ? 'rgba(136, 218, 34, 0.2)' : 'rgba(255, 107, 107, 0.3)'}; transform: scale(0.9); animation: modalPop 0.3s forwards ease-out;`;

    notification.innerHTML = `
        <div style="font-size: 60px; margin-bottom: 20px;">${isClosed ? '🚀' : '🔧'}</div>
        <h2 style="color: ${isClosed ? '#88DA22' : '#ff6b6b'}; font-size: 28px; margin-bottom: 15px; font-weight: bold; font-family: 'Oswald', sans-serif;">
            ${isClosed ? 'LAUNCHING SOON' : 'Server Maintenance'}
        </h2>
        <p style="color: #ccc; font-size: 16px; line-height: 1.6; margin-bottom: 30px; font-family: 'Inter', sans-serif;">
            ${isClosed ? 'Our server is currently in the final stages of development.<br>The official launch countdown has begun!' : 'The server is currently undergoing maintenance.<br>Please check back later or join our Discord for updates.'}
        </p>
        <button id="closeMaintenanceBtn" style="background: ${isClosed ? '#88DA22' : '#ff6b6b'}; color: #000; border: none; padding: 12px 30px; font-size: 16px; font-weight: bold; border-radius: 6px; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;">UNDERSTOOD</button>
    `;

    overlay.appendChild(notification);
    document.body.appendChild(overlay);

    const btn = document.getElementById('closeMaintenanceBtn');
    btn.addEventListener('click', () => overlay.remove());
    overlay.addEventListener('click', (e) => { if (e.target === overlay) overlay.remove(); });
}

// Anti-Theft / DevTools Trap
// Note: This is an extra layer of protection
(function () {
    let devtools = function () { };
    devtools.toString = function () {
        if (!window.SERVER_OPEN) {
            console.warn("%cSTOP! ACCESS DENIED.", "color: red; font-size: 40px; font-weight: bold; -webkit-text-stroke: 1px black;");
            console.log("Elite Roleplay Protection Active.");
        }
        return '';
    }
    // console.log(devtools); // Triggers if console is open
})();

// Open Queue Dashboard (with server offline check)
function openQueueDashboard(event) {
    if (event) event.preventDefault();

    if (window.SERVER_OPEN === false) {
        showMaintenanceNotification();
        return false;
    }

    if (!serverOnline || (document.getElementById('playNowBtn')?.getAttribute('data-offline') === 'true')) {
        showMaintenanceNotification();
        return false;
    }

    console.log('Opening queue dashboard...');
    return false;
}

// Smooth Scroll for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth'
            });
            // Close mobile menu if open
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                hamburger.querySelector('i').classList.add('fa-bars');
                hamburger.querySelector('i').classList.remove('fa-times');
            }
        }
    });
});

// Intersection Observer for Scroll Animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target); // Only animate once
        }
    });
}, observerOptions);

const animatedElements = document.querySelectorAll('.fade-in, .fade-in-up, .fade-in-left');
animatedElements.forEach(el => observer.observe(el));

// Optional: Dynamic Title Glitch Interval Randomizer
const glitchTitle = document.querySelector('.glitch');
if (glitchTitle) {
    setInterval(() => {
        // Randomly trigger specific glitch classes or logic if we wanted more complex glitches
        // For now CSS handles the infinite loop
    }, 5000);
}

// Form Submission Logic
const whitelistForm = document.getElementById('whitelistForm');



if (whitelistForm) {
    whitelistForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = whitelistForm.querySelector('button');
        const btnText = whitelistForm.querySelector('.app-submit-text');
        const loader = whitelistForm.querySelector('.loader');
        const status = document.getElementById('formStatus');

        // UI Loading State
        btn.disabled = true;
        btnText.style.display = 'none';
        loader.style.display = 'block';
        status.textContent = '';
        status.className = 'form-status';

        // Gather Data
        const formData = {
            discordName: document.getElementById('discordName').value,
            charName: document.getElementById('charName').value,
            age: document.getElementById('age').value,
            story: document.getElementById('story').value,
            source: document.getElementById('source').value
        };

        // Validation (Character Count)
        const charCount = formData.story.trim().length;
        if (charCount < 50) { // Check for 50 characters, not words. ~10 words approx.
            status.textContent = `Backstory is too short (${charCount} characters). Please provide at least 50 characters.`;
            status.classList.add('status-error');
            resetBtn();
            return;
        }

        // Construct Discord Embed Payload
        const payload = {
            username: "Elite RP Application Bot",
            avatar_url: "https://i.imgur.com/4M34hi2.png", // Optional: Replace with your logo URL
            embeds: [
                {
                    title: "New Whitelist Application",
                    color: 8968738, // #88DA22 (Green)
                    fields: [
                        { name: "Discord Name", value: formData.discordName, inline: true },
                        { name: "Character Name", value: formData.charName, inline: true },
                        { name: "OOC Age", value: formData.age, inline: true },
                        { name: "How did you find us?", value: formData.source, inline: true },
                        { name: "Backstory", value: formData.story }
                    ],
                    footer: {
                        text: "Submitted via Elite Roleplay Website",
                    },
                    timestamp: new Date().toISOString()
                }
            ]
        };

        try {
            const response = await fetch(DISCORD_WEBHOOK_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                status.textContent = 'APPLICATION SUBMITTED SUCCESSFULLY!';
                status.style.color = 'var(--accent-green)';
                whitelistForm.reset();
            } else {
                throw new Error('Discord API Error');
            }
        } catch (error) {
            console.error(error);
            status.textContent = 'FAILED TO SUBMIT. PLEASE TRY AGAIN.';
            status.style.color = '#ff3333';
        } finally {
            resetBtn();
        }

        function resetBtn() {
            btn.disabled = false;
            btnText.style.display = 'inline';
            loader.style.display = 'none';
        }
    });
}

/* --- QUEUE DASHBOARD LOGIC --- */

window.openQueueDashboard = function (e) {
    if (e) e.preventDefault();

    // Check if user is authenticated
    if (!userState.authenticated) {
        startLoginProcess();
        return;
    }

    // Check if user is whitelisted
    if (!userState.whitelisted) {
        startLoginProcess();
        if (authStatus) {
            authStatus.textContent = "ACCESS DENIED: NOT WHITELISTED";
            authStatus.style.color = "#ff3333";
        }
        return;
    }

    console.log('Opening elite dashboard...');
    const overlay = document.getElementById('queueOverlay');
    if (overlay) {
        overlay.classList.remove('hidden');

        // Show Home view first
        switchView('home');

        // Update user name in dashboard
        const nameDisplay = document.querySelector('.user-name-display');
        if (nameDisplay) {
            nameDisplay.textContent = userState.steam?.personaname || 'Player';
        }

        // Fetch real player count when opening
        fetchServerStatus();
    } else {
        console.error('Queue overlay not found!');
    }
};

const queueOverlay = document.getElementById('queueOverlay');
const btnClose = document.getElementById('closeQueue');
const views = {
    home: document.getElementById('viewHome'),
    servers: document.getElementById('viewServers'),
    queue: document.getElementById('viewQueue'),
    ready: document.getElementById('viewReady'),
    connected: document.getElementById('viewConnected')
};

// Initialize notifySound (declared globally at top of file)
notifySound = new Audio('assets/sounds/notify.mp3');

// Constants for Sounds and Music
// Note: User must add these files to assets/music/ and assets/sounds/
// --- WAITING QUEUE LOGIC ---
let queuePollInterval = null;
let acceptTimer = null;

if (btnClose) {
    btnClose.addEventListener('click', () => {
        closeQueueDashboard();
    });
}

// Close queue dashboard function
function closeQueueDashboard() {
    leaveQueue();
    if (queueOverlay) queueOverlay.classList.add('hidden');
    if (bgMusic) bgMusic.pause();
}

// Copy Server IP to clipboard
window.copyServerIP = function (event) {
    event.stopPropagation(); // Prevent server card click
    const serverIP = 'elite.serverloom.com';

    navigator.clipboard.writeText(serverIP).then(() => {
        const btn = event.currentTarget;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        btn.style.background = 'var(--accent-green)';

        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.background = '';
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy IP:', err);
        alert('Failed to copy IP. Please copy manually: elite.serverloom.com');
    });
};

// Join Queue (Override Server Selection)
window.selectServer = async function (type) {
    console.log("Server selection triggered:", type);

    // 1. Pre-check Auth & Whitelist
    if (!userState.authenticated) {
        alert("You must be logged in to join the queue.");
        startLoginProcess();
        return;
    }

    if (!userState.whitelisted) {
        console.warn("User is not whitelisted:", userState.steam?.personaname);
        alert("ACCESS DENIED: Your account is not whitelisted for Elite Roleplay.");
        return;
    }

    // 2. UI Feedback
    const btn = document.getElementById('mainServerCard');
    if (btn) {
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.style.opacity = '0.7';
    }

    // 3. Call Join API
    try {
        const res = await fetch(API_BASE + 'queue/join.php');
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);

        const data = await res.json();
        console.log("Queue Join Result:", data);

        if (data.status === 'joined' || data.status === 'already_in_queue') {
            startQueuePolling();
        } else {
            alert("Could not join queue: " + (data.error || "Unknown Error"));
        }
    } catch (e) {
        console.error("Queue Join Error:", e);
        alert("Server Error: Failed to connect to the queue system. Please try again later.");
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.style.opacity = '1';
        }
    }
};

function startQueuePolling() {
    console.log("Starting queue polling...");
    if (!views.queue) {
        console.error("Queue view element missing! Check index.php for id='viewQueue'");
        alert("System Error: Graphical elements for the queue are missing.");
        return;
    }

    switchView('queue');
    const queueTitle = document.getElementById('queueTitle');
    const queuePos = document.getElementById('queuePos');
    const queueTime = document.getElementById('queueTime');

    queueTitle.textContent = "Elite RP Main - Queue";
    queuePos.textContent = "Checking...";

    // Track local queue time
    let queueSeconds = 0;
    queueTime.textContent = "00:00";

    // Start local timer for queue time display
    let queueTimeInterval = setInterval(() => {
        queueSeconds++;
        const mins = Math.floor(queueSeconds / 60).toString().padStart(2, '0');
        const secs = (queueSeconds % 60).toString().padStart(2, '0');
        queueTime.textContent = `${mins}:${secs}`;
    }, 1000);

    // Auto-play a random track at volume 0.2 when joining queue
    currentTrackIndex = Math.floor(Math.random() * tracks.length);
    playTrack(currentTrackIndex);

    // Poll every 2 seconds
    if (queuePollInterval) clearInterval(queuePollInterval);

    // Initial Poll
    pollQueue();
    queuePollInterval = setInterval(pollQueue, 2000);

    // Store timer interval for cleanup
    window.queueTimeInterval = queueTimeInterval;

    // Enable tab-close warning
    window.isInQueue = true;
}

let lastPollTime = Date.now();

async function pollQueue() {
    try {
        const res = await fetch(API_BASE + 'queue/status.php');
        const data = await res.json();

        // Update last poll timestamp
        lastPollTime = Date.now();
        updateLastUpdatedIndicator();

        if (data.in_queue) {
            const queuePos = document.getElementById('queuePos');
            if (queuePos) queuePos.textContent = data.position;

            if (data.status === 'ready') {
                clearInterval(queuePollInterval);
                startReadyPhase();
            }
        } else {
            // Kicked or error
            clearInterval(queuePollInterval);
            alert("You have been removed from the queue.");
            switchView('servers');
        }
    } catch (e) {
        console.error("Poll Error:", e);
    }
}

window.leaveQueue = async function () {
    if (queuePollInterval) clearInterval(queuePollInterval);
    if (acceptTimer) clearInterval(acceptTimer);
    if (window.queueTimeInterval) clearInterval(window.queueTimeInterval);

    // Stop notification
    if (notifySound) {
        notifySound.pause();
        notifySound.currentTime = 0;
    }

    // Disable tab-close warning
    window.isInQueue = false;

    // Call Leave API
    try {
        await fetch(API_BASE + 'queue/leave.php');
    } catch (e) { }

    switchView('home');
};

// Update 'Last Updated' indicator
function updateLastUpdatedIndicator() {
    const indicator = document.getElementById('lastUpdated');
    if (!indicator) return;

    const secondsAgo = Math.floor((Date.now() - lastPollTime) / 1000);
    indicator.textContent = secondsAgo === 0 ? 'Just now' : `${secondsAgo}s ago`;
}

// Update indicator every second
setInterval(() => {
    if (window.isInQueue) {
        updateLastUpdatedIndicator();
    }
}, 1000);



function startReadyPhase() {
    switchView('ready');

    // Notify
    if (notifySound) {
        notifySound.volume = 0.5;
        notifySound.play().catch(() => { });
    }

    const timerDisplay = document.querySelector('.accept-timer');
    let timeLeft = 120; // 2 minutes

    timerDisplay.textContent = "02:00";

    if (acceptTimer) clearInterval(acceptTimer);
    acceptTimer = setInterval(() => {
        timeLeft--;
        const mins = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        const secs = (timeLeft % 60).toString().padStart(2, '0');
        timerDisplay.textContent = `${mins}:${secs}`;

        if (timeLeft <= 0) {
            leaveQueue(); // Missed the window
        }
    }, 1000);
}

window.confirmJoin = function () {
    if (acceptTimer) clearInterval(acceptTimer);

    // Stop notification
    if (notifySound) {
        notifySound.pause();
        notifySound.currentTime = 0;
    }

    const btn = document.querySelector('.btn-confirm');
    const title = document.querySelector('.ready-title');

    if (btn) btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> LAUNCHING...';
    if (title) {
        title.textContent = "OPENING FIVEM...";
        title.style.color = "#00ff88";
    }

    // Launch FiveM
    window.location.href = "fivem://connect/eliterp.serverloom.com";

    // Tell backend we connected (clean up queue)
    fetch(API_BASE + 'queue/leave.php');

    setTimeout(() => {
        queueOverlay.classList.add('hidden');
        if (btn) btn.innerHTML = 'Confirm';
        switchView('servers');
    }, 5000);
};

// Prodigy Music Logic (Album Wrapper Click)
// Album wrapper is now decorative — play/pause handled by dedicated button

const muteBtnElement = document.getElementById('muteBtn');
if (muteBtnElement && bgMusic) {
    muteBtnElement.addEventListener('click', () => {
        bgMusic.muted = !bgMusic.muted;
        muteBtnElement.className = bgMusic.muted ? 'fas fa-volume-mute' : 'fas fa-volume-up';

        // Update volume bar visually if muted
        const fill = document.querySelector('.volume-fill');
        const handle = document.querySelector('.volume-handle');
        if (bgMusic.muted) {
            if (fill) fill.style.width = '0%';
            if (handle) handle.style.left = '0%';
        } else {
            const percent = bgMusic.volume * 100;
            if (fill) fill.style.width = percent + '%';
            if (handle) handle.style.left = percent + '%';
        }

        // Save preference
        saveVolumePreferences();
    });
}

// Custom Volume Slider Logic (Improved with Dragging)
const volTrack = document.getElementById('volTrack');
let isDraggingVolume = false;

function updateVolume(e) {
    if (!volTrack || !bgMusic) return;
    const rect = volTrack.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const width = rect.width;
    let percent = x / width;

    // Clamp
    percent = Math.max(0, Math.min(1, percent));
    bgMusic.volume = percent;
    bgMusic.muted = false; // Unmute when adjusting volume

    // Save preference
    saveVolumePreferences();

    // Update UI
    const fill = volTrack.querySelector('.volume-fill');
    const handle = volTrack.querySelector('.volume-handle');
    const muteIcon = document.getElementById('muteBtn');

    if (fill) fill.style.width = (percent * 100) + '%';
    if (handle) handle.style.left = (percent * 100) + '%';
    if (muteIcon) muteIcon.className = percent === 0 ? 'fas fa-volume-mute' : 'fas fa-volume-up';
}

if (volTrack) {
    volTrack.addEventListener('mousedown', (e) => {
        isDraggingVolume = true;
        updateVolume(e);
    });

    document.addEventListener('mousemove', (e) => {
        if (isDraggingVolume) updateVolume(e);
    });

    document.addEventListener('mouseup', () => {
        isDraggingVolume = false;
    });

    // Support for direct clicking
    volTrack.addEventListener('click', updateVolume);
}

// --- SERVER RELEASE COUNTDOWN ---
function updateCountdown() {
    const dEl = document.getElementById("days");
    const hEl = document.getElementById("hours");
    const mEl = document.getElementById("minutes");
    const sEl = document.getElementById("seconds");
    const statusLabel = document.querySelector('.countdown-status');

    if (!dEl) return;

    const releaseDate = new Date('April 3, 2026 20:00:00').getTime();
    const now = new Date().getTime();
    const distance = releaseDate - now;

    // Handle Live State
    if (distance < 0) {
        const el = document.getElementById("releaseCountdown");
        if (el) {
            el.innerHTML = "SYSTEM INITIALIZED";
            el.style.color = "var(--accent-green)";
        }
        if (statusLabel) statusLabel.style.display = 'none';

        // Unlock the button automatically if it's still locked
        const heroButtons = document.querySelector('.hero-buttons');
        const disabledBtn = heroButtons?.querySelector('.btn-disabled');
        if (disabledBtn) {
            const playBtn = document.createElement('a');
            playBtn.href = '#';
            playBtn.className = 'btn btn-primary';
            playBtn.id = 'playNowBtn';
            playBtn.innerHTML = '<i class="fas fa-play"></i> PLAY NOW';
            playBtn.onclick = (e) => openQueueDashboard(e);
            disabledBtn.parentNode.replaceChild(playBtn, disabledBtn);
        }
        return;
    }

    if (window.HIDE_COUNTDOWN) {
        // --- TRICK MODE: Show glitches ---
        if (statusLabel) statusLabel.style.display = 'block';

        const glitchChars = "0123456789$#@%&?";
        dEl.innerText = "??";
        hEl.innerText = "XX";
        mEl.innerText = "??";

        if (sEl) {
            let char1 = glitchChars.charAt(Math.floor(Math.random() * glitchChars.length));
            let char2 = glitchChars.charAt(Math.floor(Math.random() * glitchChars.length));
            sEl.innerText = char1 + char2;
        }

        const labels = document.querySelectorAll('.time-block small');
        labels.forEach(label => {
            if (!label.getAttribute('data-original')) {
                label.setAttribute('data-original', label.innerText);
            }
            if (Math.random() > 0.95) {
                label.innerText = "SYNC";
            } else {
                label.innerText = label.getAttribute('data-original');
            }
        });
    } else {
        // --- NORMAL MODE: Show real time ---
        if (statusLabel) statusLabel.style.display = 'none';

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        dEl.innerText = days;
        hEl.innerText = hours < 10 ? "0" + hours : hours;
        mEl.innerText = minutes < 10 ? "0" + minutes : minutes;
        sEl.innerText = seconds < 10 ? "0" + seconds : seconds;

        // Ensure labels are correct
        document.querySelectorAll('.time-block small').forEach(label => {
            if (label.getAttribute('data-original')) {
                label.innerText = label.getAttribute('data-original');
            }
        });
    }
}

// Run immediately and interval
setInterval(updateCountdown, 1000);
updateCountdown();


function switchView(viewName) {
    Object.values(views).forEach(el => el.classList.remove('active'));
    if (views[viewName]) views[viewName].classList.add('active');
}

// FETCH SERVER DATA
async function fetchServerStatus() {
    // Targets
    const heroCount = document.getElementById('heroPlayerCount');
    const heroPing = document.getElementById('heroLatency');
    const queueCount = document.getElementById('serverPlayerCount');
    const statusDot = document.getElementById('serverStatusDot');
    const serverCard = document.getElementById('mainServerCard');
    const playNowBtn = document.getElementById('playNowBtn');

    try {
        const response = await fetch('api/server_status.php');
        const data = await response.json();

        // Format: "12/64"
        const countText = data.error ? "Offline" : `${data.players}/${data.max_players}`;
        const color = data.error ? '#ff3333' : '#fff'; // Red if offline
        const isOffline = data.error || data.players === 0;

        // Update Hero Section
        if (heroCount) {
            heroCount.textContent = countText;
            heroCount.style.color = color;
        }
        if (heroPing) {
            heroPing.textContent = (data.error || !data.latency) ? "--ms" : `${data.latency}ms`;
        }

        // Update Queue Dashboard
        if (queueCount) {
            queueCount.textContent = countText;
            queueCount.style.color = color;
        }

        // Update Server Card Status
        if (statusDot) {
            if (isOffline) {
                statusDot.classList.remove('online');
                statusDot.classList.add('offline');
            } else {
                statusDot.classList.remove('offline');
                statusDot.classList.add('online');
            }
        }

        // Disable/Enable Server Card
        // FORCE ENABLED: Ignore offline status so user can always click
        if (serverCard) {
            serverCard.disabled = false;
            serverCard.style.opacity = '1';
            serverCard.style.cursor = 'pointer';
            // Only set red border if you really want to warn, but user asked to fix "red and disabled"
            serverCard.style.borderColor = '';
        }

        // Update Dashboard Player Count
        const dashCount = document.getElementById('dashPlayerCount');
        if (dashCount) dashCount.textContent = countText;

        // Disable/Enable PLAY NOW Button
        // Always enable for user convenience/testing
        if (playNowBtn) {
            playNowBtn.style.pointerEvents = 'auto';
            playNowBtn.style.opacity = '1';
            playNowBtn.style.cursor = 'pointer';
            playNowBtn.style.filter = 'none';
        }

    } catch (e) {
        console.error("Server Fetch Error:", e);
        if (heroCount) heroCount.textContent = "Offline";
        if (queueCount) queueCount.textContent = "Error";

        // Set offline state on error
        if (statusDot) {
            statusDot.classList.remove('online');
            statusDot.classList.add('offline');
        }
        if (serverCard) {
            // Keep enabled even on error
            serverCard.disabled = false;
            serverCard.style.opacity = '1';
            serverCard.style.cursor = 'pointer';
            serverCard.style.borderColor = '';
        }
        if (playNowBtn) {
            // Keep enabled even on API error so user can open dashboard
            playNowBtn.style.pointerEvents = 'auto';
            playNowBtn.style.opacity = '1';
            playNowBtn.style.cursor = 'pointer';
            playNowBtn.style.filter = 'none';
        }
    }
}

// Run immediately on load
fetchServerStatus();
// And refresh every 30 seconds
setInterval(fetchServerStatus, 30000);

// Note: window.selectServer is already defined earlier in the file (line ~299)
// This duplicate definition has been removed to prevent conflicts with the real queue system

// --- DYNAMIC BACKGROUND PARALLAX ---
document.addEventListener('mousemove', (e) => {
    const bg = document.querySelector('.bg-pattern');
    if (!bg) return;

    // Calculate mouse position relative to center (range -1 to 1)
    const x = (e.clientX / window.innerWidth) - 0.5;
    const y = (e.clientY / window.innerHeight) - 0.5;

    // Move background opposite to mouse
    const moveX = x * -50;
    const moveY = y * -50;

    bg.style.transform = `translate(${moveX}px, ${moveY}px)`;
});


// --- AUTHENTICATION LOGIC ---

// State
// --- REAL AUTHENTICATION LOGIC ---

// State is now managed at the top of file via 'userState' variable

const loginModal = document.getElementById('loginModal');
const authStatus = document.getElementById('authStatus');

window.startLoginProcess = function () {
    if (loginModal) {
        loginModal.classList.remove('hidden');
        // Do NOT reset completely if we are in step 2 (URL check handles this) but basic reset if fresh open
        if (!window.location.search.includes('login_step=2')) {
            resetAuthFlow();
        }
    }
};

window.closeLoginModal = function () {
    if (loginModal) loginModal.classList.add('hidden');
}

function resetAuthFlow() {
    document.getElementById('stepSteam').classList.add('active');
    document.getElementById('stepSteam').classList.remove('completed');
    document.getElementById('stepDiscord').classList.remove('active', 'completed');
    document.getElementById('stepDiscord').classList.add('disabled');
    document.getElementById('btnDiscordAuth').disabled = true;
    if (authStatus) authStatus.textContent = '';
}

// REAL Steam Login
window.startSteamLogin = function () {
    const btn = document.querySelector('.btn-steam');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> REDIRECTING...';
    window.location.href = API_BASE + 'auth/steam_login.php';
};

// REAL Discord Login
window.startDiscordLogin = function () {
    const btn = document.getElementById('btnDiscordAuth');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> REDIRECTING...';
    window.location.href = API_BASE + 'auth/discord_login.php';
};

function updateNavbarUser() {
    const container = document.getElementById('userAuthDisplay');
    if (container && userState.authenticated) {
        const avatar = userState.steam?.avatar || 'assets/avatar.png';
        const name = userState.steam?.personaname || 'Player';

        container.innerHTML = `
            <div class="user-profile" onclick="toggleUserDropdown(event)">
                <img src="${avatar}" alt="Avatar" class="user-avatar">
                <span class="user-name">${name}</span>
                <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: #666;"></i>
                
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-header">${name}</div>
                    <a href="api/auth/logout.php" class="dropdown-item logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        `;

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('userDropdown');
            const profile = document.querySelector('.user-profile');
            if (dropdown && profile && !profile.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    }
}

window.toggleUserDropdown = function (e) {
    e.stopPropagation();
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
};



// Gated access to queue
const originalOpenQueue = window.openQueueDashboard;

// --- MUSIC SYSTEM ---
let currentTrackIndex = 0;

const tracks = [
    { name: "GTA San Andreas", artist: "Michael Hunter", src: "assets/music/gta-sa.mp3" },
    { name: "The Last of Us", artist: "Gustavo Santaolalla", src: "assets/music/last-of-us.mp3" },
    { name: "Silo Main Title", artist: "Atli Örvarsson", src: "assets/music/silo.mp3" }
];

window.playTrack = function (index) {
    const track = tracks[index];
    if (!track || !bgMusic) return;
    currentTrackIndex = index;
    bgMusic.src = track.src;
    bgMusic.play().then(() => {
        const musicIcon = document.getElementById('playIcon');
        if (musicIcon) musicIcon.className = 'fas fa-pause';
        const nameEl = document.getElementById('currentTrackName');
        const artistEl = document.getElementById('currentArtistName');
        if (nameEl) nameEl.textContent = track.name;
        if (artistEl) artistEl.textContent = track.artist;
    }).catch(e => console.log('Track play error:', e));
};

window.nextTrack = function () {
    currentTrackIndex = (currentTrackIndex + 1) % tracks.length;
    window.playTrack(currentTrackIndex);
};

window.prevTrack = function () {
    currentTrackIndex = (currentTrackIndex - 1 + tracks.length) % tracks.length;
    window.playTrack(currentTrackIndex);
};

window.togglePlayPause = function () {
    if (!bgMusic) return;
    const musicIcon = document.getElementById('playIcon');
    if (bgMusic.paused) {
        bgMusic.play().then(() => {
            if (musicIcon) musicIcon.className = 'fas fa-pause';
        }).catch(e => console.log('Play error:', e));
    } else {
        bgMusic.pause();
        if (musicIcon) musicIcon.className = 'fas fa-play';
    }
};

// Update Start Ready Phase to 2 Minutes (120s)
// We need to override the window.selectServer logic or the timer logic inside it.
// Since selectServer is defined in global scope in previous code, let's redefine it slightly to fix the timer.
// Actually, creating a new function that overwrites it is better.

// Old mock queue timers removed.
// Logic is now handled by startQueuePolling and pollQueue.

