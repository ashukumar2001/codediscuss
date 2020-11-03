<?php
session_start();
include "partials/_db_connection.php";
include "partials/_form_data_validation.php";

echo '
<nav class="navbar navbar-expand-lg navbar-light bg-light py-lg-2 px-lg-4">
<a class="navbar-brand" href="./">CodeDiscuss</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="./">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php">About</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $categories_sql = "SELECT `categories_name`, `categories_id` FROM `categories`";
        $result = mysqli_query($connection, $categories_sql);
        while($row = mysqli_fetch_assoc($result)) {
          echo '<a class="dropdown-item" href="threadslist.php?categories_id='. $row["categories_id"] .'">'. $row["categories_name"] .'</a>';

        }
      echo '</div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="contact.php">Contact</a>
    </li>
  </ul>
  <form action="search.php" method="get" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2 searchbar border border-dark" type="search" placeholder="Search..." name="search_query" aria-label="Search">
      <button class="btn btn-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
    </form>
    <div class="my-2 my-lg-0 ml-lg-2 ml-lg-0">';
    // checking if user is login
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
      echo  '<strong class="text-dark mb-0">Welcome <a href="#">'.$_SESSION["username"].'</a></strong>
      <a href="partials/_handle_logout.php" class="btn btn-primary ml-2">Logout</a>
      ';
    } else {
      echo '<button class="btn btn-primary ml-lg-2" data-toggle="modal" data-target="#loginModal">SignIn</button>
      <button class="btn btn-primary ml-lg-2 ml-sm-2" data-toggle="modal" data-target="#signupModal">SignUp</button>';
    }
  echo '</div>
</div>  
</nav>';
include "partials/_login_modal.php";
include "partials/_signup_modal.php";

?>