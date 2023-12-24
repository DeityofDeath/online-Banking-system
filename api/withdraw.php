<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    if (isset($_SESSION['userdata'])) {
        $accountNumber = $_POST["accountNumber"];
        $amount = $_POST["amount"];
        $pin = $_POST["pin"];

        $sessionData = $_SESSION['userdata'];
        $storedPin = $sessionData['pin'];
        if ($pin !== $storedPin) {
            echo "<script>
                    alert('Invalid PIN');
                    window.location='./deposit.html';
                  </script>";
            exit();
        }
        $sql = "SELECT * FROM accounts WHERE accountno = '$accountNumber'";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentBalance = $row["balance"];

            if ($currentBalance >= floatval($amount)) {
                $newBalance = $currentBalance - floatval($amount);

                $updateSql = "UPDATE accounts SET balance = '$newBalance' WHERE accountno = '$accountNumber'";
                $insertrans = mysqli_query($connect,"INSERT into transactions (account_id, type, amount) values ('$accountNumber', 'Withdrawal', '$amount')");

                if ($connect->query($updateSql) === TRUE) {

                    echo "<script>
                            alert('Withdrawal successful');
                            window.location='./home.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('Error updating balance');
                            window.location='./withdraw.html';
                          </script>";
                }
            } else {
                echo "<script>
                        alert('Insufficient balance');
                        window.location='./withdraw.html';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Account not found');
                    window.location='./withdraw.html';
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
