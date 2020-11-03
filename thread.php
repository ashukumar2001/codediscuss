<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./style/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Varela&display=swap" rel="stylesheet">
    <!-- Fontawesom Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />

    <title>CodeDiscuss</title>
</head>

<body>

    <?php 
        require "partials/_header.php"; 
        require "partials/_db_connection.php";
    ?>
    <?php
        // Fetching thread from the database:
        $thread_id = $_GET["thread_id"];
        $thread_sql_query = "SELECT * FROM `threads` WHERE `threads`.`thread_id` = $thread_id";
        if($thread_result = mysqli_query($connection, $thread_sql_query)) {
            if($num_of_rows = mysqli_num_rows($thread_result)) {
                while($row = mysqli_fetch_assoc($thread_result)) {
                    $thread_name = $row["thread_title"];
                    $thread_desc = $row["thread_description"];
                    $thread_user_name = $row["user_name"];
                }
            }
            unset($row);
        }
    ?>

    <!-- Write your answer (form setup) -->
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["logged_in"])) {
            $answer_thread_id = $thread_id;
            $answer_description = htmlspecialchars($_POST["answer_description"], ENT_QUOTES);
            $answer_user_id = $_SESSION['user_id'];
            $answer_user_name = $_SESSION["username"];
            $insert_answer_query = "INSERT INTO `answers` (`answer_description`, `answer_thread_id`, `user_id`, `user_name`, `answer_time`) VALUES ('$answer_description', '$answer_thread_id', '$answer_user_id', '$answer_user_name', current_timestamp());";
            $insert_answer_result = mysqli_query($connection, $insert_answer_query);
            if($insert_answer_result) {
                echo '
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    <strong>Your answer succesfully added.</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                ';
            } else {
                echo '
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong> Sorry!!!</strong>Unable to add answer.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                ';
            }
        }
    ?>

    <div class="jumbotron jumbotron-fluid mb-0">
        <div class="container">
            <h2 ><?php echo $thread_name ?></h1>
            <p class="lead"><?php echo $thread_desc ?></p>
            <p> <em> Posted by <strong><?php echo $thread_user_name ?></strong> </em></p>
        </div>
    </div>

    <!-- Write answer form container -->
    <div class="container-fluid bg-dark text-light p-4">
        <div class="container ">
            <?php 
                if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {

                    echo '<h3>Write your answer</h3>
                    <form action="'. $_SERVER["REQUEST_URI"]. '" method="post">
                        <div class="row m-0 align-items-start justify-content-start">
                            <div class="form-group col-lg-6 pl-0">
                                <label for="answerDescription">Answer</label>
                                <textarea class="form-control border border-dark" id="answerDescription"
                                    name="answer_description" rows="3" placeholder="Describe your answer..."></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>';
                } else {
                    echo '<h5>You need to <a href=""data-toggle="modal" data-target="#loginModal">login</a> to write answers...</h5>
                    ';
                }
            ?>
            
        </div>
    </div>

    <!-- Answers Container -->
    <div class="container-fluid bg-light text-light py-4 px-2">
        <div class="container" id="thread-list-container">
            <h3 class="text-dark mb-4">Discussion</h3>
            <ul class="list-group">
            <?php
                // Fetching all the Answers from the database on specific thread:
                $not_found = true;
                $answers_sql_query = "SELECT * FROM `answers` WHERE `answers`.`answer_thread_id` = $thread_id";
                if($answers_result = mysqli_query($connection, $answers_sql_query)) {
                    if($num_of_rows = mysqli_num_rows($answers_result)) {
                        $i=1;
                        $not_found = false;
                        while($row = mysqli_fetch_assoc($answers_result)) {
                            echo '
                            <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center my-2 shadow-sm">
                                <div class="media d-flex flex-column d-md-flex flex-md-row"">
                                    <div class="d-flex justify-content-center align-items-center flex-md-column mr-md-3 mb-3 mb-md-0">
                                        <img src="https://randomuser.me/api/portraits/med/women/7'. $i++ .'.jpg" class="mr-3 mr-md-0 border border-muted rounded-circle" alt="...">
                                        <h6 class="mb-1 my-md-2"><a href="profile.php?user_id='. $row["user_name"] .'">' . $row["user_name"] . '</a></h6>
                                    </div>
                                    <div class="media-body text-dark">
                                        '. $row["answer_description"] .'
                                        <small class="text-muted d-block mt-3">at '. $row["answer_time"] .'</small>
                                    </div>
                                </div>
                            </li>
                            ';
                        }
                    }
                    unset($row);
                    if($not_found) {
                        echo '<p class="text-center text-primary"><strong>Be the first person by answering this question.</strong></p>';
                    }
                }
            ?>
            </ul>
        </div>
    </div>

    <?php include 'partials/_footer.php'; ?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>