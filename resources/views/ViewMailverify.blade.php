<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>

<body>
    <h1>Email Verification</h1>

    please verify your email address below.:
    <a href="{{ route('mail.activate',$token) }}">Verify Email</a>
</body>

</html>