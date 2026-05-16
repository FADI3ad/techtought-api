<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e1e1e1; border-radius: 10px; }
        .header { background: #111827; color: #fff; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .credentials { background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #eee; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #111827; color: #fff; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to TechTought!</h1>
        </div>
        <div class="content">
            <p>Hello {{ $name }},</p>
            <p>Congratulations! Your application to become an instructor on TechTought has been <strong>approved</strong>.</p>
            <p>You can now log in to your dashboard and start creating courses.</p>
            
            <div class="credentials">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Temporary Password:</strong> {{ $password }}</p>
            </div>
            
            <p>Please change your password after your first login for security reasons.</p>
            
            <div style="text-align: center;">
                <a href="http://localhost:5173/login" class="btn">Log In to Your Dashboard</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} TechTought. All rights reserved.
        </div>
    </div>
</body>
</html>
