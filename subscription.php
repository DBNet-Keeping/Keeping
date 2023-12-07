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
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <!-- script -->
    <script src="main.js"></script>

    <!-- DB Connection -->
</head>
<body>
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>
    <span id="calender_id">
        <p id="title">SUBSCRIPTION</p>
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
    </span>
</body>
</html>