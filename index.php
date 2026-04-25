<?php
session_start();

// MOCK LOGIN: Gamitin muna natin ito para ma-test ang flow
$login_error = "";
if (isset($_POST['login'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    
    // Admin: admin / Password: password123
    if ($username === "admin" && $password === "password123") {
        $_SESSION['logged_in'] = true;
        // Dito mo i-redirect sa dashboard mo balang araw
        echo "<script>alert('Login Success! Deployment Working.'); window.location.href='/';</script>";
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
    <title>STA | Sievers Tech Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --p: #6c5ce7; --s: #00b894; --text: #2d3436; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f2f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background: linear-gradient(-45deg, #e3f2fd, #f3e5f5, #e8f5e9); }
        .glass { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(20px); border-radius: 30px; padding: 40px; width: 90%; max-width: 500px; text-align: center; border: 1px solid rgba(255,255,255,0.5); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn { background: white; padding: 15px; border-radius: 12px; display: block; margin: 10px 0; text-decoration: none; color: var(--text); font-weight: 700; border: 1px solid rgba(0,0,0,0.05); transition: 0.3s; }
        .btn:hover { transform: scale(1.02); background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .btn-main { background: var(--p); color: white; border: none; cursor: pointer; width: 100%; padding: 15px; border-radius: 12px; font-weight: 700; }
        input { width: 100%; padding: 12px; margin: 8px 0; border-radius: 8px; border: 1px solid #ddd; }
        .progress-bar { width: 100%; background: #eee; height: 8px; border-radius: 4px; overflow: hidden; margin: 20px 0; display: none; }
        .progress-fill { width: 0%; background: var(--s); height: 100%; transition: width 0.2s; }
    </style>
</head>
<body>
    <div class="glass">
        <h2>STA <span>Connect</span></h2>
        
        <?php if ($view == 'intro'): ?>
            <p style="color: #636e72;">Choose Portal</p>
            <a href="?portal=Admin" class="btn">⚙️ Admin</a>
            <a href="?portal=Teacher" class="btn">👨‍🏫 Teacher</a>
            <a href="?portal=Student" class="btn">🎓 Student</a>

        <?php elseif ($view && !$platform): ?>
            <p>Select Device</p>
            <a href="?portal=<?php echo $view; ?>&platform=Android" class="btn">🤖 Android APK</a>
            <a href="?portal=<?php echo $view; ?>&platform=iOS" class="btn"> iOS IPA</a>
            <a href="/" style="font-size: 0.8rem; color: #999;">Back</a>

        <?php elseif ($platform): ?>
            <div id="dl-ui">
                <h3>Preparing for <?php echo $platform; ?></h3>
                <div class="progress-bar" id="p-bar"><div class="progress-fill" id="p-fill"></div></div>
                <p id="status" style="font-size: 0.8rem; color: #666;">Ready to Install</p>
                <button class="btn-main" onclick="startDL()" id="dl-btn">Download Now</button>
            </div>

            <div id="login-ui" style="display:none;">
                <h3>STA Login</h3>
                <?php if($login_error) echo "<p style='color:red; font-size:0.8rem;'>$login_error</p>"; ?>
                <form method="POST">
                    <input type="text" name="user" placeholder="Username" required>
                    <input type="password" name="pass" placeholder="Password" required>
                    <button type="submit" class="btn-main">Login</button>
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
            w += Math.random() * 15;
            if(w >= 100) {
                w = 100;
                clearInterval(int);
                const pf = new URLSearchParams(window.location.search).get('platform').toLowerCase();
                window.location.href = '/download/' + pf;
                setTimeout(() => {
                    document.getElementById('dl-ui').style.display = 'none';
                    document.getElementById('login-ui').style.display = 'block';
                }, 1500);
            }
            fill.style.width = w + '%';
            status.innerText = "Downloading... " + Math.floor(w) + "%";
        }, 200);
    }
    </script>
</body>
</html>