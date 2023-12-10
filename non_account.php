<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'dbconfig.php';

$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

// 사용자의 user_id를 세션에서 가져옴
$user_id = $_SESSION['username'];

// 사용자의 계좌 정보를 가져오는 쿼리
$getAccountQuery = "SELECT * FROM account WHERE a_user_id = '$user_id'";
$result = $conn->query($getAccountQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="updateBalance.js"></script>
    <link rel=stylesheet href='account.css' type='text/css'>
    <link rel=stylesheet href='assets\navbar.css' type='text/css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>계좌 관리</title>
</head>
<body>
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>
<form method="get" action="" class="accountForm">
    <h1>Account Management</h1>

    <h2>Account List</h2>
    <?php
        $result = $conn->query($getAccountQuery);
        $totalBalance = 0; // 총액을 저장할 변수 초기화

        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if($row['deposit_and_withdrawal_status']==0){
                echo "<div class='account-info'>";
                echo "<p>";
                echo $row['bank_name'] . "   ";
                echo $row['account_number'] . "<br>";
                echo "Balance : " . $row['balance'] . " ₩<br>";
                echo "<br>";
                // 계좌 금액을 총액에 더함
                $totalBalance += $row['balance'];
            }
        }
    } else {
        echo "NULL.";
    }

    // 총액 표시
    echo "<p>Total Balance: " . $totalBalance . " ₩</p>";
?>
</form>

</body>
</html>