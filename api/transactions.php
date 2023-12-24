<?php
include("connect.php");

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../transaction/transactions.css">
  <title>Banking System - Transactions</title>
</head>
<body>
  <header>
    <div class="container">
      <h1>Transaction History</h1>
      <nav>
        <ul>
          <li><a href="./home.php">Home</a></li>
          <li><a href="./account.php">Accounts</a></li>
          <li><a href="./logout.php">Logout</a></li>
          <li><a href="../help/help.html">Help!</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">
    <section id="transaction-form">
      <h2><b><u>Recent Transactions</u></b></h2>
    
      <style>
        table, th, td {
            border: 0.02px solid black;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 10px;
        }
      </style>

      <table>
        <tr>
          <th style="width: 8%">S.No</th>
          <th style="width: 22%">Date</th>
          <th style="width: 40%">Transactions</th>
          <th style="width: 30%">Amount</th>
        </tr>
        <?php
        $accountNumber = $_SESSION['userdata']['accountno'];
        $sql = "SELECT * FROM transactions WHERE account_id = '$accountNumber' ORDER BY updatedon DESC";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$counter}</td>
                    <td>{$row['updatedon']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['amount']}</td>
                </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='4'>No transactions found</td></tr>";
        }
        ?>
      </table>
    </section>
  </main>

</body>
</html>

<?php
$connect->close();
?>
