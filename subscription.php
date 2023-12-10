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

    <!-- script -->
    <script src="assets\subscription.js"></script>
    <!-- DB Connection -->
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
                <form method="POST" action="subscriptiondb.php" class="subForm" id="subForm">
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
                        <index id="cycleindex1">next payment date<br>(payment cycle)</index>
                        <input type="date" name="paycycle" class="pay" id="paycycle">
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
                    <!-- <p id="plus"></p> -->
                </div>
            </div>
            <div class="background-image"><img src='assets\image\004.png' id="backimg"></div>
    </span>
</body>
</html>