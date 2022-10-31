<?php 
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'resource/utilities.php';


if(!isset($_SESSION['user_id_reset_pass'])){
    //echo '<script>alert("If things are ok you are not logged in.")</script>';
    //de redirect voorkomt dat de alert gezien word
    //echo "<h1>If you are not logged in you should see this.</h1>";
    header('location: index.php');
}else{
    $id = $_SESSION['user_id_reset_pass'];
}


//process form if the reset button is clicked
if(isset($_POST['passwordResetBtn'])){
    //initialize array to store errors from the form
    $form_errors = array();

    //form validation
    $required_fields = array(/*'email',*/'new_password','confirm_password');

    //call function to check empty fields and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //fields that require checking for minimum length
    $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

    //call check minimum length and merge return data into form_error array
    $form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_length));

    //email validation merge return data into form_error array
    //$form_errors = array_merge($form_errors, check_email($_POST));

    //check if error array is empty, if so process form data and insert record
    if(empty($form_errors)){
        //collect form data and store it in variables
       /*$email = $_POST['email'];*/
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        //check if new password and confirm password are the same
        if($password1 != $password2){
            $result = "<p class='regerror'>New password and confirm password do not match</p>";
        }else{
            try{
                //create SQL select statement to verify if user id exists in the database
                $sqlQuery = "SELECT id FROM users WHERE id =:id";

                //use PDO prepare to sanatize data
                $statement = $db->prepare($sqlQuery);

                //execute the query
                $statement->execute(array(':id' => $id));

                //check if record exists
                if($statement->rowCount() == 1){
                    //hash the password
                    $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                    //SQL statment to update password
                    $sqlUpdate = "UPDATE users SET password =:password WHERE id=:id";

                    //use PDO prepare to sanatize SQL statement
                    $statement = $db->prepare($sqlUpdate);

                    //execute the statement
                    $statement->execute(array(':password' => $hashed_password, 'id' => $id));

                    //Remove token entry from password_reset_request
                    //remove row where $id/:id is user_id
                    $sqlDelete = "DELETE FROM password_reset_request WHERE user_id = :user_id";
                    $statement = $db->prepare($sqlDelete);
                    $statement->execute(array(':user_id' => $id));

                    $result = "<p class='regsuccess'>Password Reset Successful</p>";
                }else{
                    $result = "<p class='regerror'>The email provided does not exist in the database, please try again.</p>";
                }
            }catch(PDOException $ex){
                $result = "<p class='regerror'>An error occurred: " . $ex->getMessage() . "</p>";
            }
        }
    }else{
        if(count($form_errors)==1){
            $result = "<p class='error'>There was one error in the form <br>";
        }else{
            $result = "<p class='error'>There were " . count($form_errors) . " errors in the form<br>";
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

    <link rel="stylesheet" href="Library.css">
    <link rel="stylesheet" type="text/css" href="style/style.css"></link>

    <title>My Library Password Reset</title>
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
    <h1 class="text-center display-4">My Library Password Reset</h1>

    <?php 
        if(isset($result)){
            echo $result;
        }
        if(!empty($form_errors)){
            echo show_errors($form_errors);
        }
    ?>
  </div>

  <div class="container">
    <form method="post" action="">
        <!--<div class="form-group ml-20px">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>-->
        <div class="form-group">
        <label for="exampleInputPassword1">New Password</label>
        <input type="password" name="new_password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group">
        <label for="exampleInputPassword1">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button type="submit" name="passwordResetBtn"  class="btn btn-primary">Submit</button>
    </form>
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