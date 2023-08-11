<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
        }
        h1 {
            margin-top: 0;
            text-align: center;
        }
        .message {
            margin-top: 20px;
        }
        .message p {
            margin-bottom: 10px;
        }
        .message strong {
            font-weight: bold;
        }
        .message a {
            color: #0055ff;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Form</h1>
        <div class="message">
            {{-- <p><strong>Name:</strong> {!! $full_name !!}</p>
            <p><strong>Email:</strong> {!! $email !!}</p>
            <p><strong>Phone:</strong> {!! $phone_number !!}</p>
            <p><strong>Subject:</strong> {!! $subject !!}</p>
            <p><strong>Message:</strong> {!! $message !!}</p> --}}
            {{-- {{ $data }} --}}
        </div>
    </div>
    <footer>
        <p>&copy; {{ date('Y') }} Shadomby. All rights reserved.</p>
    </footer>
</body>
</html>
