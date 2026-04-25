<?php
session_start();
$view = $_GET['portal'] ?? 'intro';
$platform = $_GET['platform'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STA | Portal</title>
    <style>
        body { font-family: sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; background: #f0f2f5; margin: 0; }
        .glass { background: white; padding: 40px; border-radius: 20px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 90%; max-width: 400px; }
        .btn { display: block; padding: 15px; margin: 10px 0; background: #6c5ce7; color: white; text-decoration: none; border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="glass">
        <h1>STA PORTAL</h1>
        <?php if ($view == 'intro'): ?>
            <a href="?portal=Admin" class="btn">Admin</a>
            <a href="?portal=Student" class="btn">Student</a>
        <?php else: ?>
            <p>Portal: <?php echo $view; ?></p>
            <a href="?portal=<?php echo $view; ?>&platform=android" class="btn">Download Android</a>
            <a href="/" style="color: #999;">Back</a>
        <?php endif; ?>
    </div>
</body>
</html>