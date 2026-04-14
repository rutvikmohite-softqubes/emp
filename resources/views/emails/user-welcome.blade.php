<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Employee Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 20px 0;
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .user-info h3 {
            margin: 0 0 10px 0;
            color: #007bff;
        }
        .user-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .login-info {
            background-color: #e7f3ff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .login-info h3 {
            margin: 0 0 15px 0;
            color: #28a745;
        }
        .login-info p {
            margin: 10px 0;
            font-size: 16px;
        }
        .password {
            font-weight: bold;
            color: #dc3545;
            font-size: 18px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Employee Management System</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $user->name }},</p>
            
            <p>Welcome to our Employee Management System! Your account has been successfully created. Below are your login credentials:</p>
            
            <div class="user-info">
                <h3>Your Account Information</h3>
                <p><strong>User ID:</strong> #{{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                @if($user->role)
                    <p><strong>Role:</strong> {{ $user->role->name }}</p>
                @endif
            </div>
            
            <div class="login-info">
                <h3>Login Credentials</h3>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> <span class="password">{{ $password }}</span></p>
                <p><strong>Important:</strong> Please change your password after your first login for security reasons.</p>
            </div>
            
            <p>You can now log in to your account and start using the system. If you have any questions or need assistance, please contact our support team.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="btn">Login to Your Account</a>
            </div>
            
            <p>Thank you for joining our team!</p>
            
            <p>Best regards,<br>
            Employee Management System Team</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Employee Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
