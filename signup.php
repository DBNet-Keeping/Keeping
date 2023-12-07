<link rel=stylesheet href='signup.css' type='text/css'>
<form method="post" action="check_signup.php" class="signupForm">
    <h2>SIGN UP</h2>
    <div class="idForm">
      <input type="text" name="id" class="id" placeholder="Username">
    </div>
    <div class="emailForm">
      <input type="text" name="email" class="id" placeholder="e-mail">
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