<!DOCTYPE html>
<html>
<head>
    <title>Contact Information</title>
</head>
<body>
    <h2>Contact Information</h2>
    @if ($data['fullname'])
        <p>Name: {{ $data['fullname'] }}</p>
    @endif
    @if ($data['email'])
        <p>Email: {{ $data['email'] }}</p>
    @endif
    @if ($data['phone'])
        <p>phone: {{ $data['phone'] }}</p>
    @endif
    @if ($data['country'])
        <p>country: {{ $data['country'] }}</p>
    @endif
    @if ($data['message'])
        <p>Message: {{ $data['message'] }}</p>
    @endif
    
    
</body>
</html>