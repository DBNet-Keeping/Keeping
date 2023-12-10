<?php
session_start();                    // 세션 시작
error_reporting(E_ALL);             // 모든 에러 표시 설정
ini_set("display_errors",1);
include_once 'dbconfig.php';        // 데이터베이스 설정 파일 포함

// 데이터베이스 선택
$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

// 사용자의 user id를 세션에서 가져옴
$userid = $_SESSION['username'];

// 사용자가 폼을 통해 구독 정보를 추가한 경우
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['subbtn'])){
        $subname = $_POST['subname'];
        $paydate = $_POST['paydate'];
        $paycycle = $_POST['paycycle'];
        $payprice = $_POST['payprice'];

        // 중복된 구독 정보(subscription_ID) 체크
        $checkDuplicateQuery = "SELECT * FROM subscription WHERE subscription_name = '$subname' AND s_user_id = '$userid'";
        $duplicateResult = $conn->query($checkDuplicateQuery);

        if($duplicateResult->num_rows > 0){
            echo "<script>alert('[Error] Subscription information that already exists')</script>";
        }else{
             $insertSubscriptionQuery = "INSERT INTO subscription (subscription_name, payment_date, payment_cycle, payment_price, s_user_id) VALUES ('$subname','$paydate','$paycycle','$payprice','$userid')";

            if($conn->query($insertSubscriptionQuery) === TRUE) {
                echo "<script>alert('[Success] Successfully added a subscription!')</script>";
            } else {
                echo "<script>alert('[Error] Add Subscription Failed')</script>";
            }
        }
        echo '<script>window.location.href = "subscription.php";</script>';
    }
}
?>