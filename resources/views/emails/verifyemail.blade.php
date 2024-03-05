<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
</head>
<body>
    <h2>Hello {{$data['username']}}</h2>
    <p>Welcome to creatorpage. You know the drill. Click the link below to verify your email address.</p>
    <a href="http://127.0.0.1:3000/verify/email?emailcode={{ urlencode($data['emailverification_code']) }}">Click here</a>

    
    
    
</body>
</html>