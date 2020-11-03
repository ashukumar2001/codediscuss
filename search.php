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


    <div class="container-fluid bg-light text-light py-4 px-2">
        <div class="container" id="thread-list-container">
            <h3 class="text-dark mb-4">Search Results for <q><?php echo $_GET["search_query"] ?></q></h3>
            <ul class="list-group">
                <!-- Fetch all search result form database -->
                <?php
                    $search = $_GET["search_query"];
                    $search_sql = "SELECT * FROM `threads` WHERE MATCH(thread_title, thread_description) against ('$search')";
                    $search_result = mysqli_query($connection, $search_sql);
                    if($num_of_row = mysqli_num_rows($search_result)) {

                        // While loop for displaying search results
                        while($row = mysqli_fetch_assoc($search_result)) {
                            echo '
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-column shadow-sm my-2 rounded">
                                    <h4><a href="thread.php?thread_id='. $row["thread_id"] .'">'. $row["thread_title"] .'</a></h4>
                                    <p class="text-dark">'. $row["thread_description"] .'</p>
                                </li>';
                        }
                    } else {// When no result found: 
                        echo '<li class="list-group-item d-flex justify-content-between align-items-start flex-column shadow-sm my-2 rounded">
                            <h4 class="text-dark">You search - <q><strong>'. $_GET["search_query"]. '</strong></q> - did not match any threads.</h4>
                            <p class="text-dark">Suggestions: </p>
                            <ul class="text-dark">
                                    <li>Make sure that all words are spelled correctly.</li>
                                    <li>Try different keywords.</li>
                                    <li>Try more general keywords.</li>
                                    </ul>
                        </li>';
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