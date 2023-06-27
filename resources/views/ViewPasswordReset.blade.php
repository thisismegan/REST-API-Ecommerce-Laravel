<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>

<body>
    <h1>Password Reset</h1>

    please click link below to reset your password.:
    <a href="{{ route('check_token',['email'=>$email,'token'=>$token]) }}">Reset Password</a>
</body>

</html>