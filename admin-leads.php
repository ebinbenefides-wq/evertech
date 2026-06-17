<?php
$config = file_exists(__DIR__ . '/chatbot-config.php')
    ? require __DIR__ . '/chatbot-config.php'
    : [];
$config['log_path'] = (getenv('LEADS_LOG_DIR') ?: __DIR__) . '/chatbot-leads.log';
// Simple lead viewer — protect with a password
$password = 'evertech2024'; // Change this!
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pass'])) {
    if ($_POST['pass'] === $password) {
        $_SESSION['leads_auth'] = true;
    } else {
        $error = 'Wrong password.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin-leads.php');
    exit;
}

if (empty($_SESSION['leads_auth'])) {
    ?><!DOCTYPE html>
    <html><head><meta charset="utf-8"><title>Leads Login</title>
    <style>body{font-family:Arial,sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f1f5f9}
    .box{background:#fff;padding:32px 36px;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,.12);width:300px}
    h2{margin:0 0 20px;font-size:18px;color:#1e293b}
    input{width:100%;padding:9px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;box-sizing:border-box;margin-bottom:12px}
    button{width:100%;padding:10px;background:linear-gradient(135deg,#7141B1,#43BAFF);color:#fff;border:none;border-radius:8px;font-size:14px;cursor:pointer}
    .err{color:#ef4444;font-size:13px;margin-bottom:10px}</style>
    </head><body><div class="box">
    <h2>EverBot Leads</h2>
    <?php if (!empty($error)) echo '<div class="err">'.$error.'</div>'; ?>
    <form method="post"><input type="password" name="pass" placeholder="Password" autofocus>
    <button type="submit">Login</button></form>
    </div></body></html>
    <?php
    exit;
}

$logFile = $config['log_path'];
$lines   = file_exists($logFile) ? array_filter(array_map('trim', file($logFile))) : [];
$leads   = [];

foreach (array_reverse(array_values($lines)) as $line) {
    // [2025-01-15 14:32:10] name=John | email=john@x.com | phone=+971... | ip=1.2.3.4
    if (preg_match('/^\[(.+?)\] name=(.+?) \| email=(.+?) \| phone=(.+?) \| ip=(.+)$/', $line, $m)) {
        $leads[] = ['time' => $m[1], 'name' => $m[2], 'email' => $m[3], 'phone' => $m[4], 'ip' => $m[5]];
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>EverBot Leads</title>
<style>
*{box-sizing:border-box}
body{font-family:Arial,sans-serif;margin:0;background:#f1f5f9;color:#1e293b}
.top{background:linear-gradient(135deg,#7141B1,#43BAFF);padding:16px 28px;display:flex;align-items:center;justify-content:space-between}
.top h1{margin:0;color:#fff;font-size:20px}
.top a{color:rgba(255,255,255,.8);font-size:13px;text-decoration:none}
.top a:hover{color:#fff}
.wrap{max-width:960px;margin:28px auto;padding:0 16px}
.stats{display:flex;gap:16px;margin-bottom:24px}
.stat{background:#fff;border-radius:12px;padding:16px 20px;flex:1;box-shadow:0 1px 4px rgba(0,0,0,.07)}
.stat-n{font-size:28px;font-weight:700;color:#7141B1}
.stat-l{font-size:12px;color:#94a3b8;margin-top:2px}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.07)}
th{background:#7141B1;color:#fff;text-align:left;padding:12px 14px;font-size:13px;font-weight:600}
td{padding:11px 14px;font-size:13px;border-bottom:1px solid #f1f5f9}
tr:last-child td{border-bottom:none}
tr:hover td{background:#f8f5ff}
.empty{text-align:center;padding:40px;color:#94a3b8;font-size:14px}
</style>
</head>
<body>
<div class="top">
    <h1>EverBot Leads</h1>
    <a href="?logout=1">Logout</a>
</div>
<div class="wrap">
    <div class="stats">
        <div class="stat"><div class="stat-n"><?= count($leads) ?></div><div class="stat-l">Total Leads</div></div>
        <?php
        $today = date('Y-m-d');
        $todayCount = count(array_filter($leads, fn($l) => str_starts_with($l['time'], $today)));
        ?>
        <div class="stat"><div class="stat-n"><?= $todayCount ?></div><div class="stat-l">Today</div></div>
    </div>

    <?php if (empty($leads)): ?>
        <table><tr><td class="empty">No leads yet — they will appear here once visitors complete the chat flow.</td></tr></table>
    <?php else: ?>
    <table>
        <thead><tr><th>Date / Time</th><th>Name</th><th>Email</th><th>Phone</th><th>IP</th></tr></thead>
        <tbody>
        <?php foreach ($leads as $l): ?>
        <tr>
            <td><?= htmlspecialchars($l['time']) ?></td>
            <td><?= htmlspecialchars($l['name']) ?></td>
            <td><a href="mailto:<?= htmlspecialchars($l['email']) ?>"><?= htmlspecialchars($l['email']) ?></a></td>
            <td><?= htmlspecialchars($l['phone']) ?></td>
            <td><?= htmlspecialchars($l['ip']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
</body></html>
