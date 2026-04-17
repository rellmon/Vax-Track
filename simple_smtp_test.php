<?php
// Simpler SMTP test - directly test mail without full bootstrap

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load .env manually
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
}

echo "=== Simple SMTP Test ===\n";
echo "PHP Version: " . PHP_VERSION . "\n\n";

// Get SMTP config from env
$host = getenv('MAIL_HOST') ?: 'smtp.mailtrap.io';
$port = getenv('MAIL_PORT') ?: '587';
$username = getenv('MAIL_USERNAME');
$password = getenv('MAIL_PASSWORD');
$from_address = getenv('MAIL_FROM_ADDRESS') ?: 'noreply@vacctrack.local';
$encryption = getenv('MAIL_ENCRYPTION') ?: 'tls';

echo "SMTP Configuration:\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Encryption: $encryption\n";
echo "From: $from_address\n";
echo "Username: " . (strlen($username) > 0 ? "***" : "NOT SET") . "\n";
echo "Password: " . (strlen($password) > 0 ? "***" : "NOT SET") . "\n";
echo "\n";

// Test with SwiftMailer directly
try {
    echo "Testing SMTP connection...\n";
    $start = microtime(true);
    
    // Create transport
    $transport = (new Swift_SmtpTransport($host, $port, $encryption))
        ->setUsername($username)
        ->setPassword($password)
        ->setStreamOptions(['ssl' => ['allow_self_signed' => true, 'verify_peer' => false]])
        ->setTimeout(30);
    
    echo "Connecting to SMTP server...\n";
    $transport->start();
    echo "✓ Connected successfully\n";
    
    // Create mailer
    $mailer = new Swift_Mailer($transport);
    
    // Create message
    $message = (new Swift_Message('Test Email from VaccTrack'))
        ->setFrom([$from_address => 'VaccTrack System'])
        ->setTo(['rellmontezor@gmail.com' => 'Test Recipient'])
        ->setBody('This is a direct SMTP test from VaccTrack system.');
    
    echo "Sending test email...\n";
    $result = $mailer->send($message);
    
    $elapsed = microtime(true) - $start;
    echo "✓ Email sent successfully!\n";
    echo "  Result: " . ($result ? "Success" : "Failed") . "\n";
    echo "  Time taken: " . number_format($elapsed, 2) . " seconds\n";
    
    $transport->stop();
    
} catch (\Exception $e) {
    $elapsed = microtime(true) - $start;
    echo "✗ Error occurred after " . number_format($elapsed, 2) . " seconds\n";
    echo "  Error: " . $e->getMessage() . "\n";
    echo "  Type: " . get_class($e) . "\n";
    if (method_exists($e, 'getResponse')) {
        echo "  Response: " . $e->getResponse() . "\n";
    }
}
?>
