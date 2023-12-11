<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'dbconfig.php';

$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

// 사용자의 user_id를 세션에서 가져옴
$user_id = $_SESSION['username'];
        
// 사용자가 폼을 통해 거래 추가한 경우
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 폼으로부터 받은 계좌 정보
    if (isset($_POST['addTransaction'])) {
        $date_t = $_POST['date_t'];
        $deposit_or_withdrawal = $_POST['deposit_or_withdrawal'];
        $price = $_POST['price'];
        $client = $_POST['client'];
        $si = $_POST['si'];
        $dong = $_POST['dong'];
        $detail_location = $_POST['detail_location'];
        $memo = $_POST['memo'];
        $t_account_number = $_POST['t_account_number'];
        $t_category_id = $_POST['category_id'];

        // 사용자의 계좌 정보를 추가하는 쿼리
        $insertTransactionQuery = "INSERT INTO transaction (date_t, deposit_or_withdrawal, price, client, si, dong, detail_location, memo, t_account_number, t_user_id, t_category_id) 
                                    VALUES ('$date_t', '$deposit_or_withdrawal', $price, '$client', '$si', '$dong', '$detail_location', '$memo', '$t_account_number', '$user_id', $t_category_id)";

        if ($conn->query($insertTransactionQuery) === TRUE) {
                    echo "<script>alert('거래 추가에 성공했습니다.');
                    location.replace("transaction.php");</script>";

        } else {
            echo "<script>alert('거래 추가 실패 : ')</script>" . $conn->error;
        }
    }
}
// 사용자 거래 정보 가져오는 쿼리*
$getTransactionQuery = "SELECT t.transaction_id AS 거래id, t.date_t AS 날짜, t.deposit_or_withdrawal AS 입출금, t.price AS 가격, t.client AS 거래처, c.category_name AS 카테고리명
                        FROM transaction t, category c
                        WHERE t.t_user_id = '$user_id'
                        AND c.category_id = t.t_category_id";

$result = $conn->query($getTransactionQuery);

?>