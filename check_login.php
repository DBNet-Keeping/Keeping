<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title></title>
</head>
<body>
   <?php
   session_start();

   include_once 'dbconfig.php';
   
   $db_name = 'keeping';
   mysqli_select_db($conn, $db_name);

      $mysqli = new mysqli($host, $user, $pw, $db_name); //db 연결
      //login.php에서 입력받은 id, password
      $username = $_POST['id'];
      $userpass = $_POST['pw'];
      
      $sql = "SELECT * FROM user WHERE user_id = '$username' AND password = '$userpass'";
      $result = $mysqli->query($sql);
      $row = $result->fetch_array(MYSQLI_ASSOC);
      
      //결과가 존재하면 세션 생성
      if ($row != null) {
         $_SESSION['username'] = $row['user_id'];
         $_SESSION['name'] = $row['name'];
         echo "<script>location.replace('home.php');</script>";
         exit;
      }
      
      //결과가 존재하지 않으면 로그인 실패
      if($row == null){
         echo "<script>alert('Invalid username or password')</script>";
         echo "<script>location.replace('login.php');</script>";
         exit;
      }
   ?>
   </body>