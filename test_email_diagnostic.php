<?php
// Diagnostic test for email sending
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

echo "=== VaccTrack Email Diagnostic ===\n\n";

// 1. Check environment variables
echo "1. ENVIRONMENT VARIABLES:\n";
echo "   MAIL_MAILER: " . (getenv('MAIL_MAILER') ?: 'NOT SET') . "\n";
echo "   MAIL_HOST: " . (getenv('MAIL_HOST') ?: 'NOT SET') . "\n";
echo "   MAIL_PORT: " . (getenv('MAIL_PORT') ?: 'NOT SET') . "\n";
echo "   MAIL_USERNAME: " . (getenv('MAIL_USERNAME') ?: 'NOT SET') . "\n";
echo "   MAIL_PASSWORD: " . (getenv('MAIL_PASSWORD') ? '***SET***' : 'NOT SET') . "\n";
echo "   MAIL_ENCRYPTION: " . (getenv('MAIL_ENCRYPTION') ?: 'NOT SET') . "\n";
echo "\n";

// 2. Bootstrap Laravel
echo "2. BOOTSTRAPPING LARAVEL...\n";
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "   ✓ Laravel bootstrapped\n\n";

// 3. Check config values
echo "3. LARAVEL CONFIG (mail.php):\n";
echo "   Default Mailer: " . config('mail.default') . "\n";
echo "   SMTP Host: " . config('mail.mailers.smtp.host') . "\n";
echo "   SMTP Port: " . config('mail.mailers.smtp.port') . "\n";
echo "   SMTP Encryption: " . config('mail.mailers.smtp.encryption') . "\n";
echo "   SMTP Timeout: " . config('mail.mailers.smtp.timeout') . "\n";
echo "   From Address: " . config('mail.from.address') . "\n";
echo "   From Name: " . config('mail.from.name') . "\n";
echo "\n";

// 4. Test SMTP connection directly
echo "4. TESTING SMTP CONNECTION:\n";
try {
    $transport = new \Swift_SmtpTransport(
        config('mail.mailers.smtp.host'),
        config('mail.mailers.smtp.port'),
        config('mail.mailers.smtp.encryption')
    );
    $transport->setUsername(config('mail.mailers.smtp.username'));
    $transport->setPassword(config('mail.mailers.smtp.password'));
    $transport->setStreamOptions(['ssl' => ['verify_peer' => false]]);
    $transport->setTimeout(10);
    
    echo "   Connecting to SMTP...\n";
    $transport->start();
    echo "   ✓ SMTP connection successful!\n";
    $transport->stop();
} catch (\Exception $e) {
    echo "   ✗ SMTP connection FAILED: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
echo "\n";

// 5. Try sending test email
echo "5. SENDING TEST EMAIL:\n";
try {
    $start = microtime(true);
    Mail::raw('This is a test email from VaccTrack diagnostic', function ($message) {
        $message->to('rellmontezor@gmail.com')
                ->subject('VaccTrack Test Email - ' . date('Y-m-d H:i:s'));
    });
    $elapsed = microtime(true) - $start;
    echo "   ✓ Email sent successfully in {$elapsed}s\n";
} catch (\Exception $e) {
    $elapsed = microtime(true) - $start;
    echo "   ✗ Email send FAILED after {$elapsed}s\n";
    echo "   Error: " . $e->getMessage() . "\n";
    echo "   Code: " . $e->getCode() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\n   Full Trace:\n";
    echo $e->getTraceAsString() . "\n";
}
echo "\n";

echo "=== END DIAGNOSTIC ===\n";
