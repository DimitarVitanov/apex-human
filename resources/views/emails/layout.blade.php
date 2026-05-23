<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Apex Human' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0A0A0A;
            font-family: Georgia, 'Times New Roman', serif;
            color: #D4D0C8;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #111111;
        }
        .email-header {
            padding: 40px 40px 30px;
            text-align: center;
            border-bottom: 1px solid rgba(201, 151, 58, 0.3);
        }
        .email-header h1 {
            font-family: 'Trebuchet MS', Helvetica, sans-serif;
            font-size: 22px;
            letter-spacing: 0.18em;
            color: #C9973A;
            margin: 0;
        }
        .email-body {
            padding: 40px;
        }
        .email-body h2 {
            font-family: 'Trebuchet MS', Helvetica, sans-serif;
            font-size: 20px;
            color: #F5F0E8;
            margin: 0 0 20px;
            letter-spacing: 0.02em;
        }
        .email-body p {
            font-size: 15px;
            line-height: 1.7;
            color: #D4D0C8;
            margin: 0 0 16px;
        }
        .email-body .highlight {
            color: #C9973A;
        }
        .email-body .detail-box {
            background-color: #1A1A1A;
            border-left: 3px solid #C9973A;
            padding: 20px 24px;
            margin: 24px 0;
        }
        .email-body .detail-box p {
            margin: 0 0 8px;
            font-size: 14px;
        }
        .email-body .detail-box p:last-child {
            margin-bottom: 0;
        }
        .email-body .detail-label {
            font-family: 'Trebuchet MS', Helvetica, sans-serif;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: #8A8478;
            display: block;
            margin-bottom: 4px;
        }
        .email-body .detail-value {
            color: #F5F0E8;
            font-size: 15px;
        }
        .cta-button {
            display: inline-block;
            background-color: #C9973A;
            color: #0A0A0A !important;
            font-family: 'Trebuchet MS', Helvetica, sans-serif;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            text-decoration: none;
            padding: 14px 32px;
            margin: 24px 0;
        }
        .email-footer {
            padding: 30px 40px;
            border-top: 1px solid rgba(201, 151, 58, 0.2);
            text-align: center;
        }
        .email-footer p {
            font-family: 'Trebuchet MS', Helvetica, sans-serif;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #8A8478;
            margin: 0 0 8px;
        }
        .email-footer a {
            color: #C9973A;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>APEX HUMAN&#8482;</h1>
        </div>

        <div class="email-body">
            @yield('content')
        </div>

        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Apex Human&#8482; &middot; All Rights Reserved</p>
            <p><a href="https://apexhuman.co">apexhuman.co</a></p>
        </div>
    </div>
</body>
</html>
