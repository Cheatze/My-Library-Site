<?php
include_once 'resource/session.php';
//include_once 'resource/Database.php';
//include_once 'resource/utilities.php';

if(!isset($_SESSION['username'])){
    //echo '<script>alert("If things are ok you are not logged in.")</script>';
    //de redirect voorkomt dat de alert gezien word
    //echo "<h1>If you are not logged in you should see this.</h1>";
    header('location: index.php');
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
    <link rel="stylesheet" type="text/css" href="style/style.css"></link>

    <!-- JS form validation script-->
    <script type="text/javascript" src="resource/scripts.js"></script>

    <title>My Library Book Entry</title>
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
                <a href="search.php" class="nav-link">Search</a>
                </li>
                <li class="nav-item">
                    <a href="browse.php" class="nav-link">Browse</a>
                </li>
              <li class="nav-item">
                  <a href="Info.php" class="nav-link">Info</a>
              </li>
              <li class="nav-item">
                  <a href="LibraryLogin.php" class="nav-link">Login</a>
              </li>
              <li class="nav-item">
                  <a href="SignUp.php" class="nav-link active">Sign Up</a>
              </li>
          </ul>
      </div>
  </nav>


  <div class="container">
    <h1 class="text-center display-4">My Library Book Entry</h1>

  </div>

  <!-- Also add owner with session variable
    Description?
    Series!
   -->

 <br>

<!--remove the js function for testing of php validation put back after method
    onsubmit="return validateForm()"
 -->
 <div class="container">
    <form name="boeker" action="upload.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">

        <div class="form-group ml-20px">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" name="title" class="form-control" aria-describedby="emailHelp" placeholder="Enter title" required>
        </div>
        <!--required-->
        <div class="form-group">
            <label for="exampleInputUsername1">Author</label>
            <input type="text" name="author" class="form-control" placeholder="Author" required>
        </div>

        <label for="exampleInputUsername1">Series (optional)</label>
        <div class="form-group">
            <input type="text" name="series" class="form-control" placeholder="Series">
        </div>
            
        <div class="form-group">
            <label for="exampleInputPassword1">Select image to upload: (optional)</label>
            <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" placeholder="">
        </div>

        <button type="submit" name="insertBtn" value="insertBtn"  class="btn btn-primary">Submit</button>
    </form>
 </div>

<br>

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