<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include "_form_data_validation.php";
        include "_db_connection.php";
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        $login_email = test_input($_POST["login_email"]);
        $login_password = test_input($_POST["login_password"]);

        $exist_user_query = "SELECT * FROM `users` WHERE `user_email` = '$login_email'";
        $exist_user_result = mysqli_query($connection, $exist_user_query);
        $num_of_user = mysqli_num_rows($exist_user_result);
        if($num_of_user == 1) {
            $row = mysqli_fetch_assoc($exist_user_result);
            if(password_verify($login_password, $row["user_password_hash"])) {
                session_start();
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $row["user_name"];
                $_SESSION["user_email"] = $row["user_email"];
                $_SESSION["user_id"] = $row["user_id"]; 
                header("location: ../index.php");
                exit;
            } else {
                $login = false;
                $login_msg = "Invalid password";
            }
        } else {
            $login = false;
            $login_msg = "Invalid email address";
        }
        mysqli_free_result($exist_user_result);
        header("location: ../index.php?login=$login&login_msg=$login_msg");
        exit;
    }
?>