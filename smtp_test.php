<?php
require_once __DIR__ . "/vendor/autoload.php";
echo "=== Simple SMTP Test ===\n";
echo "PHP Version: " . PHP_VERSION . "\n\n";

$host = "smtp.gmail.com";
$port = 587;
$username = "rellmontezor@gmail.com";
$password = "vnav kzbx emup lbfb";
$from_address = "noreply@vacctrack.ph";
$encryption = "tls";

echo "SMTP Configuration:\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Encryption: $encryption\n";
echo "From: $from_address\n";
echo "\n";

try {
    echo "Testing SMTP connection...\n";
    $start = microtime(true);
    $transport = (new Swift_SmtpTransport($host, $port, $encryption))
        ->setUsername($username)
        ->setPassword($password)
        ->setStreamOptions(["ssl" => ["allow_self_signed" => true, "verify_peer" => false]])
        ->setTimeout(30);
    echo "Connecting to SMTP server...\n";
    $transport->start();
    echo "Connected successfully\n";
    $mailer = new Swift_Mailer($transport);
    $message = (new Swift_Message("Test Email from VaccTrack"))
        ->setFrom([$from_address => "VaccTrack System"])
        ->setTo(["rellmontezor@gmail.com" => "Test Recipient"])
        ->setBody("This is a direct SMTP test from VaccTrack system.");
    echo "Sending test email...\n";
    $result = $mailer->send($message);
    $elapsed = microtime(true) - $start;
    echo "Email sent successfully!\n";
    echo "Time taken: " . number_format($elapsed, 2) . " seconds\n";
    $transport->stop();
} catch (Exception $e) {
    $elapsed = microtime(true) - $start;
    echo "Error after " . number_format($elapsed, 2) . " seconds: " . $e->getMessage() . "\n";
}
?>
