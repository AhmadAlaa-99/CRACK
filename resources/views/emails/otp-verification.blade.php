<!-- resources/views/emails/otp-verification.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .content {
            padding: 20px 0;
        }
        .otp-code {
            background-color: #f5f5f5;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Email Verification</h2>
        </div>

        <div class="content">
            <p>Hello,</p>
            <p>Thank you for registering. Please use the verification code below to complete your registration:</p>

            <div class="otp-code">{{ $otp }}</div>

            <p>This code will expire in 15 minutes.</p>
            <p>If you did not request this verification, please ignore this email.</p>
        </div>

        <div class="footer">
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>
