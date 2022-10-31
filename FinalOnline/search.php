<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
//include_once 'resource/utilities.php';

if(!isset($_SESSION['username'])){
    //echo '<script>alert("If things are ok you are not logged in.")</script>';
    //de redirect voorkomt dat de alert gezien word
    //echo "<h1>If you are not logged in you should see this.</h1>";
    header('location: index.php');
}

if(isset($_SESSION['title'])){
  unset($_SESSION['title']);
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://kit.fontawesome.com/5b145bfb33.js" crossorigin="anonymous"></script>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="Library.css">

    <link rel="stylesheet" href="style/searchStyle.css">

    <title>My Library</title>
  </head>
  <body>
    <!--Wil 'fixed-top' in navbar doen maar text valt er dan achter -->
    <nav id="mainNavbar" class="navbar navbar-dark bg-success navbar-expand-md">
      <a href="#" class="navbar-brand"><i class="fas fa-book pr-2"></i>My Library</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navLinks">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navLinks" class="collapse navbar-collapse">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a href="index.php" class="nav-link">HOME</a>
              </li>
                <li class="nav-item">
                    <a href="insertBook.php" class="nav-link">Insert</a>
                </li>
                <li class="nav-item">
                    <a href="browse.php" class="nav-link">Browse</a>
                </li>
              <li class="nav-item">
                  <a href="Info.php" class="nav-link active">Info</a>
              </li>
              <li class="nav-item">
                  <a href="LibraryLogin.php" class="nav-link">Login</a>
              </li>
              <li class="nav-item">
                  <a href="SignUp.php" class="nav-link">Sign Up</a>
              </li>
          </ul>
      </div>
  </nav>



    <div class="container text-center mt-2">
      <h1 class=" display-4 text-center">My Library Search</h1>
    <div class="row">
      <div class="col">

      <form method="post" action="results.php">
        <div class="form-group ml-20px">
        <label>Search</label>
        <input type="text" name="title" class="form-control" placeholder="Enter Title">
        </div>
        <div class="form-group form-check">
        </div>
        <button type="submit" name="searchBtn" class="btn btn-primary">Search by title</button>
      </form>

      </div>
    </div>
  </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $(function(){
          $(document).scroll(function(){
              var $nav = $("#mainNavbar");
              $nav.toggleClass("scrolled", $(this).scrollTop() > $nav.height());
          });
      });
  </script>  
  </body>
</html>