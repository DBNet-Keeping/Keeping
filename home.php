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

    $currentDate = new DateTime();
    $this_month = $currentDate->format('n');    // 현재 month
    $last_month = $currentDate->modify('-1 month')->format('n');  // 이전 month

    // 수입
    $LastM_IDataQuery = "SELECT price FROM transaction WHERE MONTH(date_t) = '$last_month' AND deposit_or_withdrawal = '+' AND t_user_id = '$userid'";
    $LastM_IDataQueryResult = $conn->query($LastM_IDataQuery);
    $ThisM_IDataQuery = "SELECT price FROM transaction WHERE MONTH(date_t) = '$this_month' AND deposit_or_withdrawal = '+' AND t_user_id = '$userid'";
    $ThisM_IDataQueryResult = $conn->query($ThisM_IDataQuery);
    $L_TotalIprice = 0;
    $T_TotalIprice = 0;

    if($LastM_IDataQueryResult->num_rows > 0){
        while($L_Irow = $LastM_IDataQueryResult->fetch_assoc()){
            $L_resultIprice = $L_Irow['price'];
            $L_TotalIprice += $L_resultIprice;
        }
    }else if($LastM_IDataQueryResult->num_rows === 0){
        $L_TotalIprice = 0;
        }

    if($ThisM_IDataQueryResult->num_rows > 0){
        while($T_Irow = $ThisM_IDataQueryResult->fetch_assoc()){
            $T_resultIprice = $T_Irow['price'];
            $T_TotalIprice += $T_resultIprice;
            }
        }else if($ThisM_IDataQueryResult->num_rows === 0){
            $T_TotalIprice = 0;
        }

    // 지출
    $LastM_EDataQuery = "SELECT price FROM transaction WHERE MONTH(date_t) = '$last_month' AND deposit_or_withdrawal = '-' AND t_user_id = '$userid'";
    $LastM_EDataQueryResult = $conn->query($LastM_EDataQuery);
    $ThisM_EDataQuery = "SELECT price FROM transaction WHERE MONTH(date_t) = '$this_month' AND deposit_or_withdrawal = '-' AND t_user_id = '$userid'";
    $ThisM_EDataQueryResult = $conn->query($ThisM_EDataQuery);
    $L_TotalEprice = 0;
    $T_TotalEprice = 0;

    if($LastM_EDataQueryResult->num_rows > 0){
        while($L_Erow = $LastM_EDataQueryResult->fetch_assoc()){
            $L_resultEprice = $L_Erow['price'];
            $L_TotalEprice += $L_resultEprice;
        }
    }else if($LastM_EDataQueryResult->num_rows === 0){
        $L_TotalEprice = 0;
    }

    if($ThisM_EDataQueryResult->num_rows > 0){
        while($T_Erow = $ThisM_EDataQueryResult->fetch_assoc()){
            $T_resultEprice = $T_Erow['price'];
            $T_TotalEprice += $T_resultEprice;
        }
    }else if($ThisM_EDataQueryResult->num_rows === 0){
        $T_TotalEprice = 0;
    }
    $income_P = "₩ " . $T_TotalIprice;
    $expense_P = "₩ ". $T_TotalEprice;

    // 입출금 가능한 통장들 잔고 확인
    $CurrentBalanceQuery = "SELECT balance FROM account WHERE deposit_and_withdrawal_status = 1 AND a_user_id = '$userid'";
    $CurrentBalanceResult = $conn ->query($CurrentBalanceQuery);
    $current_ = 0;
    
    if($CurrentBalanceResult->num_rows > 0){
        while($B_row = $CurrentBalanceResult->fetch_assoc()){
            $CurrentBalance = $B_row["balance"];
            $current_ += $CurrentBalance;
        }
    }else if($CurrentBalanceResult->num_rows === 0){
        $current_ = 0;
    }
    $current_P = "₩ " . $current_;

    // 지출 카테고리 상위 3개 가져오기
    $CategoryTopQuery = "SELECT C.category_name as categoryname, SUM(T.price) as categorysum 
    FROM transaction T
    JOIN category C
    ON T.t_category_id = C.category_id
    WHERE T.deposit_or_withdrawal = '-' AND t_user_id = '$userid'
    GROUP BY t_category_id
    ORDER BY categorysum DESC
    LIMIT 3;";
    $CategoryTopResult = $conn ->query($CategoryTopQuery);

    $CategoryData = array();
    
    if($CategoryTopResult->num_rows > 0){
        while($Category_row = $CategoryTopResult->fetch_assoc()){
            $CategoryData[] = array(
                'categoryname' => $Category_row['categoryname'],
                'categorysum' => $Category_row['categorysum']
            );
        }
    }
