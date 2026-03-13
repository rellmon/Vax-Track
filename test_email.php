<?php
// Test email sending via Mailtrap
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\ParentGuardian;
use App\Models\SmsOtp;

try {
    $parent = ParentGuardian::findOrFail(4);
    SmsOtp::generateAndSend($parent->email, 'parent', $parent->id);
    echo "✅ Email sending test PASSED\n";
    echo "📧 Email sent to: {$parent->email}\n";
    echo "🔐 Check your Mailtrap inbox at https://mailtrap.io\n";
} catch (\Exception $e) {
    echo "❌ Email sending test FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}
