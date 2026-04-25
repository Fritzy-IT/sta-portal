<?php
session_start();

// MOCK LOGIN LOGIC (No Database muna)
$login_error = "";
if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    
    // admin / password123
    if ($username === "admin" && $password === "password123") {
        $_SESSION['logged_in'] = true;
        echo "<script>alert('Login Success!'); window.location.href='/';</script>";
        exit();
    } else {
        $login_error = "Invalid credentials. Hint: admin / password123";
    }
}

$view = $_GET['portal'] ?? 'intro';
$platform = $_GET['platform'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STA | Sievers Tech Activities</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --p: #6c5ce7; --s: #00b894; --text: #2d3436; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(-45deg, #e3f2fd, #f3e5f5, #e8f5e9); display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .glass { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(20px); border-radius: 30px; padding: 40px; width: 90%; max-width: 450px; text-align: center; border: 1px solid rgba(255,255,255,0.5); box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
        .btn { background: white; padding: 15px; border-radius: 12px; display: block; margin: 10px 0; text-decoration: none; color: var(--text); font-weight: 700; border: 1px solid rgba(0,0,0,0.05); transition: 0.3s; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .btn-main { background: var(--p); color: white; border: none; cursor: pointer; width: 100%; padding: 15px; border-radius: 12px; font-weight: 700; margin-top: 10px; }
        input { width: 100%; padding: 12px; margin: 8px 0; border-radius: 8px; border: 1px solid #ddd; outline: none; box-sizing: border-box; }
        .progress-bar { width: 100%; background: #eee; height: 8px; border-radius: 4px; overflow: hidden; margin: 20px 0; display: none; }
        .progress-fill { width: 0%; background: var(--s); height: 100%; transition: width 0.2s; }
    </style>
</head>
<body>
    <div class="glass">
        <h2 style="margin-bottom: 20px;">STA PORTAL</h2>
        
        <?php if ($view == 'intro'): ?>
            <p style="color: #636e72;">Select Access Portal</p>
            <a href="?portal=Admin" class="btn">⚙️ Admin</a>
            <a href="?portal=Teacher" class="btn">👨‍🏫 Teacher</a>
            <a href="?portal=Student" class="btn">🎓 Student</a>

        <?php elseif ($view && !$platform): ?>
            <p>Download App for <b><?php echo $view; ?></b></p>
            <a href="?portal=<?php echo $view; ?>&platform=Android" class="btn">🤖 Android APK</a>
            <a href="?portal=<?php echo $view; ?>&platform=iOS" class="btn"> iOS IPA</a>
            <a href="/" style="font-size: 0.8rem; color: #999; text-decoration: none;">← Back</a>

        <?php elseif ($platform): ?>
            <div id="dl-ui">
                <h3>Preparing <?php echo $platform; ?> Build</h3>
                <div class="progress-bar" id="p-bar"><div class="progress-fill" id="p-fill"></div></div>
                <p id="status" style="font-size: 0.8rem; color: #666;">Ready</p>
                <button class="btn-main" onclick="startDL()" id="dl-btn">Download Now</button>
            </div>

            <div id="login-ui" style="display:none;">
                <h3 style="margin-bottom: 15px;">Login Required</h3>
                <?php if($login_error) echo "<p style='color:red; font-size:0.8rem;'>$login_error</p>"; ?>
                <form method="POST">
                    <input type="text" name="user" placeholder="Username" required>
                    <input type="password" name="pass" placeholder="Password" required>
                    <button type="submit" name="login" class="btn-main">Verify & Login</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function startDL() {
        const bar = document.getElementById('p-bar');
        const fill = document.getElementById('p-fill');
        const status = document.getElementById('status');
        document.getElementById('dl-btn').style.display = 'none';
        bar.style.display = 'block';

        let w = 0;
        const int = setInterval(() => {
            w += Math.random() * 20;
            if(w >= 100) {
                w = 100;
                clearInterval(int);
                
                // REAL LOGIC: Tatawag sa /download/ route ng vercel.json
                const urlParams = new URLSearchParams(window.location.search);
                const pf = urlParams.get('platform').toLowerCase();
                window.location.href = '/download/' + pf;

                setTimeout(() => {
                    document.getElementById('dl-ui').style.display = 'none';
                    document.getElementById('login-ui').style.display = 'block';
                }, 2000);
            }
            fill.style.width = w + '%';
            status.innerText = "Downloading... " + Math.floor(w) + "%";
        }, 300);
    }
    </script>
</body>
</html>