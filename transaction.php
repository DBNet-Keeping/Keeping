<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>transaction</title>
    <link rel=stylesheet href='assets/navbar.css' type='text/css'>
    <link rel=stylesheet href='transaction.css' type='text/css'>
    
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <!-- script -->
    <script src="transaction.js"></script>

</head>
<body>
    <span id="navbar">
        <?php include 'navbar.php'; ?>
    </span>

    <div class="content">
        <div class="title">
            <p id="transaction_title">TRANSACTION<a href="register.php" class="register">+ REGISTER</a></p>
        </div>
        
        <br><br>

        <div class="transaction_result">
            <?php
            session_start();
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            include_once 'dbconfig.php';

            $db_name = 'keeping';
            mysqli_select_db($conn, $db_name);

            $user_id = $_SESSION['username'];

            if (isset($_POST['currentMonth'])) {
                $currentMonth = $_POST['currentMonth'];
                $_SESSION['currentMonth'] = $currentMonth;
            } elseif (isset($_SESSION['currentMonth'])) {
                $currentMonth = $_SESSION['currentMonth'];
            } else {
                $currentMonth = date('n');
            }
            echo "<p>Current Month: " . $currentMonth . "</p>";
            ?>
            <form action="" method="post" class="monthForm" id="monthForm">
                <span onclick="changeMonth(-1)">&#9664;</span>
                <span id="currentMonth"><?php echo $currentMonth; ?></span>월
                <input type="hidden" name="currentMonth" id="hiddenCurrentMonth" value="<?php echo $currentMonth; ?>">
                <span onclick="changeMonth(1)">&#9654;</span>
                <input type="submit" name="Check" value="Submit">
            </form>
            <?php
            $TransactionResultQuery = "SELECT 
                                            CASE DAYOFWEEK(t.date_t)
                                                when '1' then 'Sun'
                                                when '2' then 'Mon'
                                                when '3' then 'Tue'
                                                when '4' then 'Wed'
                                                when '5' then 'Thu'
                                                when '6' then 'Fri'
                                                when '7' then 'Sat'
                                            END AS 요일, MONTH(t.date_t) AS 월, DAY(t.date_t) AS 일, t.deposit_or_withdrawal AS 입출금, t.price AS 가격, t.client AS 거래처, c.category_name AS 카테고리명
                                        FROM transaction t
                                        JOIN category c ON t.t_category_id = c.category_id
                                        where t.t_user_id = '$user_id'
                                        AND MONTH(t.date_t) = '$currentMonth'
                                        ORDER BY DAY(t.date_t)";

            $result = $conn->query($TransactionResultQuery);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='transaction-info'>";
                    echo "<p>";
                    echo $row['일'] . "   ";
                    echo $row['요일'] . "   <br>";
                    echo "<hr>";
                    echo $row['입출금'] . " ";
                    echo $row['가격'] . " ₩                     ";
                    echo $row['거래처'] . "                      ";
                    echo $row['카테고리명'] . "   ";
                    echo "<br><br>";
            
                    echo "------------------------------------";
                    echo "</p>";

                }
            }
            else {
                echo "NULL.";
            }
            ?>

        </div>
    </div>

</body>
</html>