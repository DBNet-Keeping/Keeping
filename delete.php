<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keeping</title>
    <link rel=stylesheet href='delete.css' type='text/css'>
    <link rel=stylesheet href='assets\navbar.css' type='text/css'>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>
<body>
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>
    <form class="delete" method="get" action="check_delete.php" class="deleteForm">
        <h2>Delete Member Information</h2>
        <h4>Clicking the button below will proceed with the withdrawal from membership.<br> Upon withdrawal, all of your information will be deleted.</h4>
        <button type="submit" class="btn" onclick="button()">
            UNREGISTER
        </button>
    </form>
</body>
</html>