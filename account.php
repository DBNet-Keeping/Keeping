<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'dbconfig.php';

$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

// 사용자의 user_id를 세션에서 가져옴
$user_id = $_SESSION['username'];

// 사용자가 폼을 통해 계좌 추가한 경우
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 폼으로부터 받은 계좌 정보
    if (isset($_POST['addAccount'])) {
        $account_num = $_POST['account_num'];
        $bank_name = $_POST['bank_name'];
        $balance = $_POST['balance'];
        $deposit_and_withdrawal_status = $_POST['deposit_and_withdrawal_status'];

        // 중복된 account_num 체크
        $checkDuplicateQuery = "SELECT * FROM account WHERE account_number = '$account_num' AND a_user_id = '$user_id'";
        $duplicateResult = $conn->query($checkDuplicateQuery);

        if ($duplicateResult->num_rows > 0) {
            echo "<script>alert('이미 존재하는 계좌 번호입니다.')</script>";
        } else {
            // Map bank_name to a_bank_id
            $bankIdMap = [
                'NH' => 1,
                'ShinHan' => 2,
                'Shin' => 3,
                'KB' => 4,
                'SC' => 5,
                'Kakaobank' => 6,
            ];

            // Get a_bank_id based on the selected bank_name
            $a_bank_id = isset($bankIdMap[$bank_name]) ? $bankIdMap[$bank_name] : null;

            // 사용자의 계좌 정보를 추가하는 쿼리
            $insertAccountQuery = "INSERT INTO account (account_number, balance, deposit_and_withdrawal_status, a_user_id, a_bank_id) VALUES ('$account_num', $balance, '$deposit_and_withdrawal_status', '$user_id', $a_bank_id)";

            if ($conn->query($insertAccountQuery) === TRUE) {
                echo "<script>alert('계좌 추가에 성공했습니다')</script>";
            } else {
                echo "<script>alert('계좌 추가 실패 : ')</script>" . $conn->error;
            }
        }
    }

    // 폼으로부터 받은 삭제할 계좌 번호
    if (isset($_POST['deleteAccount'])) {
        $deleteAccountNum = $_POST['deleteAccountNum'];

        // 사용자의 계좌 정보를 삭제하는 쿼리
        $deleteAccountQuery = "DELETE FROM account WHERE account_number = '$deleteAccountNum' AND a_user_id = '$user_id'";

        if ($conn->query($deleteAccountQuery) === TRUE) {
            echo "<script>alert('계좌가 성공적으로 삭제되었습니다')</script>";
        } else {
            echo "<script>alert('계좌 삭제에 실패 : ')</script>" . $conn->error;
        }
    }
}

// 사용자의 계좌 정보를 가져오는 쿼리
$getAccountQuery = "SELECT a.*, b.bank_name, b.bank_img FROM account a JOIN bank b ON a.a_bank_id = b.bank_id WHERE a.a_user_id = '$user_id'";
$result1 = $conn->query($getAccountQuery);
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
<form method="post" action="" class="accountForm">
    <h1>Account Management</h1>

    <h2>Add Account</h2>
    <input type="text" name="account_num" class="account_num" placeholder="account num"><br>
    <select name="bank_name" class="bank_name">
        <option value="NH">NH</option>
        <option value="ShinHan">ShinHan</option>
        <option value="Shin">Shin</option>
        <option value="KB">KB</option>
        <option value="SC">SC</option>
        <option value="Kakaobank">Kakaobank</option>
    </select><br>
    <input type="text" name="balance" class="balance" placeholder="balance"><br>
    <input type="text" name="deposit_and_withdrawal_status" class="deposit_and_withdrawal_status" placeholder="deposit_and_withdrawal_status"><br>
    <br>
    <input type="submit" name="addAccount" value="add account">
    <h2>Account List</h2>
    <?php
        $result1 = $conn->query($getAccountQuery);
        $totalBalance = 0;

        while ($row1 = $result1->fetch_assoc()) {
            echo "<div class='account-info'>";
            echo "<p>";
            $bankImage = $row1['bank_img'];
            echo "<img src='$bankImage' alt='Bank Image'><br>";
            echo "<p>";
            echo $row1['bank_name'] . "   ";
            echo $row1['account_number'] . "<br>";
            echo "Balance : " . $row1['balance'] . " ₩<br>";
            echo "deposit_and_withdrawal_status " . ($row1['deposit_and_withdrawal_status'] == 1 ? "O" : "X") . "<br>";
            echo "<br>";

            // 계좌 금액을 총액에 더함
            $totalBalance += $row1['balance'];

            // 삭제 폼 추가
            echo "<form method='post' action='' class='delete-form'>";
            echo "<input type='hidden' name='deleteAccountNum' value='" . $row1['account_number'] . "'>";
            echo "<input type='submit' name='deleteAccount' value='delete account'>";
            echo "</form>";

            echo "------------------------";
            echo "</p>";
        }

        if ($result1->num_rows == 0) {
        echo "NULL.";
    }

    // 총액 표시
    echo "<p>Total Balance: " . $totalBalance . " ₩</p>";
?>
</form>
</body>
</html>