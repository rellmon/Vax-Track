<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            color: white;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px 20px;
        }
        
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .greeting strong {
            color: #667eea;
        }
        
        .info-box {
            background-color: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .info-box p {
            margin: 8px 0;
            font-size: 14px;
        }
        
        .otp-container {
            background-color: #f9f9f9;
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 25px 20px;
            text-align: center;
            margin: 25px 0;
        }
        
        .otp-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 4px;
            font-family: 'Courier New', monospace;
            word-break: break-all;
        }
        
        .expiry-notice {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            padding: 12px 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 13px;
            color: #92400e;
        }
        
        .instructions {
            background-color: #f3f4f6;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 14px;
        }
        
        .instructions ol {
            margin-left: 20px;
            margin-top: 10px;
        }
        
        .instructions li {
            margin-bottom: 8px;
        }
        
        .security-note {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 4px;
            padding: 12px 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #7f1d1d;
        }
        
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .button-container {
            text-align: center;
            margin: 25px 0;
        }
        
        .button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        
        .button:hover {
            background-color: #5568d3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🔐 Password Reset</h1>
            <p>VaccTrack <?php echo e(ucfirst($userType)); ?> Portal</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hi <strong><?php echo e($userName); ?></strong>,
            </div>
            
            <p>We received a request to reset your VaccTrack password. Use the code below to complete your password reset.</p>
            
            <!-- OTP Code -->
            <div class="otp-container">
                <div class="otp-label">Your Password Reset Code</div>
                <div class="otp-code"><?php echo e($otpCode); ?></div>
            </div>
            
            <!-- Expiry Warning -->
            <div class="expiry-notice">
                ⏰ This code expires in <strong><?php echo e($expiryMinutes); ?> minutes</strong>. Please use it quickly.
            </div>
            
            <!-- Instructions -->
            <div class="instructions">
                <strong>How to use this code:</strong>
                <ol>
                    <li>Go to the password reset page on VaccTrack</li>
                    <li>Enter your email address</li>
                    <li>Paste or type the code above (6 digits)</li>
                    <li>Create your new password</li>
                    <li>Sign in with your new password</li>
                </ol>
            </div>
            
            <!-- Security Note -->
            <div class="security-note">
                🔒 <strong>Security Reminder:</strong> Never share this code with anyone. VaccTrack staff will never ask for your code.
            </div>
            
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                If you didn't request a password reset, you can safely ignore this email. Your account remains secure.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>VaccTrack Vaccination Management System</strong></p>
            <p>© 2026 VaccTrack. All rights reserved.</p>
            <p>
                <a href="https://vacctrack.test">Visit VaccTrack</a> | 
                <a href="https://vacctrack.test/support">Support</a>
            </p>
            <p style="margin-top: 15px; color: #9ca3af; font-size: 11px;">
                This is an automated email. Please do not reply directly to this message.
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\vacctrack\resources\views/emails/password-reset-otp.blade.php ENDPATH**/ ?>