<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'resource/utilities.php';


if(isset($_POST['loginBtn'])){

//array to hold errors
$form_errors = array();

//validate
$required_fields = array('username', 'password');
$form_errors = array_merge($form_errors, check_empty_fields($required_fields));

if(empty($form_errors)){

    //collect form data
    $user = $_POST['username'];
    $password = $_POST['password'];

    //check if user exists in the database
    $sqlQuery = "SELECT * FROM users WHERE username = :username";
    
    $statement = $db->prepare($sqlQuery);
    $statement->execute(array(':username' => $user));

    if($row = $statement->fetch()){
        $id = $row['id'];
        $hashed_password = $row['password'];
        $username = $row['username'];

        if(password_verify($password, $hashed_password)){
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            header("location: index.php");
        }else{
            $result = "<p class='regerror'>Invalid username or password<p>";
        }
    }else{
        $result = "<p class='regerror'>Invalid username or password<p>";
    }


}else{
    if(count($form_errors)==1){
        $result = "<p class='error'>There was one error in the form </p>";
    }else{
        $result = "<p class='error'>There were " . count($form_errors) . " errors in the form </p>";
    }
}

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

    <link rel="stylesheet" type="text/css" href="style/style.css"></link>
    <link rel="stylesheet" href="Library.css">

    <title>My Library Login</title>
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
                  <a href="Info.php" class="nav-link">Info</a>
              </li>
              <li class="nav-item">
                  <a href="LibraryLogin.php" class="nav-link active">Login</a>
              </li>
              <li class="nav-item">
                  <a href="SignUp.php" class="nav-link">Sign Up</a>
              </li>
          </ul>
      </div>
  </nav>


  <div class="container">
        



    <?php 
        if(isset($result)) echo $result; 
        if(!empty($form_errors)) echo show_errors($form_errors);
    ?>
  </div>



  <div class="container">
    <form method="post" action="">
        <div class="form-group ml-20px">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter username">
        </div>
        <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group form-check">
        </div>
        <button type="submit" name="loginBtn" class="btn btn-primary">Submit</button>
    </form>
    </div>

    <div class="container FWP">
        <p>     </p>
        <p>Forgot password?</p>
        <a href="request.php">Change password</a>
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