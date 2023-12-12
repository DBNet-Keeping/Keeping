<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keeping</title>
    <link rel=stylesheet href='mypage.css' type='text/css'>
    <link rel=stylesheet href='assets\navbar.css' type='text/css'>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <!-- DB Connection -->
</head>
<body>
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>
    <?php
    session_start();

    // check_mypage.php에서 얻은 사용자 아이디와 이메일을 읽어옴
    $loggedInUserId = $_SESSION['username'];
    $loggedInNickname = $_SESSION['nickname'];

    // 여기에 추가적으로 필요한 코드를 작성하세요
    ?>
    <div class="content">
        <h1>My Page</h1>
        <br>
        <br>
        <img src="user_img.png" alt="회원 사진" class="user_img">
        <h1>HI! <?php echo $loggedInNickname; ?></h1>
        <br>
        <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include_once 'dbconfig.php';

    $db_name = 'keeping';
    mysqli_select_db($conn, $db_name);

    // 이미 로그인한 사용자의 ID로 가정
    $loggedInUserId = "test1212";

    $getEmailQuery = "SELECT email FROM user_email WHERE e_user_id = '$loggedInUserId'";
    $result = $conn->query($getEmailQuery);

    while ($row = $result->fetch_assoc()) {
        echo "<div class='account-info'>";
        echo "<h3>";
        echo $row['email'] . "    ";
        echo "</h3>";
    }
?>

<form method="post" action="">
    <input type="text" name="add_email" class="add_email" placeholder="Add Email"><br>
    <br>
    <input type="submit" name="addEmail" value="add email" class="btn_add_email">
</form>

<?php
    if(isset($_POST['addEmail'])){
        $New_email = $_POST['add_email'];
        $insertAccountQuery = "INSERT INTO user_email (e_user_id, email) VALUES ('$loggedInUserId', '$New_email')";
        
        $result = $conn->query($insertAccountQuery);
    }
?>

        <a href="modify.php" class="modify">Modify Member Information</a>
        <br>
        <br>
        <a href="delete.php" class="delete">Unregister</a>
        <div class="budget">
            <br>
            <br>
            <h1>BUDGET</h1>
            <h3><a href="account.php">Total account</a></h3>
            <h3><a href="yes_account.php">Deposit and withdrawal account</a></h3>
            <h3><a href="non_account.php">Non-Deposit and withdrawal account</a></h3>
        </div>
    </div>

</body>
</html>