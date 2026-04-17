<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to VaccTrack</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 20px;
            color: white;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
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
            color: #10b981;
        }
        
        .benefits-section {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .benefits-section h2 {
            font-size: 16px;
            color: #065f46;
            margin-bottom: 12px;
        }
        
        .benefits-list {
            list-style: none;
            padding: 0;
        }
        
        .benefits-list li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
            font-size: 14px;
            color: #047857;
        }
        
        .benefits-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #10b981;
            font-weight: bold;
        }
        
        .action-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .button {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 14px 40px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .button:hover {
            background-color: #059669;
        }
        
        .info-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 13px;
        }
        
        .info-box h3 {
            color: #10b981;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .info-box p {
            margin: 6px 0;
            color: #666;
        }
        
        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        
        .feature-card {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
        
        .feature-card .icon {
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .feature-card h3 {
            font-size: 14px;
            color: #10b981;
            margin-bottom: 6px;
        }
        
        .feature-card p {
            font-size: 12px;
            color: #666;
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
            color: #10b981;
            text-decoration: none;
        }
        
        @media (max-width: 480px) {
            .features {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 22px;
            }
            
            .button {
                padding: 12px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Welcome to VaccTrack!</h1>
            <p>Your Child's Vaccination Management Portal</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hi <strong><?php echo e($parent->name); ?></strong>,
            </div>
            
            <p>Welcome to <strong>VaccTrack</strong> - the easiest way to manage and track your child's vaccinations. We're excited to have you on board!</p>
            
            <!-- Benefits Section -->
            <div class="benefits-section">
                <h2>What You Can Do with VaccTrack</h2>
                <ul class="benefits-list">
                    <li>Track all your child's vaccinations in one place</li>
                    <li>Receive appointment reminers via email</li>
                    <li>Schedule vaccine appointments online</li>
                    <li>View vaccination records anytime, anywhere</li>
                    <li>Get updates on vaccination requirements</li>
                    <li>Access compliance reports</li>
                </ul>
            </div>
            
            <!-- Features Grid -->
            <div class="features">
                <div class="feature-card">
                    <div class="icon">📋</div>
                    <h3>Records</h3>
                    <p>Keep detailed vaccination records</p>
                </div>
                <div class="feature-card">
                    <div class="icon">📅</div>
                    <h3>Appointments</h3>
                    <p>Book and manage appointments</p>
                </div>
                <div class="feature-card">
                    <div class="icon">🔔</div>
                    <h3>Reminders</h3>
                    <p>Never miss an appointment</p>
                </div>
                <div class="feature-card">
                    <div class="icon">📊</div>
                    <h3>Reports</h3>
                    <p>Track compliance status</p>
                </div>
            </div>
            
            <!-- Call to Action -->
            <div class="action-section">
                <p><strong>Ready to get started?</strong></p>
                <a href="<?php echo e($appUrl); ?>/parent/dashboard" class="button">Login to VaccTrack</a>
            </div>
            
            <!-- Important Info -->
            <div class="info-box">
                <h3>⚙️ Getting Started Tips</h3>
                <p><strong>1. Complete Your Profile:</strong> Update your contact information and child's details</p>
                <p><strong>2. Add Your Children:</strong> Register each child you want to track</p>
                <p><strong>3. Schedule Appointments:</strong> Book vaccines at your preferred times</p>
                <p><strong>4. Enable Notifications:</strong> Get appointment reminders via email</p>
            </div>
            
            <!-- Support Section -->
            <div class="info-box" style="background-color: #fef3c7; border-color: #fbbf24;">
                <h3>❓ Need Help?</h3>
                <p>If you have any questions, contact <?php echo e($clinicName); ?> or visit our support center.</p>
                <p style="margin-top: 8px; color: #92400e;">We're here to help ensure your child's health and wellness!</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>VaccTrack Vaccination Management System</strong></p>
            <p>© 2026 VaccTrack. Keep children healthy, one vaccine at a time.</p>
            <p style="margin-top: 15px;">
                <a href="<?php echo e($appUrl); ?>">Visit VaccTrack</a> | 
                <a href="<?php echo e($appUrl); ?>/parent/dashboard">Parent Portal</a>
            </p>
            <p style="margin-top: 15px; color: #9ca3af; font-size: 11px;">
                This is an automated email. Please do not reply directly to this message.
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\vacctrack\resources\views/emails/parent-welcome.blade.php ENDPATH**/ ?>