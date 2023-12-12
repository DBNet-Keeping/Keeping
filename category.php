<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="assets/navbar.css" type="text/css">
    <link rel="stylesheet" href="category.css" type="text/css">
    
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Script -->
    <script src="category.js"></script>

    <style>
        .chart-container {
            width: 400px;
            height: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
    <span id="navbar">
        <?php include 'navbar.php'; ?>
    </span>

    <div class="content">
        <div class="title">
            <p id="transaction_title">CATEGORY</p>
        </div>
        
        <br><br>

        <div class="category_result">
            <?php
            session_start();
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            include_once 'dbconfig.php';

            $db_name = 'keeping';
            mysqli_select_db($conn, $db_name);

            $user_id = $_SESSION['username'];
            $currentMonth = date('n'); // 현재 월을 기본값으로 설정

            if (isset($_POST['currentMonth'])) {
                $currentMonth = $_POST['currentMonth'];
                $_SESSION['currentMonth'] = $currentMonth;
            } elseif (isset($_SESSION['currentMonth'])) {
                $currentMonth = $_SESSION['currentMonth'];
            }

            $categoryQuery = "SELECT c.category_name, 
                                     SUM(CASE 
                                         WHEN t.deposit_or_withdrawal = '+' THEN t.price 
                                         WHEN t.deposit_or_withdrawal = '-' THEN -t.price 
                                         ELSE 0 
                                     END) AS total_price
                              FROM transaction t
                              JOIN category c ON t.t_category_id = c.category_id
                              WHERE t.t_user_id = '$user_id' AND MONTH(t.date_t) = '$currentMonth'
                              GROUP BY c.category_name";

            $result = $conn->query($categoryQuery);
            $categories = array();
            $prices = array();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row['category_name'];
                    $prices[] = $row['total_price'];
                }
            }
            ?>

            <form action="" method="post" class="monthForm" id="monthForm">
                <span onclick="changeMonth(-1)">&#9664;</span>
                <span id="currentMonth"><?php echo $currentMonth; ?></span>월
                <input type="hidden" name="currentMonth" id="hiddenCurrentMonth" value="<?php echo $currentMonth; ?>">
                <span onclick="changeMonth(1)">&#9654;</span>
                <input type="submit" name="Check" value="Submit">
            </form>
            <br><br>
            <div class="chart-container">
                <canvas id="categoryPieChart"></canvas>
            </div>

            <script>
                var ctx = document.getElementById('categoryPieChart').getContext('2d');
                var categoryPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode($categories); ?>,
                        datasets: [{
                            label: 'Category Prices',
                            data: <?php echo json_encode($prices); ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',   // 붉은색
                                'rgba(54, 162, 235, 0.2)',   // 파란색
                                'rgba(255, 206, 86, 0.2)',   // 노란색
                                'rgba(75, 192, 192, 0.2)',   // 청록색
                                'rgba(153, 102, 255, 0.2)',  // 보라색
                                'rgba(255, 159, 64, 0.2)'    // 주황색
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',    // 붉은색
                                'rgba(54, 162, 235, 1)',    // 파란색
                                'rgba(255, 206, 86, 1)',    // 노란색
                                'rgba(75, 192, 192, 1)',    // 청록색
                                'rgba(153, 102, 255, 1)',   // 보라색
                                'rgba(255, 159, 64, 1)'     // 주황색
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
            </script>

        </div>
    </div>
</body>
</html>
