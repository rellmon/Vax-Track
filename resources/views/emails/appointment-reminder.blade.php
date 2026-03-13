<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder</title>
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
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
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
        
        .alert-box {
            background-color: #fef3c7;
            border: 2px solid #fbbf24;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        
        .alert-box p {
            color: #92400e;
            font-weight: bold;
            font-size: 16px;
            margin: 0;
        }
        
        .greeting {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .greeting strong {
            color: #f97316;
        }
        
        .appointment-details {
            background-color: #fef9e7;
            border-left: 4px solid #f97316;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        
        .appointment-details h2 {
            font-size: 16px;
            color: #ea580c;
            margin-bottom: 15px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .detail-label {
            font-weight: bold;
            width: 120px;
            color: #666;
        }
        
        .detail-value {
            flex: 1;
            color: #333;
            word-break: break-word;
        }
        
        .action-section {
            text-align: center;
            margin: 25px 0;
        }
        
        .button {
            display: inline-block;
            background-color: #f97316;
            color: white;
            padding: 14px 40px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        
        .button:hover {
            background-color: #ea580c;
        }
        
        .instructions {
            background-color: #f3f4f6;
            padding: 15px 20px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 13px;
        }
        
        .instructions h3 {
            color: #f97316;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .instructions ul {
            margin-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 6px;
        }
        
        .reschedule-section {
            background-color: #eef2ff;
            border: 1px solid #c7d2fe;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
            font-size: 13px;
            color: #3730a3;
        }
        
        .reschedule-section strong {
            color: #1e40af;
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
            color: #f97316;
            text-decoration: none;
        }
        
        @media (max-width: 480px) {
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 4px;
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
            <h1>📅 Appointment Reminder</h1>
            <p>Your vaccination appointment is tomorrow</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <!-- Alert Box -->
            <div class="alert-box">
                <p>⚠️ Your appointment is scheduled for TOMORROW!</p>
            </div>
            
            <div class="greeting">
                Hi <strong>{{ $parent->first_name }} {{ $parent->last_name }}</strong>,
            </div>
            
            <p>This is a reminder that <strong>{{ $child->first_name }} {{ $child->last_name }}</strong> has a vaccination appointment scheduled for tomorrow. Please ensure you arrive on time.</p>
            
            <!-- Appointment Details -->
            <div class="appointment-details">
                <h2>📋 Appointment Details</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Child:</span>
                    <span class="detail-value">{{ $child->first_name }} {{ $child->last_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Vaccine:</span>
                    <span class="detail-value">{{ $vaccine->name ?? 'Scheduled Vaccine' }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $schedule->appointment_date->format('l, F j, Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">{{ $schedule->appointment_time }}</span>
                </div>
                
                @if($schedule->notes)
                <div class="detail-row">
                    <span class="detail-label">Notes:</span>
                    <span class="detail-value">{{ $schedule->notes }}</span>
                </div>
                @endif
            </div>
            
            <!-- Important Instructions -->
            <div class="instructions">
                <h3>✓ Before Your Appointment</h3>
                <ul>
                    <li>Ensure your child is well-rested and healthy</li>
                    <li>Avoid giving heavy meals right before the appointment</li>
                    <li>Bring any previous vaccination records</li>
                    <li>Arrive 10 minutes early for check-in</li>
                    <li>Have a valid ID and child's birth certificate ready</li>
                </ul>
            </div>
            
            <!-- Reschedule Option -->
            <div class="reschedule-section">
                <strong>Need to reschedule?</strong><br>
                If you cannot make this appointment, please contact the clinic as soon as possible. 
                <a href="{{ $appUrl }}/parent/appointments">Manage your appointments</a>
            </div>
            
            <!-- Call to Action -->
            <div class="action-section">
                <p><strong>View appointment details in your portal:</strong></p>
                <a href="{{ $appUrl }}/parent/appointments" class="button">Go to My Appointments</a>
            </div>
            
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                If you have any questions or concerns about the appointment, please contact VaccTrack clinic directly.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>VaccTrack Vaccination Management System</strong></p>
            <p>© 2026 VaccTrack. Keep children healthy, one vaccine at a time.</p>
            <p style="margin-top: 15px;">
                <a href="{{ $appUrl }}">Visit VaccTrack</a> | 
                <a href="{{ $appUrl }}/parent/dashboard">Parent Portal</a>
            </p>
            <p style="margin-top: 15px; color: #9ca3af; font-size: 11px;">
                This is an automated reminder email. Please do not reply directly to this message.
            </p>
        </div>
    </div>
</body>
</html>
