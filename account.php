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

        // 사용자의 계좌 정보를 추가하는 쿼리
        $insertAccountQuery = "INSERT INTO account (account_number, bank_name, balance, deposit_and_withdrawal_status, a_user_id) VALUES ('$account_num', '$bank_name', $balance, '$deposit_and_withdrawal_status', '$user_id')";

        if ($conn->query($insertAccountQuery) === TRUE) {
            echo "계좌가 성공적으로 추가되었습니다.";
        } else {
            echo "계좌 추가에 실패했습니다: " . $conn->error;
        }
    }

    // 폼으로부터 받은 삭제할 계좌 번호
    if (isset($_POST['deleteAccount'])) {
        $deleteAccountNum = $_POST['deleteAccountNum'];

        // 사용자의 계좌 정보를 삭제하는 쿼리
        $deleteAccountQuery = "DELETE FROM account WHERE account_number = '$deleteAccountNum' AND a_user_id = '$user_id'";

        if ($conn->query($deleteAccountQuery) === TRUE) {
            echo "계좌가 성공적으로 삭제되었습니다.";
        } else {
            echo "계좌 삭제에 실패했습니다: " . $conn->error;
        }
    }
}

// 사용자의 계좌 정보를 가져오는 쿼리
$getAccountQuery = "SELECT * FROM account WHERE a_user_id = '$user_id'";
$result = $conn->query($getAccountQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>계좌 관리</title>
</head>
<body>
<h1>계좌 관리</h1>

<h2>계좌 추가</h2>
<form method="post" action="">
    <label for="account_num">계좌 번호:</label>
    <input type="text" name="account_num" required><br>

    <label for="bank_name">은행 이름:</label>
    <input type="text" name="bank_name" required><br>

    <label for="balance">잔액:</label>
    <input type="text" name="balance" required><br>

    <label for="deposit_and_withdrawal_status">입출금 가능여부:</label>
    <input type="text" name="deposit_and_withdrawal_status" required><br>

    <input type="submit" name="addAccount" value="계좌 추가">
</form>

<h2>계좌 목록</h2>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>";
        echo "계좌 번호: " . $row['account_number'] . "<br>";
        echo "은행 이름: " . $row['bank_name'] . "<br>";
        echo "잔액 : " . $row['balance'] . " ₩<br>";
        echo "입출금 가능여부: " . ($row['deposit_and_withdrawal_status'] == 1 ? "O" : "X") . "<br>";

        // 삭제 폼 추가
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='deleteAccountNum' value='" . $row['account_number'] . "'>";
        echo "<input type='submit' name='deleteAccount' value='계좌 삭제'>";
        echo "</form>";

        echo "------------------------";
        echo "</p>";
    }
} else {
    echo "계좌가 없습니다.";
}
?>
</body>
</html>