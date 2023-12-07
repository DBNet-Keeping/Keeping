<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <title>LOGIN</title>
  <link rel=stylesheet href='login.css' type='text/css'>
</head>
<body>
<img src="login_logo.png" alt="로고">
  <form class="login_page" method="post" action="check_login.php" class="loginForm">
    <h2 class="login">LOGIN</h2>
    <div class="idForm">
      <input type="text" name="id" class="id" placeholder="Username">
    </div>
    <div class="passForm">
      <input type="password" name="pw" class="pw" placeholder="Password">
    </div>
    <button type="submit" class="btn" onclick="button()">
      LOGIN
    </button>
    <div class="bottonText">
      <a href="signup.php">SIGN UP</a>
    </div>
  </form>
</body>
</html>