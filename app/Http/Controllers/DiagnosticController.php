<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DiagnosticController extends Controller
{
    /**
     * Test mail configuration
     */
    public function testMail()
    {
        return response()->json([
            'mail_config' => [
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username'),
                'from' => config('mail.from.address'),
                'from_name' => config('mail.from.name'),
            ],
            'php_mail_enabled' => ini_get('sendmail_path') ? 'yes' : 'no',
            'stream_context_test' => $this->testStreamContext(),
        ]);
    }

    /**
     * Test SMTP connection
     */
    public function testSmtpConnection()
    {
        try {
            $host = config('mail.mailers.smtp.host');
            $port = config('mail.mailers.smtp.port');
            
            // Test TCP connection
            $socket = @fsockopen($host, $port, $errno, $errstr, 5);
            
            if ($socket) {
                fclose($socket);
                return response()->json([
                    'status' => 'success',
                    'message' => "✅ Successfully connected to {$host}:{$port}",
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ Failed to connect to {$host}:{$port}",
                    'error' => $errstr,
                    'errno' => $errno,
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Exception during connection test',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send test email (times out after 10 seconds)
     */
    public function sendTestEmail()
    {
        set_time_limit(15); // 15 second timeout
        
        $startTime = microtime(true);
        
        try {
            Log::info('🔵 Starting test email send');
            
            Mail::raw('This is a test email from VaccTrack diagnostic.', function ($message) {
                $message->to('test@example.com') // Invalid but tests SMTP connection
                        ->subject('VaccTrack Diagnostic Test');
            });
            
            $elapsed = microtime(true) - $startTime;
            
            Log::info('✅ Test email sent', ['elapsed_ms' => round($elapsed * 1000)]);
            
            return response()->json([
                'status' => 'sent',
                'message' => '✅ Test email sent successfully (even if to invalid address)',
                'elapsed_ms' => round($elapsed * 1000),
            ], 200);
            
        } catch (\Exception $e) {
            $elapsed = microtime(true) - $startTime;
            
            Log::error('❌ Test email failed', [
                'error' => $e->getMessage(),
                'elapsed_ms' => round($elapsed * 1000),
                'exception' => (string)$e,
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => '❌ Test email failed',
                'error' => $e->getMessage(),
                'elapsed_ms' => round($elapsed * 1000),
            ], 500);
        }
    }

    /**
     * Check stream context
     */
    private function testStreamContext()
    {
        try {
            $streamContext = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ]);
            return $streamContext ? 'available' : 'unavailable';
        } catch (\Exception $e) {
            return 'error: ' . $e->getMessage();
        }
    }
}
