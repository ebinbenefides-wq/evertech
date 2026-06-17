<?php
// ─── Load config ────────────────────────────────────────────────────────────
$config = require __DIR__ . '/chatbot-config.php';

// ─── Allowed origins ─────────────────────────────────────────────────────────
$allowedOrigins = array_values(array_filter([
    'https://evertechme.com',
    'https://www.evertechme.com',
    getenv('CHATBOT_EXTRA_ORIGIN') ?: null,
]));

function isAllowedOrigin(string $origin): bool {
    global $allowedOrigins;
    if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?$#', $origin)) return true;
    if (preg_match('#^https://[a-z0-9-]+\.up\.railway\.app$#', $origin)) return true;
    return in_array($origin, $allowedOrigins, true);
}

$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

// Derive origin from referer when browser omits the Origin header (e.g. same-origin fetch)
if ($origin === '' && $referer !== '') {
    if (preg_match('#^(https?://[^/]+)#', $referer, $m)) {
        $origin = $m[1];
    }
}

// ─── CORS headers ────────────────────────────────────────────────────────────
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if (isAllowedOrigin($origin)) {
    header('Access-Control-Allow-Origin: ' . $origin);
} else {
    header('Access-Control-Allow-Origin: https://evertechme.com');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { exit(0); }

// ─── Origin enforcement ───────────────────────────────────────────────────────
if (!isAllowedOrigin($origin)) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// ─── Rate limiting (per IP, max N messages/hour) ─────────────────────────────
function checkRateLimit(string $ip, int $maxPerHour): bool {
    $file    = sys_get_temp_dir() . '/everbot_rl_' . md5($ip) . '.json';
    $now     = time();
    $window  = 3600;

    $timestamps = [];
    if (file_exists($file)) {
        $saved = @json_decode(file_get_contents($file), true);
        if (is_array($saved)) {
            $timestamps = array_values(array_filter($saved, fn($t) => ($now - $t) < $window));
        }
    }

    if (count($timestamps) >= $maxPerHour) return false;

    $timestamps[] = $now;
    @file_put_contents($file, json_encode($timestamps), LOCK_EX);
    return true;
}

// Use real IP (handles proxies/Cloudflare)
$ip = $_SERVER['HTTP_CF_CONNECTING_IP']
   ?? $_SERVER['HTTP_X_FORWARDED_FOR']
   ?? $_SERVER['REMOTE_ADDR']
   ?? '0.0.0.0';
$ip = trim(explode(',', $ip)[0]);

if (!checkRateLimit($ip, $config['max_per_hour'])) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many messages. Please wait a few minutes before trying again.']);
    exit;
}

// ─── Parse & validate input ───────────────────────────────────────────────────
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

$userMessage = isset($data['message']) ? trim((string) $data['message']) : '';
$history     = isset($data['history']) && is_array($data['history']) ? $data['history'] : [];
$wantStream  = !empty($data['stream']);

if ($userMessage === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Empty message']);
    exit;
}

if (mb_strlen($userMessage) > $config['max_msg_length']) {
    http_response_code(400);
    echo json_encode(['error' => 'Message too long. Please keep it under ' . $config['max_msg_length'] . ' characters.']);
    exit;
}

// ─── Real-time site content reader ───────────────────────────────────────────
function extractTitleFromSource(string $src, string $fallback): string {
    if (preg_match('/<title[^>]*>(.*?)<\/title>/si', $src, $m)) {
        $t = trim(strip_tags($m[1]));
        $t = preg_replace('/\s*[|\-–].*$/u', '', $t);
        if ($t) return $t;
    }
    if (preg_match('/<h2[^>]*class="[^"]*title[^"]*"[^>]*>(.*?)<\/h2>/si', $src, $m)) {
        $t = trim(strip_tags($m[1]));
        if ($t) return $t;
    }
    return $fallback;
}

