<?php
include("connect.php");

session_start();

$userData = $_SESSION["userdata"];

$accountId = $userData["accountno"];
$query = "SELECT * FROM accounts WHERE accountno='$accountId'";
$result = mysqli_query($connect, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $accountDetails = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching account details.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../accountdetails/accountdetails.css">
    <title>Account Page</title>
</head>
<body>
    <header>
        <div class="container">
            <h1>Banking System</h1>
            <nav>
                <ul>
                    <li><a href="./home.php">Home</a></li>
                    <li><a href="./logout.php">Logout</a></li>
                    <li><a href="../help/help.html">Help</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Account Details</h2>
        <div class="account-card">
            <div class="account-info">
                <label for="accountId">Account ID:</label>
                <span id="accountId"><?php echo $accountDetails["accountno"]; ?></span>

                <label for="firstName">First Name:</label>
                <span id="firstName"><?php echo $accountDetails["firstname"]; ?></span>

                <label for="lastName">Last Name:</label>
                <span id="lastName"><?php echo $accountDetails["lastname"]; ?></span>

                <label for="email">Email:</label>
                <span id="email"><?php echo $accountDetails["email"]; ?></span>

                <label for="mobileNumber">Mobile Number:</label>
                <span id="mobileNumber"><?php echo $accountDetails["mobile"]; ?></span>

                <label for="balance">Balance:</label>
                <span id="balance">$<?php echo $accountDetails["balance"]; ?></span>
            </div>
        </div>
    </main>
</body>
</html>
