<?php
error_reporting(E_ALL);             // 모든 에러 표시 설정
ini_set("display_errors",1);
session_start();                    // 세션 시작
include_once 'dbconfig.php';        // 데이터베이스 설정 파일 포함

// 데이터베이스 선택
$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

$userid = $_SESSION['username'];





$sql = "SELECT nickname FROM user WHERE user_id = '$userid'";
$result = $conn->query($sql);


// DB 연결 종료
$conn->close();
?>