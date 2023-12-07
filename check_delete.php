<?php
session_start();
$loggedInUserId=$_SESSION['username'];

error_reporting( E_ALL );
ini_set( "display_errors", 1 );
include_once 'dbconfig.php';

$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

$sql = "DELETE FROM user WHERE user_id ='$loggedInUserId'";

if ($conn->query($sql) === TRUE) {
    echo "회원이 성공적으로 삭제되었습니다.";
    echo "<script>location.replace('login.php');</script>";
} else {
    echo "오류: " . $conn->error;
}

// DB 연결 종료
$conn->close();
?>