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

// 사용자가 POST을 보낸 경우
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['subbtn'])){
        $subname = $_POST['subname'];
        $paydate = $_POST['paydate'];
        $payunit = intval($_POST['payunit']);
        $paycycle = $_POST['paycycle'];
        $payprice = $_POST['payprice'];

        // 중복된 구독 정보(subscription_ID) 체크
        $checkDuplicateQuery = "SELECT * FROM subscription WHERE subscription_name = '$subname' AND s_user_id = '$userid'";
        $duplicateResult = $conn->query($checkDuplicateQuery);

        if($duplicateResult->num_rows > 0){
            echo "<script>alert('[Error] Subscription information that already exists')</script>";
        }else{
             $insertSubscriptionQuery = "INSERT INTO subscription (subscription_name, payment_date, payment_cycle, payment_price, s_user_id, payment_unit) VALUES ('$subname','$paydate','$paycycle','$payprice','$userid','$payunit')";

            if($conn->query($insertSubscriptionQuery) === TRUE) {
                echo "<script>alert('[Success] Successfully added a subscription!')</script>";
            } else {
                echo "<script>alert('[Error] Add Subscription Failed')</script>";
            }
        }
        echo '<script>window.location.href = "subscription.php";</script>';
    }

    // 구독 정보 삭제
    if(isset($_POST['subDbtn'])){
        $deletesubname = $_POST['subDname'];

        // 사용자의 구독 정보를 삭제하는 쿼리
        $deletesubQuery = "DELETE FROM subscription WHERE subscription_name = '$deletesubname' AND s_user_id = '$userid'";

        if ($conn->query($deletesubQuery) === TRUE) {
            echo "<script>alert('[Success] Successfully deleted subscription!')</script>";
        } else {
            echo "<script>alert('[Error] Subscription deletion failed')</script>" . $conn->error;
        }
        echo '<script>window.location.href = "subscription.php";</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keeping</title>
    <link rel=stylesheet href='assets\subscription.css' type='text/css'>
    <link rel=stylesheet href='assets\navbar.css' type='text/css'>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="assets\calendar.css">
    <script src="assets\calendar.js" defer></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=Noto+Sans+KR:wght@300&display=swap" rel="stylesheet">

</head>
<body style="
    height: 1px; width: 1px;">
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>
    <h2 id="title">- SUBSCRIPTION</h2>
    <span id="calender_id">
        <div class='body-class'>
            <div class="wrapper">
                <header id="header">
                    <p class="current-date"></p>
                    <div class="icons">
                        <span id="prev" class="material-symbols-rounded">chevron_left</span>
                        <span id="next" class="material-symbols-rounded">chevron_right</span>
                    </div>
                </header>
                <div class="calendar">
                    <ul class="weeks">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                    </ul>
                    <ul class="days"></ul>
                </div>
            </div>
        </div>
        <div id="subinfoform">
                <form method="POST" action="subscription.php" class="subForm" id="subForm">
                    <h2 id="subTitle">- SUBSCRIPTION REGISTER</h2>
                    <div class="SubnameForm">
                        <index>subscription name</index>
                        <input type="text" name="subname" class="subname" placeholder="Please enter subscription name" id="subname">
                    </div>
                    <div class="PaydateForm">
                        <index>last payment date</index>
                        <input type="date" name="paydate" class="pay" id="paydate">
                    </div>
                    <div class="PaycycleForm">
                        <index id="cycleindex1">payment cycle</index>
                        <input type="int" name="paycycle" class="pay" id="paycycle">
                        <input type="radio" id="unit1" name="payunit" class="unitclass" style="display: none;" value = "0"><label for="unit1">month</label>
                        <input type="radio" id="unit2" name="payunit" class="unitclass" style="display: none;" value = "1"><label for="unit2">day</label>
                    </div>
                    <div class="PaypriceForm">
                        <index>subscription price</index>
                        <input type="int" name="payprice" class="pay" placeholder="Please enter subscription price (only number) " id="price">
                    </div>
                    <div class="submitBtn">
                        <input type="submit" name='subbtn' class="btn" id="subbtn" value="SUBMIT">
                    </div>
                </form>
                <div id="subinfoprint">
                    <h3>LIST</h3>
                    <div id="subInfo">
                        <?php
                            // 사용자의 구독 정보를 가져오는 쿼리
                            $getSubscriptionQuery = "SELECT subscription_name, payment_date, payment_cycle, payment_price, payment_unit FROM subscription WHERE s_user_id = '$userid' ORDER BY payment_price DESC";
                            $getSubscriptionResult = $conn->query($getSubscriptionQuery);

                            while($sub_row = $getSubscriptionResult->fetch_assoc()) {
                                $sub_pay = $sub_row["payment_date"];
                                $sub_cycle = $sub_row["payment_cycle"];
                                $sub_unit = $sub_row["payment_unit"];
                                $sub_price = $sub_row["payment_price"];

                                // 마지막 결제 날짜를 DateTime 객체 변환
                                $lastPaymentDateObj  = new DateTime($sub_pay);

                                if($sub_unit == 0){
                                    $sub_unitChar = "M";
                                }else if($sub_unit == 1){
                                    $sub_unitChar = "D";
                                }

                                // 다음 날짜 계산
                                $nextPaymentDate = new DateInterval("P{$sub_cycle}{$sub_unitChar}");

                                // 정기 결제 계산
                                if($sub_unit == 0){
                                    $nextPaymentDateObj = clone $lastPaymentDateObj;
                                    $nextPaymentDateObj->add($nextPaymentDate);
                                } else if($sub_unit == 1){
                                    $nextPaymentDateObj = clone $lastPaymentDateObj;
                                    $nextPaymentDateObj = $nextPaymentDateObj->add($nextPaymentDate);
                                } else{
                                    echo "Error by invalid payment unit";
                                }
                                // 이번 달에 해당하는 결제 예정만 보여줌
                                if($nextPaymentDateObj->format('n') == date('n')){
                                    echo "<p>";
                                    echo "＃ ", $sub_row["subscription_name"];
                                    echo " (", $nextPaymentDateObj->format("m/d"), ") &nbsp;  - ₩ ", $sub_price,"\n";
                                }
                            }
                        ?>
                    </div>
                </div>
                <div id="subdeleteForm">
                <h2 id="subDtitle">- DELETE</h2>
                <form method="POST" action="subscription.php" class="subDForm" id="subDForm">
                    <div class="SubnameDForm">
                        <index id="Dindex">subscription name</index>
                        <input type="text" name="subDname" class="subname" placeholder="Please enter subscription name" id="subDname">
                    </div>
                    <div class="submitBtn">
                        <input type="submit" name='subDbtn' class="btn" id="subDbtn" value="SUBMIT">
                    </div>
                </form>
                </div>
            </div>
            <div class="background-image"><img src='assets\image\004.png' id="backimg"></div>
    </span>
    <span class="container-fluid" id="footer">
        copyright ⓒ DBNet 2023.
    </span>
</body>
</html>