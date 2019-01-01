<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<h2>Verify Your Email Address</h2>

<div>
    Thanks for creating an account!.
    Please click <b><a href="{{ URL::to('register/verify/' . $confirmation_code) }}" >here</a></b> to verify your email address
    <br/>

</div>

</body>
</html>