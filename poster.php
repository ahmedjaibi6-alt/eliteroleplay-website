<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Store Poster</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --accent: #88DA22;
            --bg: #050505;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .poster {
            width: 1080px;
            height: 1350px;
            background: var(--bg);
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(136, 218, 34, 0.1);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 100px rgba(0,0,0,0.5);
        }
        .bg-glow {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(136, 218, 34, 0.1) 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        .content {
            z-index: 10;
            text-align: center;
            padding: 80px;
        }
        .tagline {
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 10px;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .main-title {
            font-family: 'Oswald', sans-serif;
            font-size: 120px;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 40px;
            text-shadow: 0 0 50px rgba(136, 218, 34, 0.3);
        }
        .main-title span {
            color: var(--accent);
        }
        .business-list {
            display: flex;
            gap: 30px;
            justify-content: center;
            margin: 60px 0;
            flex-wrap: wrap;
        }
        .biz-item {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 20px 40px;
            border-radius: 50px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .biz-item i { color: var(--accent); }
        .footer-cta {
            margin-top: 80px;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 40px;
            width: 100%;
        }
        .cta-text {
            font-size: 1.8rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }
        .link {
            font-family: 'Oswald', sans-serif;
            color: var(--accent);
            font-size: 2.5rem;
            text-decoration: none;
        }
        .brand {
            position: absolute;
            bottom: 40px;
            display: flex;
            align-items: center;
            gap: 15px;
            opacity: 0.5;
        }
        .brand img { width: 50px; border-radius: 50%; }
    </style>
</head>
<body>
    <div class="poster">
        <div class="bg-glow"></div>
        <div class="content">
            <p class="tagline">Now Accepting Inquiries</p>
            <h1 class="main-title">ELITE <span>STORE</span></h1>
            
            <div class="business-list">
                <div class="biz-item"><i class="fas fa-palace"></i> Pearls Resort</div>
                <div class="biz-item"><i class="fas fa-car-side"></i> PDM Showroom</div>
                <div class="biz-item"><i class="fas fa-glass-martini-alt"></i> Nightclubs</div>
            </div>

            <div class="footer-cta">
                <p class="cta-text">Visit the official catalog</p>
                <p class="link">ELITERP-STORE.COM</p>
            </div>
        </div>

        <div class="brand">
            <img src="assets/logo.jpg" alt="Elite Logo">
            <p>ELITE ROLEPLAY 2024</p>
        </div>
    </div>
</body>
</html>
