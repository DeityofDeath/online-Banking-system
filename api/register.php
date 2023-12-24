<?php
    include("connect.php");
    $accountid = $_POST['account-id'];
    $pin = $_POST['pin'];
    $fname = $_POST['first-name'];
    $lname = $_POST['last-name'];
    $mobile = $_POST['mobile-number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $balance = $_POST['balance'];
    


    if($password == $cpassword){
        $insert = mysqli_query($connect, "INSERT INTO accounts(accountno,pin,firstname,lastname,email,password,balance,mobile) VALUES ('$accountid', '$pin', '$fname', '$lname', '$email', '$password', '$balance', '$mobile')");
        if($insert){
            echo '
            <script>
            alert("Registered successfully!!!");
            window.location = "../login/loginv.html";
            </script>
            ';
        }else {
            echo '
            <script>
            alert("Error occurred while registering: ' . mysqli_error($connect) . '");
            window.location = "../registration/regi.html";
            </script>
            ';
        }
    }else{
        echo '
        <script>
        alert("Password does not match");
        window.location = "../registration/regi.html";
        </script>
        ';
    }
?>