function extractTextFromSource(string $src): string {
    $s = preg_replace('/<\?(?:php|=).*?\?>/si', ' ', $src);
    $s = preg_replace('/<script[^>]*>.*?<\/script>/si', '', $s);
    $s = preg_replace('/<style[^>]*>.*?<\/style>/si', '', $s);
    $s = preg_replace('/<svg[^>]*>.*?<\/svg>/si', '', $s);
    $s = preg_replace('/<(h[1-6]|p|li|dt|dd|tr|div|section|br|article)[^>]*>/i', "\n", $s);
    $s = strip_tags($s);
    $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $s = preg_replace('/[ \t]+/', ' ', $s);
    $lines = [];
    foreach (explode("\n", $s) as $line) {
        $line = trim($line);
        if (strlen($line) > 5) $lines[] = $line;
    }
    $unique = [];
    $prev = '';
    foreach ($lines as $l) {
        if ($l !== $prev) { $unique[] = $l; $prev = $l; }
    }
    return implode("\n", $unique);
}

// Categorize a page by filename so the prompt can group services like a real catalog.
function categorizePage(string $baseName): string {
    $cyber = ['security-assurance', 'security-consultancy', 'awareness-trainings',
              'password-management', 'security-solutions', 'dfir',
              'cctv-installation', 'security-services'];
    $it    = ['infrastructure-services', 'virtualization', 'data-center',
              'infrastructure-monitoring', 'managed-it', 'amc',
              'cloud-computing', 'it-consultancy'];
    $other = ['website-development', 'software-solutions',
              'license-and-compliance', 'product'];

    $name = pathinfo($baseName, PATHINFO_FILENAME);
    if (in_array($name, $cyber, true)) return 'Cybersecurity Services';
    if (in_array($name, $it, true))    return 'IT Services';
    if (in_array($name, $other, true)) return 'Other Services';
    return 'Company Info';
}

// Reads every page live from disk, groups it by category, and renders
// a structured catalog — same shape as a hand-written config, but always fresh.
function loadLiveCatalog(): array {
    $siteDir   = __DIR__;
    $skipFiles = [
        'chatbot-api.php', 'chatbot-config.php', 'chatbot-lead.php', 'chatbot-crawl.php',
        'service-template.php', 'service-template copy.php',
    ];

    $groups = [
        'Company Info'           => [],
        'IT Services'            => [],
        'Cybersecurity Services' => [],
        'Other Services'         => [],
    ];

    foreach (glob($siteDir . '/*.php') ?: [] as $filePath) {
        $base = basename($filePath);
        if (in_array($base, $skipFiles, true)) continue;

        $src = @file_get_contents($filePath);
        if (!$src) continue;

        $title = extractTitleFromSource($src, pathinfo($filePath, PATHINFO_FILENAME));
        $text  = extractTextFromSource($src);
        if (strlen($text) < 80) continue;

        $groups[categorizePage($base)][] = [
            'title'   => $title,
            'content' => mb_substr($text, 0, 1800),
        ];
    }

    return $groups;
}

function renderCatalogSection(string $heading, array $pages): string {
    if (!$pages) return '';
    $out = "## " . $heading . "\n";
    foreach ($pages as $p) {
        $out .= "\n### " . $p['title'] . "\n" . $p['content'] . "\n";
    }
    return $out;
}

// ─── Build structured, live system prompt ────────────────────────────────────
$catalog = loadLiveCatalog();

$systemPrompt = "You are EverBot, a professional and friendly AI assistant for Evertech — an IT services and cybersecurity company with offices in Dubai, London, and Bengaluru.

## Contact Information
- Phone: +971 4 3487849
- Email: info@evertechme.com
- Website: https://evertechme.com

## Office Locations
- Dubai, UAE: Office 105 - Ithraa Tower, Al Garhoud, PO-239885, Dubai, UAE
- London, UK: 71-75, Shelton Street, Covent Garden, London, WC2H 9JQ
- Bengaluru, India: BeHive, HSR Layout, Bengaluru, Karnataka, 560102

