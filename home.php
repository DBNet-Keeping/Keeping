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
        <p id="month"></p>
        <p id="incomeBox"><p id="incometext">Income</p><img id="incomepng" src="assets\image\up.png"><p id="income">₩</p></p>
        <p id="expenseBox"><p id="expensetext">Expense</p><img id="expensepng" src="assets\image\down.png"><p id="expense">₩</p></p>
    </span>
    <span id="month_summary">
        <p id="summary">Summary</p>
        <div id="homeG">
        <canvas id="MonthIncomeChart"></canvas>
            <script>
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
                ?>
                
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

                // 막대의 두께 설정
                myMonthChart.data.datasets.forEach(dataset => {
                    dataset.barThickness = 100;
                });
            </script>
        </div>
    </span>
    <span class="container-fluid" id="footer">
        copyright ⓒ DBNet 2023.
    </span>
</body>
</html>