<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keeping</title>
    <link rel=stylesheet href='modify.css' type='text/css'>
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
    <form class="modify" method="post" action="check_modify.php" class="modifyForm">
        <h2>Modify Member Information</h2>
        <h4>Clicking the button below will proceed with the withdrawal from membership.<br> Upon withdrawal, all of your information will be deleted.</h4>
        <div class="emailForm">
            <input type="text" name="new_email" class="id" placeholder="New e-mail">
        </div> 
        <div class="oldpassForm">
            <input type="password" name="old_pw" class="pw" placeholder="Old Password">
        </div>
        <div class="passForm">
            <input type="password" name="new_pw" class="pw" placeholder="New Password">
        </div>
        <div class="confirmpassForm">
            <input type="password" name="new_password_confirm" class="pw" placeholder="Confirm Password">
        </div>
        <button type="submit" class="btn" onclick="button()">
            UNREGISTER
        </button>
    </form>
</body>
</html>