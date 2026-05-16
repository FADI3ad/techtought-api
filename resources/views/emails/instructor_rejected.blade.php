<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px; }
        .header { background: #fef2f2; color: #991b1b; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .reason { background: #fff1f2; padding: 15px; border-radius: 8px; border: 1px solid #fecdd3; color: #991b1b; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Application Update</h1>
        </div>
        <div class="content">
            <p>Hello {{ $name }},</p>
            <p>Thank you for your interest in TechTought. After reviewing your application, we regret to inform you that we cannot proceed with your instructor account at this time.</p>
            
            <p><strong>Reason for decision:</strong></p>
            <div class="reason">
                {{ $reason }}
            </div>
            
            <p>You are welcome to apply again in the future if your circumstances change or after addressing the points mentioned above.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} TechTought. All rights reserved.
        </div>
    </div>
</body>
</html>
