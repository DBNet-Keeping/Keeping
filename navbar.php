<html lang="en">
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="assets\navbar.js"></script>
  <link rel=stylesheet href='assets\navbar.css' type='text/css'>
  <div class="container-fluid" id="topbar">
    <nav>
      <ul class="bar-ul" id="top-ul">
        <li>
          <a href="home.php"><img id="logo" src="assets\image\logo.png" /></a>
        </li>
        <li id="logout-li">
          <a id="logout" href="logout.php">LOGOUT</a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="sidebar">
    <ul class="bar-ul">
      <li class="home_li"><a class="side" href="home.php" id="home">HOME</a></li>
      <li class="home_li"><a class="side" href="transaction.php" id="transaction">TRANSACTION</a></li>
      <li class="home_li"><a class="side" href="category.php" id="category">CATEGORY</a></li>
      <li class="home_li"><a class="side" href="subscription.php" id="subscription">SUBSCRIPTION</a></li>
      <li class="home_li"><a class="side" href="mypage.php" id="mypage">MY PAGE</a></li>
    </ul>
  </div>
</html>
