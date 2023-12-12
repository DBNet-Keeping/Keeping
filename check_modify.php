<?php
session_start();
$loggedInUserId = $_SESSION['username'];

error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'dbconfig.php';

$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

// 폼에서 전달된 데이터 받기
$newNickname = $_POST['new_nickname'];
$oldPassword = $_POST['old_pw'];
$newPassword = $_POST['new_pw'];
$newPasswordConfirm = $_POST['new_password_confirm'];

// 이메일과 비밀번호가 입력되었는지 확인
if ($newNickname == "" || $oldPassword == "" || $newPassword == "" || $newPasswordConfirm == "") {
    echo "비어있는 항목이 있습니다.";
    exit;
}

// 옛날 비밀번호 확인
$checkOldPasswordSql = "SELECT * FROM user WHERE user_id = '$loggedInUserId' AND password = '$oldPassword'";
$checkOldPasswordResult = mysqli_query($conn, $checkOldPasswordSql);

if (mysqli_num_rows($checkOldPasswordResult) > 0) {
    // 옛날 비밀번호 일치하는 경우, 회원 정보 업데이트
    $updateUserInfoSql = "UPDATE user SET nickname = '$newNickname', password = '$newPassword' WHERE user_id = '$loggedInUserId'";
    
    if ($conn->query($updateUserInfoSql) === TRUE) {
        echo "회원 정보가 성공적으로 수정되었습니다.";
        echo "<script>location.replace('home.php');</script>";
    } else {
        echo "오류: " . $conn->error;
    }
} else {
    echo "옛날 비밀번호가 일치하지 않습니다.";
}

// DB 연결 종료
$conn->close();
?>
