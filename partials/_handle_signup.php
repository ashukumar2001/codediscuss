<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include "_form_data_validation.php";
        include "_db_connection.php";
        $username = test_input($_POST["username"]);
        $email = test_input($_POST["signup_email"]);
        $password = test_input($_POST["signup_password"]);
        $confirm_password = test_input($_POST["confirm_signup_password"]);
        $show_error = false;
        $show_alert = false;

        // checking usrname existance: 
        $exist_username_query = "SELECT * FROM `users` WHERE `user_name` = '$username'";
        $exist_username_result = mysqli_query($connection, $exist_username_query);

        // checking email existance: 
        $exist_email_query = "SELECT * FROM `users` WHERE `users`.`user_email` = '$email'";
        $exist_email_result = mysqli_query($connection, $exist_email_query);

        if($num_row_username = mysqli_num_rows($exist_username_result)) {
            $show_error = true;
            $show_error_msg = "Username already exists"; 
        } elseif($num_row_email = mysqli_num_rows($exist_email_result)) {
            $show_error = true;
            $show_error_msg = "Email already exists"; 
        } else {
            if($password == $confirm_password) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $insert_user_query = "INSERT INTO `users` (`user_name`, `user_email`, `user_password_hash`, `user_signup_time`) VALUES ('$username', '$email', '$password_hash', current_timestamp())";
                $insert_user_result = mysqli_query($connection, $insert_user_query);
                if($insert_user_result) {
                    $show_alert = true;
                    $show_alert_msg = "Account Created Succesfully!!!";
                }
            } else {
                $show_error = true;
                $show_error_msg = "Password did not match";
            }
        }

        if($show_error) {
            header("location: ../index.php?show_error=$show_error&show_alert=0&msg=$show_error_msg");
        } elseif($show_alert) {
            header("location: ../index.php?show_alert=$show_alert&show_error=0&msg=$show_alert_msg");
        }
    }
?>