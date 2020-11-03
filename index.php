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

    <link rel="stylesheet" href="style/style.css">

    <title>CodeDiscuss - Coding solutions</title>
</head>

<body>

    <?php 
        require "partials/_header.php"; 
        require "partials/_db_connection.php";
    ?>
    <?php
        // Show signup errors: 
        if(isset($_GET["show_error"]) && isset($_GET["show_alert"]) && isset($_GET["msg"])) {

            $error = $_GET["show_error"];
            $msg = $_GET["msg"];
            $alert = $_GET["show_alert"];
            
            if($error) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                <strong>'. $msg .'</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    ';
            } elseif($alert) {
                echo '
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                <strong>'. $msg .'</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';
            }
        }

        // Show login errors:
        if(isset($_GET["login"]) && !$_GET["login"]) {
            echo '
                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                <strong>'. $_GET["login_msg"] .'</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
            ';
        }
    ?>

    <!-- Slider starts here -->
    <div class="container-fluid mx-0 p-0">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/slider-img-1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/slider-img-2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="./images/slider-img-3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev text-dark" href="#carouselExampleIndicators" role="button"
                data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- Categories Container starts here -->
    <div class="container my-5">
        <h3 class="text-center my-4">CodeDiscuss - Categories</h3>

        <div class="row">
            <?php
            // Fetching all the categories from the database:
            $sql_query = "SELECT * FROM `categories`";
            $result = mysqli_query($connection, $sql_query);
            if($result = mysqli_query($connection, $sql_query)) {
                if($num_of_rows = mysqli_num_rows($result)) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <div class="col-lg-4 my-4">
                        <div class="card mx-auto shadow-sm rounded" style="width: 18rem;">
                            <img src="https://source.unsplash.com/1600x900/?coding,'. strtolower($row["categories_name"]) .'" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><a href="threadslist.php?categories_id='.$row["categories_id"].'">'. $row["categories_name"] .'</a></h5>
                                <p class="card-texst">'. substr($row["categories_description"], 0, 100) .'...</p>
                                <a href="threadslist.php?categories_id='.$row["categories_id"].'" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                        ';
                    }
                }
            }
            ?>
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