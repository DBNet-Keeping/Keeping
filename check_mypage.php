<?php
session_start();
$loggedInUserId = $_SESSION['username'];
$loggedInNickname = $_SESSION['nickname'];

error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'dbconfig.php';

$db_name = 'keeping';
mysqli_select_db($conn, $db_name);

$sql = "SELECT nickname FROM user WHERE user_id = '$loggedInUserId'";
$result = $conn->query($sql);


// DB 연결 종료
$conn->close();
?>