" . "The sections below are read live from the current website on every request, so they always reflect what's actually published.\n\n"
  . renderCatalogSection('Company Info', $catalog['Company Info'])
  . renderCatalogSection('IT Services', $catalog['IT Services'])
  . renderCatalogSection('Cybersecurity Services', $catalog['Cybersecurity Services'])
  . renderCatalogSection('Other Services', $catalog['Other Services'])
  . "\n## Your Behaviour Rules
- Be concise, professional, and friendly. Aim for 2-4 sentences unless more detail is clearly needed.
- Only answer questions about Evertech and the services described above — politely redirect unrelated questions back to how Evertech can help.
- Base your answers on the live content above; don't invent services, prices, or locations that aren't listed.
- If someone asks for a quote, wants to discuss a project, or wants to talk to the team, let them know our team will reach out and ask them to share their name to get started.
- For anything you're unsure about, encourage the visitor to email info@evertechme.com or call +971 4 3487849.";

// ─── Build message array ──────────────────────────────────────────────────────
$messages = [];
foreach (array_slice($history, -10) as $turn) {
    if (isset($turn['role'], $turn['content']) &&
        in_array($turn['role'], ['user', 'assistant'], true)) {
        $messages[] = [
            'role'    => $turn['role'],
            'content' => mb_substr((string) $turn['content'], 0, 1000),
        ];
    }
}
$messages[] = ['role' => 'user', 'content' => $userMessage];

// ─── Call Claude API ──────────────────────────────────────────────────────────
$payload = json_encode([
    'model'      => 'claude-opus-4-8',
    'max_tokens' => 500,
    'system'     => $systemPrompt,
    'messages'   => $messages,
    'stream'     => $wantStream,
]);

if ($wantStream) {
    // ─── Streaming: relay Claude's SSE text deltas to the browser as plain text ──
    header_remove('Content-Type');
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Accel-Buffering: no');
    while (ob_get_level() > 0) { ob_end_flush(); }

    $buffer    = '';
    $sawOutput = false;

    $ch = curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch, [
        CURLOPT_POST       => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_TIMEOUT    => 60,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-api-key: ' . $config['api_key'],
            'anthropic-version: 2023-06-01',
        ],
        CURLOPT_WRITEFUNCTION => function ($curlHandle, $chunk) use (&$buffer, &$sawOutput) {
            $buffer .= $chunk;
            while (($pos = strpos($buffer, "\n")) !== false) {
                $line   = rtrim(substr($buffer, 0, $pos), "\r");
                $buffer = substr($buffer, $pos + 1);

                if (strpos($line, 'data: ') !== 0) continue;
                $json = json_decode(substr($line, 6), true);
                if (!is_array($json)) continue;

                if (($json['type'] ?? '') === 'content_block_delta'
                    && isset($json['delta']['text'])) {
                    echo $json['delta']['text'];
                    $sawOutput = true;
                    @flush();
                }
            }
            return strlen($chunk);
        },
    ]);

    curl_exec($ch);
    $curlErr = curl_error($ch);
    curl_close($ch);

    if (!$sawOutput) {
        echo $curlErr !== ''
            ? 'Sorry, I had trouble connecting. Please try again or email info@evertechme.com.'
            : 'Sorry, I could not process that. Please try again or email info@evertechme.com.';
    }
    exit;
}

// ─── Non-streaming fallback ───────────────────────────────────────────────────
$ch = curl_init('https://api.anthropic.com/v1/messages');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'x-api-key: ' . $config['api_key'],
        'anthropic-version: 2023-06-01',
    ],
]);

$response = curl_exec($ch);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'Connection failed: ' . $curlErr]);
    exit;
}

$result = json_decode($response, true);
if (isset($result['content'][0]['text'])) {
    echo json_encode(['reply' => $result['content'][0]['text']]);
} else {
    $msg = isset($result['error']['message']) ? $result['error']['message'] : 'Unknown error';
    http_response_code(502);
    echo json_encode(['error' => $msg]);
}
