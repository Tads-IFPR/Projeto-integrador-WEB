<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* Email container */
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #f2f2f2;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Email header */
        .email-header {
            background-color: #13F2A1;
            color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Main content */
        .email-content {
            padding: 20px;
        }

        .email-content p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Reset password button */
        .email-content .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #13F2A1;
            color: #f2f2f2;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            text-align: center;
        }

        .email-content .btn:hover {
            background-color: #6DF2CC;
        }

        /* Email footer */
        .email-footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset</h1>
        </div>
        <div class="email-content">
            <p>You have requested to reset your password. Click the button below to reset your password:</p>
            <p style="text-align: center;">
                <a href="{{ route('password.reset', $token) }}" class="btn">Reset Password</a>
            </p>
            <p>If you did not request this password reset, please ignore this email.</p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
