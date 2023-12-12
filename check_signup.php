<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include_once 'dbconfig.php';
$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

$signup_id = $_POST['id'];
$signup_pass = $_POST['pw'];
$signup_nickname = $_POST['nickname'];

// 아이디 중복 체크
$check_duplicate_sql = "SELECT * FROM user WHERE user_id = '$signup_id'";
$check_duplicate_result = mysqli_query($conn, $check_duplicate_sql);

if (mysqli_num_rows($check_duplicate_result) > 0) {
    echo '<script>alert("이미 사용 중인 아이디입니다. 다른 아이디를 선택해주세요.");</script>';
    echo '<script>history.back();</script>';
} else {
    // 아이디 중복이 아니면 회원가입 진행
    $sql = "INSERT INTO user VALUES ('$signup_id', '$signup_pass', '$signup_nickname')";
    
    if ($signup_id == "" || $signup_nickname == "" || $signup_pass == "") {
        echo '<script>alert("비어있는 항목이 있습니다.");</script>';
        echo '<script>history.back();</script>';
    } else {
        mysqli_query($conn, $sql);
        echo '<script>alert("회원 가입이 완료되었습니다.");</script>';
        echo "<script>location.replace('login.php');</script>";
    }
}
?>
