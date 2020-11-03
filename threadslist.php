<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Varela&display=swap" rel="stylesheet">
    <!-- Fontawesom Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./style/style.css">

    <title>CodeDiscuss</title>
</head>

<body>

    <?php 
        require "partials/_header.php"; 
        require "partials/_db_connection.php";
    ?>
    <?php
        // Fetching all the categories from the database:
        $cat_id = $_GET["categories_id"];
        $categories_sql_query = "SELECT * FROM `categories` WHERE `categories`.`categories_id` = $cat_id";
        // $result = mysqli_query($connection, $sql_query);
        if($categories_result = mysqli_query($connection, $categories_sql_query)) {
            if($num_of_rows = mysqli_num_rows($categories_result)) {
                while($row = mysqli_fetch_assoc($categories_result)) {
                    $cat_name = $row["categories_name"];
                    $cat_desc = $row["categories_description"];
                }
            }
            unset($row);
        }
    ?>

    <!-- Ask a question form setup -->
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["logged_in"])) {
            $thread_title = htmlspecialchars($_POST["thread_title"], ENT_QUOTES);
            $thread_description = htmlspecialchars($_POST["thread_description"], ENT_QUOTES);
            $thread_user_id = $_SESSION['user_id'];
            $thread_user_name = $_SESSION["username"];
            $insert_thread_query = "INSERT INTO `threads` (`thread_id`, `user_id`, `user_name` ,`thread_title`, `thread_description`, `thread_category_id`, `time`) VALUES (NULL, '$thread_user_id', '$thread_user_name', '$thread_title', '$thread_description', '$cat_id', current_timestamp());";
            $insert_thread_result = mysqli_query($connection, $insert_thread_query);
            if($insert_thread_result) {
                echo '
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                    <strong>Your thread succesfully added.</strong> You will get answers in some time.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                ';
            } else {
                echo '<pre>';
                print_r(mysqli_error($connection));   
                echo '</pre>';

                echo '
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    <strong> Sorry!!!</strong>Unable to add thread.
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
            <h2>Welcome to <?php echo $cat_name ?> Fourm</h2>
            <p class="lead"><?php echo $cat_desc ?></p>
        </div>
    </div>

    <!-- Ask Question form container -->
    <div class="container-fluid bg-dark text-light p-4">
        <div class="container ">
            <?php 
                if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {

                    echo '
                            <h3>Ask a question</h3>
                            <form action="'. $_SERVER["REQUEST_URI"] .'" method="post">
                                <div class="row m-0 align-items-start justify-content-start">
                                    <div class="form-group pl-0 col-lg-6">
                                        <label for="questionTitle">Question</label>
                                        <input type="text" class="form-control border border-dark" id="questionTitle"
                                            name="thread_title" aria-describedby="questionHelp" placeholder="Question title...">
                                        <small id="questionHelp" class="form-text text-muted">Keep your question title small and
                                            straightforward to problem.</small>
                                    </div>
                                    <div class="form-group col-lg-6 pl-0">
                                        <label for="questionDescription">Description</label>
                                        <textarea class="form-control border border-dark" id="questionDescription"
                                            name="thread_description" rows="3" placeholder="Describe your question..."></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        ';
                } else {
                    echo '<h5>You need to <a href=""data-toggle="modal" data-target="#loginModal">login</a> to ask questions...</h5>
                    ';
                }
            ?>
        </div>
    </div>

    <!-- Question Container -->
    <div class="container-fluid bg-light text-light py-4 px-2">
        <div class="container" id="thread-list-container">
            <h2 class="text-dark mb-4">Browse Questions</h2>
            <ul class="list-group">
                <?php
                // Fetching all the Questions from the database on specific Category:
                $cat_id = $_GET["categories_id"];
                $threads_sql_query = "SELECT * FROM `threads` WHERE `threads`.`thread_category_id` = $cat_id";
                $not_found = true;
                if($threads_result = mysqli_query($connection, $threads_sql_query)) {
                    if($num_of_rows = mysqli_num_rows($threads_result)) {
                        $i=1;
                        $not_found = false;

                        

                        while($row = mysqli_fetch_assoc($threads_result)) {
                            echo '
                            <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center my-2 shadow-sm">
                                <div class="media d-flex flex-column d-md-flex flex-md-row">
                                    <div class="d-flex justify-content-center align-items-center flex-md-column  mr-md-3 mb-3 mb-md-0">
                                        <img src="https://randomuser.me/api/portraits/med/women/'. $i++ .'.jpg" class="mr-3 mr-md-0 border border-muted rounded-circle" alt="...">
                                        <h6 class="mb-1 my-md-2"><a href="profile.php?user_id='. $row["user_name"] .'">' . $row["user_name"] . '</a></h6>
                                    </div>
                                    <div class="media-body text-dark">
                                        <h5 class="mb-1"><a href="thread.php?thread_id='. $row["thread_id"] .'">' . $row["thread_title"] . '</a></h5>
                                        '. $row["thread_description"] .'
                                        <small class="d-block text-secondary mt-3"> at '. $row["time"] .'</small>
                                    </div>
                                </div>';
                                // Fetching the total numbers of answers to specific thread
                                $answer_thread_id = $row["thread_id"];
                                $select_answers_query = "Select * FROM `answers` WHERE `answers`.`answer_thread_id` = $answer_thread_id";
                                if($select_answers_result = mysqli_query($connection, $select_answers_query)) {
                                    if($num_of_answer = mysqli_num_rows($select_answers_result)) {
                                        echo '<span class="badge badge-primary badge-pill mt-3 align-self-end align-self-md-center">'. $num_of_answer .'</span>';
                                    } else {
                                        echo '<span class="badge badge-primary badge-pill mt-3 align-self-end align-self-md-center">0</span>';
                                    }
                                } else {
                                    echo '<span class="badge badge-primary badge-pill mt-3 align-self-end align-self-md-center">0</span>';
                                }
                                
                            echo '</li>';
                        }
                    }
                    unset($row);
                    if($not_found) {
                        echo '<p class="text-center text-primary"><strong>Be the first person to ask question on '. $cat_name .'</strong></p>';
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