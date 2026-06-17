<?php
// EverBot lead capture endpoint — stores visitor name/email/phone collected by the chat widget.
$config = require __DIR__ . '/chatbot-config.php';

$allowedOrigins = array_values(array_filter([
    'https://evertechme.com',
    'https://www.evertechme.com',
    getenv('CHATBOT_EXTRA_ORIGIN') ?: null,
]));

function ebLeadIsAllowedOrigin(string $origin, array $allowed): bool {
    if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?$#', $origin)) return true;
    if (preg_match('#^https://[a-z0-9-]+\.up\.railway\.app$#', $origin)) return true;
    return in_array($origin, $allowed, true);
}

$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
if ($origin === '' && $referer !== '' && preg_match('#^(https?://[^/]+)#', $referer, $m)) {
    $origin = $m[1];
}

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Origin: ' . (ebLeadIsAllowedOrigin($origin, $allowedOrigins) ? $origin : 'https://evertechme.com'));

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

if (!ebLeadIsAllowedOrigin($origin, $allowedOrigins)) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$name  = isset($data['name'])  ? trim((string) $data['name'])  : '';
$email = isset($data['email']) ? trim((string) $data['email']) : '';
$phone = isset($data['phone']) ? trim((string) $data['phone']) : '';

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'A valid name and email are required']);
    exit;
}

$name  = mb_substr($name, 0, 120);
$email = mb_substr($email, 0, 190);
$phone = mb_substr($phone, 0, 40);

$line = sprintf(
    "[%s] name=%s | email=%s | phone=%s | ip=%s\n",
    date('Y-m-d H:i:s'),
    str_replace(["\r", "\n", '|'], ' ', $name),
    str_replace(["\r", "\n", '|'], ' ', $email),
    str_replace(["\r", "\n", '|'], ' ', $phone !== '' ? $phone : '-'),
    $_SERVER['REMOTE_ADDR'] ?? '-'
);

@file_put_contents($config['log_path'], $line, FILE_APPEND | LOCK_EX);

if (!empty($config['lead_notify_email'])) {
    @mail(
        $config['lead_notify_email'],
        'New EverBot chat lead: ' . $name,
        "A new lead came in via the EverBot chat widget:\n\n" .
        "Name:  $name\n" .
        "Email: $email\n" .
        "Phone: " . ($phone !== '' ? $phone : '-') . "\n",
        'From: EverBot <no-reply@evertechme.com>'
    );
}

echo json_encode(['ok' => true]);
