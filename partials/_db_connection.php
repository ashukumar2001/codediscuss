<?php
    $username = "root";
    $servername = "localhost";
    $pass = "";
    $database = "codediscuss";

    $connection = mysqli_connect($servername, $username, $pass, $database);
    // Check connection
    if (mysqli_connect_error()) {
        die("Database connection failed: " . mysqli_connect_error());
    }
?>