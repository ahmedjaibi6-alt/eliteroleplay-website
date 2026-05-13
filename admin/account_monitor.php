<?php
/**
 * Elite RP - Ultimate Admin Dashboard
 * Manage applications, players, and server security
 */

require_once '../config.php';

// --- AUTHENTICATION ---
// Use environment variable or fallback to a default (should be changed in .env)
$adminPassword = env('ADMIN_PASSWORD', 'admin123'); 

if (!isset($_SESSION['admin_authenticated'])) {
    if (isset($_POST['admin_password']) && $_POST['admin_password'] === $adminPassword) {
        $_SESSION['admin_authenticated'] = true;
        header("Location: account_monitor.php");
        exit;
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Login | Elite RP</title>
            <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                :root { --primary: #88DA22; --bg: #0D0D0D; --card: #161616; --text: #FFFFFF; }
                body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; justify-content: center; align-items: center; height: 100vh; }
                .login-card { background: var(--card); padding: 40px; border-radius: 12px; border: 1px solid #333; width: 100%; max-width: 400px; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
                h1 { font-family: 'Oswald', sans-serif; color: var(--primary); margin-bottom: 30px; }
                input { width: 100%; padding: 12px; margin-bottom: 20px; background: #080808; border: 1px solid #333; border-radius: 6px; color: #fff; box-sizing: border-box; }
                button { width: 100%; padding: 12px; background: var(--primary); border: none; border-radius: 6px; color: #000; font-weight: bold; cursor: pointer; transition: 0.3s; }
                button:hover { filter: brightness(1.2); transform: translateY(-2px); }
                .error { color: #ff3333; margin-bottom: 15px; font-size: 0.9rem; }
            </style>
        </head>
        <body>
            <div class="login-card">
                <h1>ELITE <span style="color:#fff">ADMIN</span></h1>
                <?php if (isset($_POST['admin_password'])): ?>
                    <p class="error">Invalid password</p>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="password" name="admin_password" placeholder="Enter Admin Password" required autofocus>
                    <button type="submit"><i class="fas fa-lock"></i> ACCESS DASHBOARD</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// --- LOGOUT ---
if (isset($_GET['logout'])) {
    unset($_SESSION['admin_authenticated']);
    header("Location: account_monitor.php");
    exit;
}

// --- DATABASE CONNECTION ---
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// --- CSRF PROTECTION ---
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verifyCSRF() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            http_response_code(403);
            die("Error: Security Token (CSRF) Invalid or Expired. Please refresh the page.");
        }
    }
}

// Helper to check if a table exists
function tableExists($conn, $table) {
    if ($result = $conn->query("SHOW TABLES LIKE '".$table."'")) {
        return $result->num_rows > 0;
    }
    return false;
}

$hasApplicationsTable = tableExists($conn, 'applications');

// --- ACTION HANDLING ---
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    verifyCSRF();
    if ($_POST['action'] === 'approve_app' && $hasApplicationsTable) {
        $id = intval($_POST['app_id']);
        $discord_name = $_POST['discord_name'] ?? '';
        
        $conn->query("UPDATE applications SET status = 'approved', reviewed_at = NOW() WHERE id = $id");
        
        // Attempt to auto-whitelist if user exists
        if (!empty($discord_name)) {
            $checkUser = $conn->prepare("SELECT id FROM users WHERE discord_name = ? OR username = ?");
            $checkUser->bind_param("ss", $discord_name, $discord_name);
            $checkUser->execute();
            $res = $checkUser->get_result();
            
            if ($res && $row = $res->fetch_assoc()) {
                $uid = $row['id'];
                $conn->query("UPDATE users SET is_whitelisted = 1 WHERE id = $uid");
                $message = "Application Approved! User '" . htmlspecialchars($discord_name) . "' has been automatically whitelisted.";
            } else {
                $message = "Application Approved! Note: User '" . htmlspecialchars($discord_name) . "' was not found in the player database yet. They will need to login to the site first for auto-whitelist, or you can manually whitelist them later.";
            }
        } else {
            $message = "Application Approved!";
        }
    }
    
    if ($_POST['action'] === 'reject_app' && $hasApplicationsTable) {
        $id = intval($_POST['app_id']);
        $conn->query("UPDATE applications SET status = 'rejected', reviewed_at = NOW() WHERE id = $id");
        $message = "Application marked as Rejected.";
    }
    
    if ($_POST['action'] === 'toggle_whitelist') {
        $user_id = intval($_POST['user_id']);
        $status = intval($_POST['status']);
        $conn->query("UPDATE users SET is_whitelisted = $status WHERE id = $user_id");
        $message = "User whitelist status updated.";
    }
}

// --- DATA FETCHING ---
$tab = $_GET['tab'] ?? 'dashboard';

// Stats
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$whitelistedUsers = $conn->query("SELECT COUNT(*) FROM users WHERE is_whitelisted = 1")->fetch_row()[0];
$pendingApps = $hasApplicationsTable ? $conn->query("SELECT COUNT(*) FROM applications WHERE status = 'pending'")->fetch_row()[0] : 0;

// Applications
$applications = $hasApplicationsTable ? $conn->query("SELECT * FROM applications ORDER BY submitted_at DESC LIMIT 50") : null;

// Players
$players = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 100");

// Security - Duplicate Discord
$duplicateDiscord = $conn->query("SELECT discord_id, GROUP_CONCAT(steam_id SEPARATOR ' | ') as steam_ids, COUNT(*) as count FROM users WHERE discord_id IS NOT NULL GROUP BY discord_id HAVING count > 1");

// Security - Duplicate Steam
$duplicateSteam = $conn->query("SELECT steam_id, GROUP_CONCAT(discord_id SEPARATOR ' | ') as discord_ids, COUNT(*) as count FROM users WHERE steam_id IS NOT NULL GROUP BY steam_id HAVING count > 1");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite RP | Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #88DA22; --bg: #0A0A0A; --sidebar: #111; --card: #161616; --border: #222; --text: #eee; --muted: #888; }
        body { margin: 0; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; height: 100vh; overflow: hidden; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar); border-right: 1px solid var(--border); display: flex; flex-direction: column; padding: 20px 0; }
        .sidebar-header { padding: 0 25px 30px; border-bottom: 1px solid var(--border); margin-bottom: 20px; }
        .sidebar-header h2 { font-family: 'Oswald', sans-serif; color: var(--primary); margin: 0; font-size: 1.5rem; letter-spacing: 1px; }
        .nav-link { padding: 15px 25px; color: var(--muted); text-decoration: none; display: flex; align-items: center; gap: 12px; transition: 0.3s; border-left: 3px solid transparent; }
        .nav-link:hover { background: #1a1a1a; color: #fff; }
        .nav-link.active { background: rgba(136, 218, 34, 0.05); color: var(--primary); border-left-color: var(--primary); }
        .nav-link i { font-size: 1.1rem; width: 20px; }
        
        /* Content Area */
        .content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .top-bar { padding: 20px 40px; background: #0D0D0D; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .main-scroll { flex: 1; overflow-y: auto; padding: 40px; }
        
        /* Dashboard Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--card); padding: 25px; border-radius: 12px; border: 1px solid var(--border); }
        .stat-card .label { color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block; }
        .stat-card .val { font-size: 2rem; font-family: 'Oswald', sans-serif; color: #fff; }
        
        /* Tables */
        .table-container { background: var(--card); border-radius: 12px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 40px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #1a1a1a; padding: 15px 20px; color: var(--muted); font-size: 0.8rem; text-transform: uppercase; border-bottom: 1px solid var(--border); }
        td { padding: 15px 20px; border-bottom: 1px solid var(--border); font-size: 0.9rem; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background: #1a1a1a; }
        
        /* Badges & Buttons */
        .badge { padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .badge-pending { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .badge-approved { background: rgba(136, 218, 34, 0.1); color: var(--primary); }
        .badge-rejected { background: rgba(255, 68, 68, 0.1); color: #ff4444; }
        
        .btn-action { padding: 8px 15px; border-radius: 6px; border: 1px solid #333; background: #222; color: #fff; cursor: pointer; font-size: 0.8rem; transition: 0.2s; }
        .btn-action:hover { background: #333; }
        .btn-approve { border-color: var(--primary); color: var(--primary); }
        .btn-approve:hover { background: var(--primary); color: #000; }
        .btn-reject { border-color: #ff4444; color: #ff4444; }
        .btn-reject:hover { background: #ff4444; color: #fff; }
        
        .alert-toast { background: var(--primary); color: #000; padding: 10px 20px; border-radius: 6px; margin-bottom: 20px; font-weight: 600; display: inline-block; animation: slideDown 0.3s ease; }
        @keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        .logout-btn { color: #ff4444; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        
        /* Security Cards */
        .alert-box { background: rgba(255, 68, 68, 0.05); border: 1px solid rgba(255, 68, 68, 0.2); padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .alert-box h3 { color: #ff4444; margin-top: 0; margin-bottom: 10px; }
        
        .empty-state { padding: 40px; text-align: center; color: var(--muted); }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>ELITE <span style="color:#fff">ADMIN</span></h2>
        </div>
        <nav>
            <a href="?tab=dashboard" class="nav-link <?php echo $tab=='dashboard'?'active':''; ?>"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="?tab=applications" class="nav-link <?php echo $tab=='applications'?'active':''; ?>"><i class="fas fa-file-invoice"></i> Applications</a>
            <a href="?tab=players" class="nav-link <?php echo $tab=='players'?'active':''; ?>"><i class="fas fa-users"></i> Player List</a>
            <a href="?tab=security" class="nav-link <?php echo $tab=='security'?'active':''; ?>"><i class="fas fa-shield-halved"></i> Security Bindings</a>
        </nav>
        <div style="margin-top:auto; padding: 20px;">
            <a href="?logout=1" class="logout-btn"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="top-bar">
            <h1 style="font-family:'Oswald'; margin:0; font-size:1.4rem; text-transform:uppercase;"><?php echo ucfirst($tab); ?></h1>
            <div id="serverStatus" style="color:var(--primary); font-size:0.9rem; font-weight:600;"><i class="fas fa-circle"></i> LOADING STATUS...</div>
        </div>

        <div class="main-scroll">
            <?php if ($message): ?>
                <div class="alert-toast"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($tab === 'dashboard'): ?>
                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="label">Total Registered</span>
                        <span class="val"><?php echo $totalUsers; ?></span>
                    </div>
                    <div class="stat-card">
                        <span class="label">Whitelisted Players</span>
                        <span class="val"><?php echo $whitelistedUsers; ?></span>
                    </div>
                    <div class="stat-card">
                        <span class="label">Pending Apps</span>
                        <span class="val" style="color:#ffc107"><?php echo $pendingApps; ?></span>
                    </div>
                    <div class="stat-card">
                        <span class="label">Server Capacity</span>
                        <span class="val">128</span>
                    </div>
                </div>

                <h2>Recent Activity</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Steam ID</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $recentUsers = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 5");
                            while($row = $recentUsers->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if(!empty($row['avatar_url'])): ?>
                                        <img src="<?php echo $row['avatar_url']; ?>" style="width:24px; height:24px; border-radius:50%; margin-right:10px; vertical-align:middle;">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($row['username'] ?? 'Unknown'); ?>
                                </td>
                                <td><code><?php echo $row['steam_id']; ?></code></td>
                                <td><?php echo $row['is_whitelisted'] ? '<span class="badge badge-approved">Whitelisted</span>' : '<span class="badge badge-pending">Member</span>'; ?></td>
                                <td>
                                    <a href="?tab=players" class="btn-action">View All</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($tab === 'applications'): ?>
                <?php if (!$hasApplicationsTable): ?>
                    <div class="alert-box">
                        <h3 style="color:#ffc107">⚠️ Applications Table Missing</h3>
                        <p>The <code>applications</code> database table has not been created yet. Whitelist applications submitted via the form will not appear here until the table is set up.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Applicant</th>
                                    <th>Character</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($applications && $applications->num_rows > 0): ?>
                                    <?php while($row = $applications->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('M d, H:i', strtotime($row['submitted_at'])); ?></td>
                                        <td>
                                            <strong>D:</strong> <?php echo htmlspecialchars($row['discord_name']); ?><br>
                                            <small style="color:#666">ID: <?php echo htmlspecialchars($row['discord_id'] ?? 'N/A'); ?></small><br>
                                            <small>S: <?php echo htmlspecialchars($row['steam_name']); ?></small>
                                        </td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['character_name']); ?></strong><br>
                                            <small style="color:var(--primary)"><?php echo htmlspecialchars($row['char_ethnicity']); ?></small>
                                            <div style="margin-top:8px; font-size:0.85rem; color:var(--muted); max-width:400px;">
                                                <details>
                                                    <summary style="cursor:pointer; color:var(--primary)">View Details</summary>
                                                    <p style="margin:5px 0;"><strong>Objectives:</strong><br><?php echo nl2br(htmlspecialchars($row['char_objectives'])); ?></p>
                                                    <p style="margin:5px 0;"><strong>Backstory:</strong><br><?php echo nl2br(htmlspecialchars($row['char_backstory'])); ?></p>
                                                    <p style="margin:5px 0;"><strong>Why Join:</strong><br><?php echo nl2br(htmlspecialchars($row['reason'])); ?></p>
                                                    <p style="margin:5px 0;"><strong>Experience:</strong><br><?php echo nl2br(htmlspecialchars($row['experience'])); ?></p>
                                                </details>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="empty-state">No applications found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            <?php elseif ($tab === 'players'): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>IDs</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $players->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if(!empty($row['avatar_url'])): ?>
                                        <img src="<?php echo $row['avatar_url']; ?>" style="width:32px; height:32px; border-radius:50%; margin-right:10px; vertical-align:middle;">
                                    <?php endif; ?>
                                    <strong><?php echo htmlspecialchars($row['username'] ?? 'Unknown'); ?></strong>
                                </td>
                                <td>
                                    <small>S: <?php echo $row['steam_id']; ?></small><br>
                                    <small>D: <?php echo $row['discord_id'] ?: 'Not linked'; ?></small>
                                </td>
                                <td>
                                    <?php if ($row['is_whitelisted']): ?>
                                        <span class="badge badge-approved">Whitelisted</span>
                                    <?php else: ?>
                                        <span class="badge badge-pending">Member</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($tab === 'security'): ?>
                <div class="alert-box">
                    <h3>🛡️ Account Binding Monitor</h3>
                    <p>This tool detects if one Discord account is using multiple Steam accounts, or vice versa (Account Sharing). Below you can see active alerts and the master connection log.</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
                    <!-- Suspicious Sections -->
                    <div class="table-container">
                        <div style="padding: 15px; background: rgba(255,68,68,0.1); border-bottom: 1px solid var(--border);">
                            <h3 style="margin:0; color:#ff4444; font-size:1rem;"><i class="fas fa-exclamation-triangle"></i> Multiple Steam / Discord</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Discord ID</th>
                                    <th>Accounts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($duplicateDiscord && $duplicateDiscord->num_rows > 0): ?>
                                    <?php while($row = $duplicateDiscord->fetch_assoc()): ?>
                                    <tr style="background:rgba(255,68,68,0.05)">
                                        <td style="color:#ff4444"><?php echo htmlspecialchars($row['discord_id']); ?></td>
                                        <td><span class="badge badge-rejected"><?php echo $row['count']; ?> Steams</span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="2" class="empty-state">✅ No issues detected.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-container">
                        <div style="padding: 15px; background: rgba(255,68,68,0.1); border-bottom: 1px solid var(--border);">
                            <h3 style="margin:0; color:#ff4444; font-size:1rem;"><i class="fas fa-exclamation-triangle"></i> Multiple Discord / Steam</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Steam ID</th>
                                    <th>Accounts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($duplicateSteam && $duplicateSteam->num_rows > 0): ?>
                                    <?php while($row = $duplicateSteam->fetch_assoc()): ?>
                                    <tr style="background:rgba(255,68,68,0.05)">
                                        <td style="color:#ff4444"><?php echo htmlspecialchars($row['steam_id']); ?></td>
                                        <td><span class="badge badge-rejected"><?php echo $row['count']; ?> Discords</span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="2" class="empty-state">✅ No issues detected.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <h3>🔗 Master Connection Log (All Bindings)</h3>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Steam ID (Hex/64)</th>
                                <th>Discord Account</th>
                                <th>Security Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $allBindings = $conn->query("SELECT * FROM users WHERE steam_id IS NOT NULL OR discord_id IS NOT NULL ORDER BY id DESC");
                            if ($allBindings->num_rows > 0):
                                while($row = $allBindings->fetch_assoc()): 
                                    // Check if this specific player is part of a duplicate
                                    $isSuspect = false;
                                    if ($row['discord_id']) {
                                        $check = $conn->query("SELECT id FROM users WHERE discord_id = '" . $conn->real_escape_string($row['discord_id']) . "' AND id != " . $row['id']);
                                        if ($check->num_rows > 0) $isSuspect = true;
                                    }
                            ?>
                            <tr <?php echo $isSuspect ? 'style="background:rgba(255,68,68,0.08)"' : ''; ?>>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['username'] ?: 'Guest'); ?></strong>
                                </td>
                                <td><code><?php echo $row['steam_id']; ?></code></td>
                                <td>
                                    <span style="color:var(--muted)">D:</span> <?php echo $row['discord_id'] ?: '<span style="color:#ff4444">Not Linked</span>'; ?><br>
                                    <small><?php echo htmlspecialchars($row['discord_name'] ?: ''); ?></small>
                                </td>
                                <td>
                                    <?php if ($isSuspect): ?>
                                        <span class="badge badge-rejected"><i class="fas fa-user-slash"></i> FLAG: Multi-Steam</span>
                                    <?php elseif (!$row['discord_id']): ?>
                                        <span class="badge badge-pending">Binding Incomplete</span>
                                    <?php else: ?>
                                        <span class="badge badge-approved"><i class="fas fa-check-shield"></i> Valid Link</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; 
                            else: ?>
                                <tr><td colspan="4" class="empty-state">No connection data found in database.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Simple server status poll for admin top bar
        async function updateStatus() {
            try {
                const res = await fetch('../api/server_status.php');
                const data = await res.json();
                const el = document.getElementById('serverStatus');
                if (data.online) {
                    el.innerHTML = `<i class="fas fa-circle" style="color:#88DA22"></i> ${data.players}/${data.max_players} PLAYERS`;
                } else {
                    el.innerHTML = `<i class="fas fa-circle" style="color:#ff4444"></i> SERVER OFFLINE`;
                }
            } catch (e) {
                document.getElementById('serverStatus').innerHTML = `<i class="fas fa-circle" style="color:#ff4444"></i> OFFLINE/ERROR`;
            }
        }
        setInterval(updateStatus, 15000);
        updateStatus();
    </script>
</body>
</html>
<?php
$conn->close();
?>
