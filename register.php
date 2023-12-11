<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel=stylesheet href='assets/navbar.css' type='text/css'>
    <link rel=stylesheet href='register.css' type='text/css'>
    
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

</head>
<body>
    <span id='navbar'>
        <?php include 'navbar.php'; ?>
    </span>

    <div class="content">
        <div class="title">
            <p id="transaction_register">TRANSACTION REGISTER</p>
        </div>
        <form action="check_register.php" method="post" class="transactionForm">
            <h2>Essential</h2>
            <hr>

            <label for="category_id">Category:</label>
                <select class="category_id" for="category_id" name="category_id">
                    <option value="1">Transportation</option>
                    <option value="2">Food</option>
                    <option value="3">Shopping</option>
                    <option value="4">Transfer</option>
                    <option value="5">Convenience Stores</option>
                    <option value="6">Entertainment</option>
                    <option value="7">Travel</option>
                    <option value="8">Donation</option>
                    <option value="9">Cafe</option>
                    <option value="10">Hobby</option>
                    <option value="11">Beauty</option>
                    <option value="12">Housing</option>
                    <option value="13">Education</option>
                    <option value="14">Health</option>
                </select>

            <label for="price">Price:</label>
            <input type="text" id="deposit_or_withdrawal" name="deposit_or_withdrawal" placeholder="+ or -">
            <input type="number" id="price" name="price" placeholder="price"><br><br>

            <label for="date_t">Date:</label>
            <input type="date" id="date_t" name="date_t"><br><br>

            <label for="client">Client:</label>
            <input type="text" id="client" name="client" placeholder="client"><br><br>

            <label for="t_account_number">Account Number:</label>
            <input type="text" id="t_account_number" name="t_account_number" placeholder="account_name"><br><br>

            <h2>Optional</h2>
            <hr>

            <label for="location">Location:</label>
            <input type="text" id="si" name="si" placeholder="si">
            <input type="text" id="dong" name="dong" placeholder="dong">
            <input type="text" id="detail_location" name="detail_location" placeholder="detail_location"><br><br>

            <label for="memo">Memo:</label>
            <input type="text" id="memo" name="memo" placeholder="memo"><br><br>

            <input type="submit" name="addTransaction" value="addtransaction">
        </form>
    </div>

</body>
</html>
