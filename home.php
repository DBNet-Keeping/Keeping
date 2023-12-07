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

    <!-- DB Connection -->
</head>
<body>
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
    </span>
</body>
</html>