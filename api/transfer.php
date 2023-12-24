<?php

include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    if (isset($_SESSION['userdata'])) {
        $fromAccount = $_POST["fromAccount"];
        $toAccount = $_POST["toAccount"];
        $pin = $_POST["pin"];
        $amount = $_POST["amount"];

        $sessionData = $_SESSION['userdata'];
        $storedPin = $sessionData['pin'];
        if ($pin !== $storedPin) {
            echo "<script>
                    alert('Invalid PIN');
                    window.location='./transfer.html';
                  </script>";
            exit();
        }

        $sqlFrom = "SELECT * FROM accounts WHERE accountno = '$fromAccount'";
        $resultFrom = $connect->query($sqlFrom);

        if ($resultFrom->num_rows > 0) {
            $rowFrom = $resultFrom->fetch_assoc();
            $currentBalanceFrom = $rowFrom["balance"];

            if ($currentBalanceFrom >= floatval($amount)) {
                $sqlTo = "SELECT * FROM accounts WHERE accountno = '$toAccount'";
                $resultTo = $connect->query($sqlTo);

                if ($resultTo->num_rows > 0) {
                    $rowTo = $resultTo->fetch_assoc();
                    $currentBalanceTo = $rowTo["balance"];

                    $newBalanceFrom = $currentBalanceFrom - floatval($amount);
                    $newBalanceTo = $currentBalanceTo + floatval($amount);

                    $updateSqlFrom = "UPDATE accounts SET balance = '$newBalanceFrom' WHERE accountno = '$fromAccount'";
                    $updateSqlTo = "UPDATE accounts SET balance = '$newBalanceTo' WHERE accountno = '$toAccount'";
                    
                    if ($connect->query($updateSqlFrom) === TRUE && $connect->query($updateSqlTo) === TRUE) {
                        $insertSql = "INSERT INTO transactions (account_id, type, amount) VALUES ('$fromAccount', 'Transfer to $toAccount','$amount')";
                        $insertSql2 = "INSERT INTO transactions (account_id, type, amount) VALUES ('$toAccount', 'Transfer from $fromAccount','$amount')";

                        if ($connect->query($insertSql) === TRUE) {
                            echo "<script>
                                    alert('Transfer successful');
                                    window.location='./home.php';
                                  </script>";
                        } else {
                            echo "<script>
                                    alert('Error inserting transaction');
                                    window.location='./transfer.html';
                                  </script>";
                        }
                    } else {
                        echo "<script>
                                alert('Error updating balances');
                                window.location='./transfer.html';
                              </script>";
                    }
                } else {
                    echo "<script>
                            alert('To Account not found');
                            window.location='./transfer.html';
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Insufficient funds');
                        window.location='./transfer.html';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('From Account not found');
                    window.location='./transfer.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not logged in');
                window.location='../login/loginv.html';
              </script>";
    }
}

$connect->close();

?>
