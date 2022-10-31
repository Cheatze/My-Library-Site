<?php
include_once 'resource/session.php';
//echo "Hello world hello.";


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
                  <a href="index.php" class="nav-link active">HOME</a>
              </li>
              <?php
              if(isset($_SESSION['username'])){
                echo '
                <li class="nav-item">
                <a href="insertBook.php" class="nav-link">Insert</a>
                </li>
                <li class="nav-item">
                <a href="search.php" class="nav-link">Search</a>
                </li>
                <li class="nav-item">
                <a href="browse.php" class="nav-link">Browse</a>
                </li>
                ';
            }
              ?>
              <li class="nav-item">
                  <a href="Reset.php" class="nav-link">Reset</a>
              </li>
              <li class="nav-item">
                  <a href="Info.php" class="nav-link">Info</a>
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
      <h1 class=" display-4 text-center">My Library</h1>
    <div class="row">
      <div class="col">
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Aut itaque qui consectetur recusandae, consequuntur excepturi 
        totam quis id temporibus, cum cupiditate saepe natus quas illo! 
        Est non voluptate cumque veniam corrupti accusantium! Soluta quas 
        corrupti eveniet totam iste eos sit quidem modi molestiae, eaque 
        repellendus numquam aliquam blanditiis rerum nihil.
      </p>

      <?php
        if(!isset($_SESSION['username'])){
            echo '<p>You are currently not signed in <a href="LibraryLogin.php">Login </a>Not yet a member? <a href="SignUp.php">Signup</a></p>';
        }else{
            echo '<p>You are logged in as ' . 
            $_SESSION["username"] . 
            ' <a href="logout.php">Logout</a></p>';
        }
      ?>

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