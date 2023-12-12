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
$signup_email = $_POST['email'];

// 아이디 중복 체크
$check_duplicate_sql = "SELECT * FROM user WHERE user_id = '$signup_id'";
$check_duplicate_result = mysqli_query($conn, $check_duplicate_sql);

if (mysqli_num_rows($check_duplicate_result) > 0) {
    echo '<script>alert("ID is already in use. Please select another ID.");</script>';
    echo '<script>history.back();</script>';
} else {
    // 아이디 중복이 아니면 회원가입 진행
    $sql = "INSERT INTO user VALUES ('$signup_id', '$signup_pass', '$signup_nickname')";
    
    if ($signup_id == "" || $signup_nickname == "" || $signup_pass == "") {
        echo '<script>alert("There is an empty item.");</script>';
        echo '<script>history.back();</script>';
    } else {
        mysqli_query($conn, $sql);

        $insert_email_sql = "INSERT INTO user_email (e_user_id, email) VALUES ('$signup_id', '$signup_email')";
        mysqli_query($conn, $insert_email_sql);

        echo '<script>alert("Membership registration has been completed.");</script>';
        echo "<script>location.replace('login.php');</script>";
    }
}
?>