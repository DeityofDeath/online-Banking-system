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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../homepage/home.css">
  <title>Banking System - Home</title>
</head>
<body>
  <header>
    <div class="container">
      <h1>Welcome to Your Banking System</h1>
      <nav>
        <ul>
          <li><a href="./home.php" class="active">Home</a></li>
          <li><a href="./account.php">Account</a></li>
          <li><a href="./transactions.php">Transactions</a></li>
          <li><a href="./logout.php">Logout</a></li>
          <li><a href="../help/help.html">Help!</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">
    <section id="account-summary">
      <h2>Account Summary</h2>
      <p>Account Number: <span id="accountNumber"><?php echo $accountDetails["accountno"]; ?></span></p>
      <p>Balance: $<span id="accountBalance"><?php echo $accountDetails["balance"]; ?></span></p>
    </section>

    <section id="quick-links">
      <h2>Quick Links</h2>
      <ul>
        <li><a href="../deposit/deposit.html" class="quick-link">Deposit Money</a></li>
        <li><a href="../withdraw/withdraw.html" class="quick-link">Withdraw Money</a></li>
        <li><a href="../transfer/transfer.html" class="quick-link">Transfer Funds</a></li>
      </ul>
    </section>
  </main>

</body>
</html>