?>
                
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keeping</title>
    <link rel=stylesheet href='assets\home.css' type='text/css'>
    <link rel=stylesheet href='assets\navbar.css' type='text/css'>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <!-- script -->
    <script src="assets\home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body style="
    height: 1px; width: 1px;">
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>
    <span id="current_month">
        <img id="cardimg" src="assets\image\card_frame.png">
        <p id="currentB">
            <script>
                var currentP = <?php echo json_encode($current_P)?>;
                document.getElementById("currentB").textContent = currentP;
            </script>
        </p>
        <p id="month"></p>
        <p id="incomeBox"><p id="incometext">Income</p><img id="incomepng" src="assets\image\up.png"><p id="income">
            <script>
                var incomeP = <?php echo json_encode($income_P)?>;
                document.getElementById("income").textContent = incomeP;
            </script>
        </p></p>
        <p id="expenseBox"><p id="expensetext">Expense</p><img id="expensepng" src="assets\image\down.png"><p id="expense">
            <script>
                var expenseP = <?php echo json_encode($expense_P)?>;
                document.getElementById("expense").textContent = expenseP;
            </script>
        </p></p>
    </span>
    <span id="month_summary">
        <p id="summary">Summary</p>
        <div id="homeG">
        <canvas id="MonthIncomeChart"></canvas>
            <script>
                var lastMonthIPrice = <?php echo json_encode($L_TotalIprice); ?>;
                var thisMonthIPrice = <?php echo json_encode($T_TotalIprice); ?>;

                var lastMonthEPrice = <?php echo json_encode($L_TotalEprice); ?>;
                var thisMonthEPrice = <?php echo json_encode($T_TotalEprice); ?>;

                var MonthChart = document.getElementById('MonthIncomeChart').getContext('2d');
                var myMonthChart = new Chart(MonthChart, {
                    type: 'bar',
                    data:{
                        labels: [
                            'Income', 'Expense'
                        ],
                        datasets: [
                            {
                                label: "Last Month",
                                backgroundColor:[
                                    "#a7b8f8"
                                ],
                                data: [lastMonthIPrice, lastMonthEPrice]
                            },
                            {
                                label: "This Month",
                                backgroundColor:[
                                    "#3660FA"
                                ],
                                data: [thisMonthIPrice, thisMonthEPrice]
                            }
                        ]
                    },
                    options:{
                        responsive: false, // 차트 크기를 반응형으로 조절하지 않음
                        maintainAspectRatio: false, // 가로 및 세로 비율을 유지하지 않음
                        scales: 
                        {
                            x: 
                            {
                                autoSkip: false,
                                ticks: 
                                {
                                    color: '#FFFFFF',
                                    font:{
                                        family: 'Myanmar-Khyay',
                                        size: 20
                                    }
                
                                }
                            },
                            y: 
                            {
                                ticks:{
                                    color: '#FFFFFF',
                                    font:{
                                        family: 'Myanmar-Khyay'
                                    },
                                    padding: 10
                                },
                                beginAtZero: true,
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: 'white', // 범례 글자 색상을 흰색으로 변경
                                    font:{
                                        family: 'Myanmar-Khyay',
                                        size: 15
                                    },
                                }
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                });
            </script>
            <canvas id="MonthCategoryChart"></canvas>
            <script>
                var categoryData = <?php echo json_encode($CategoryData); ?>;
                var CategoryChart = document.getElementById('MonthCategoryChart').getContext('2d');

                var labels = categoryData.map(item => item.categoryname);
                var data = categoryData.map(item => item.categorysum);

                var myCategoryChart = new Chart(CategoryChart, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Expense Category',
                            data: data,
                            backgroundColor: '#5935b6',
                            borderColor: 'rgba(75, 192, 192, 1)',
                        }]
                    },
                    options:{
                        responsive: false, // 차트 크기를 반응형으로 조절하지 않음
                        maintainAspectRatio: false, // 가로 및 세로 비율을 유지하지 않음
                        scales: 
                        {
                            x: 
                            {
                                autoSkip: false,
                                ticks: 
                                {
                                    color: '#FFFFFF',
                                    font:{
                                        family: 'Myanmar-Khyay',
                                        size: 20
                                    }
                
                                }
                            },
                            y: 
                            {
                                ticks:{
                                    color: '#FFFFFF',
                                    font:{
                                        family: 'Myanmar-Khyay'
                                    },
                                    padding: 10
                                },
                                beginAtZero: true,
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: 'white', // 범례 글자 색상을 흰색으로 변경
                                    font:{
                                        family: 'Myanmar-Khyay',
                                        size: 15
                                    },
                                }
                            }
                        },
                        layout: {
                            padding: {
                                left: 10,
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                });
            </script>
        </div>
    </span>
    <span class="container-fluid" id="footer">
        copyright ⓒ DBNet 2023.
    </span>
</body>
</html>