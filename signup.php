<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel=stylesheet href='signup.css' type='text/css'>
</head>
<body>
<form method="post" action="check_signup.php" class="signupForm">
    <h2>SIGN UP</h2>
    <div class="idForm">
      <input type="text" name="id" class="id" placeholder="Username">
    </div>
    <div class="EmailForm">
      <input type="text" class="email" name="email" placeholder="Email">
    </div>
    <div class="nicknameForm">
      <input type="text" name="nickname" class="id" placeholder="Nickname">
    </div> 
    <div class="passForm">
      <input type="password" name="pw" class="pw" placeholder="Password">
    </div>
    <div class="confirmpassForm">
      <input type="password" class="pw" placeholder="Confirm Password">
    </div>
    <button type="submit" class="btn" onclick="button()">
      SIGN UP
    </button>
  </form>
</body>
</html>