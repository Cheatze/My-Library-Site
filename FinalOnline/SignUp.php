<?php
include_once 'resource/session.php';
//Add database conection script
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

//process the form
if(isset($_POST['signupBtn'])){

    //colect form data and store in variables
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //initialize an array to store any error messages from the form
    $form_errors = array();

    //check if username already exists in the database
    $sqlQuery = "SELECT * FROM users WHERE username = '$username'";
    $result = $db->query($sqlQuery);
    $row = $result->fetch();
    if(isset($row['username'])){
        $form_errors[] = "Username already exists.";
    }

    //form validation
    $required_fields = array('email','username','password');

    //call the function to check empty fields and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //Fields that require checking for minimum lenght
    $fields_to_check_lenght = array('username' => 4, 'password' => 6);

    //call the function to check the minimum lenght and merge the return data into the form_error array
    $form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_lenght));

    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));


    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)){

        //hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try{

            //create sql insert statement
            $sqlInsert = "INSERT INTO users (username, email, password, join_date)
                          VALUES (:username, :email, :password, now())";

            //use PDO prepare to sanitize data
            $statement = $db->prepare($sqlInsert);

            //add the data to the database
            $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));


            //check if one new row was created
            if($statement -> rowCount() == 1){

                //create new folder with the name of username
                $curdir = getcwd();
                mkdir("$curdir/uploads/$username", 0777);

                $result = "<p style='padding:20px; border: 1px solid gray; color:green;'>Registration Successful</p>";

                //send con email script here

            }
        }catch(PDOException $ex){

            echo "<p>Something something</p>";

            $result = "<p style='padding:20px; border: 1px solid gray; color:red;'>An error occcured: " . $ex->getMessage() . "</P>";

        }

    }else{

        if(count($form_errors) == 1){
            $result = "<p style='color:red;'>There was one error in the form <br>";

            // $result .= "<ul style='color:red;'>";
            // //loop through error array and display all items
            // foreach($form_errors as $error){
            //     $result .= "<li> {$error} </li>";
            // }
            // $result .= "</ul></p>";

        }else{
            $result = "<p style='color:red;'>There were " . count($form_errors) . " errors in the form <br>";

            // $result .= "<ul style='color:red;'>";
            // //loop through error array and display all items
            // foreach($form_errors as $error){
            //     $result .= "<li> {$error} </li>";
            // }
            // $result .= "</ul></p>";
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

    <title>My Library Sign Up</title>
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
                  <a href="LibraryLogin.php" class="nav-link">Login</a>
              </li>
              <li class="nav-item">
                  <a href="SignUp.php" class="nav-link active">Sign Up</a>
              </li>
          </ul>
      </div>
  </nav>


  <div class="container">
    <h1 class="text-center display-4">My Library Sign UP</h1>

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
        <div class="form-group ml-20px">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
        <label for="exampleInputUsername1">Username</label>
        <input type="text" name="username" class="form-control" id="exampleInputUsername1" placeholder="Username">
        </div>
        <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button type="submit" name="signupBtn"  class="btn btn-primary">Submit</button>
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
