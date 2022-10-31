<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

?>

<?php

//also use to refresh this page after a successful edit
$id = $_GET['id'];
$user = $_SESSION['username'];

//for the sake of edit code
$_SESSION['id'] = $id;

$query = "SELECT * FROM books WHERE id = '$id' and owner = :username";

$statement = $db->prepare($query);

$statement->execute(array(':username' => $user));

$row = $statement->fetch();


$title = $row['title'];
$author = $row['author'];
$series = $row['series'];
$owner = $row['owner'];
$file = $row['filename'];

//for deleting the old file if a new one is uploaded
$_SESSION['filename'] = $file;

//this has to go a bit farther down this time
//also make it that this username is the same as the owner of the book 
//else if( $owner == $_SESSION['username']){}
if(!isset($_SESSION['username'])){
    header('location: index.php');
}else if(! $user == $owner){
    header('location: index.php');
}


//the update code
if(isset($_POST['editbtn'])){

    //colect form text data and store in variables
    $newtitle = $_POST['title'];
    $newauthor = $_POST['author'];
    $newseries = $_POST['series'];
    $id = $_SESSION['id'];
    $owner = $_SESSION['username']; //yea, owner would never have to be changed, but required for right image folder

    //for deleting the old file
    $filetoDelete = $_SESSION['filename'];

    //There are no required fields?
    //Make it so only the filled in fields are used
    //There is still validation required for the maximum size of each field
    //It would be easier if I just required every field to be filled in again?
    //also remember to include the scripts.js if I'm going to use that
    
    //another error array
    

    //initialize an array to store any error messages from the form
    $form_errors = array();

    //form validation
    $required_fields = array('title','author');

    //call the function to check empty fields and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    //Fields that require checking for minimum lenght
    $fields_to_check_lenght = array('title' => 1, 'author' => 1);

    //call the function to check the minimum lenght and merge the return data into the form_error array
    $form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_lenght));


    //Put this above the form inside something that makes it go if it is so
    //along with a similar thing for the image 
    //I think I have something like that in the sign up page
    //show form text errors
    /*if(!empty($form_errors)){
        echo show_errors($form_errors);
    }*/

    //file variables
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    
    $fileToUpload = $_FILES['fileToUpload']['name'];


    //change to personal folder
    $uploaddir = "uploads/$owner/";
    $uploadfile = $uploaddir . basename($_FILES['fileToUpload']['name']);
    $file_errors = 1;

    //only do the following if file is not empty
    if($file_name != ""){

        //$file_ext=strtolower(end(explode('.',$_FILES['fileToUpload']['name'])));
        $file_errors = 0;
    
        //check if filesize is over 4mb, use smaller size for testing 4194304 bytes
        if($file_size > 4194304){
            //put into array
            echo "<br>File too large";
            $file_errors = 1;
        }
    
            //check for valid extentions
            //jpg|\.jpeg|\.bmp|\.gif|\.png
            // Allow certain file formats 
        if(substr($file_type, -4)=="jpeg"){
            $file_ex = substr($file_type, -4);
        }else{
            $file_ex = substr($file_type, -3);
        }
    
        if($file_ex != "jpg" && $file_ex != "png" && $file_ex != "jpeg"
            && $file_ex != "gif" ) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            echo "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $file_errors = 1;
        }
    
    
        //how can I check if the file already exists?
        //which was the entire filepath again? $uploadfile I think
        if (file_exists($uploadfile)) {
            echo "<br>The file file already exists";
            $file_errors = 1;
        }
    
    }

    //initialize image errors array
    //.. I don't think this is used anywhere
    $I = 0;
    $image_errors = array();


    //Edit db if $form_errors is empty
    if(empty($form_errors)){


        //update the title, if a new one was given
        //a new title is still mandatory but maybe I'll change that later
        if($newtitle!=""){

            $sqlEdit = "UPDATE books SET title = :title WHERE id = :id";

            //use PDO prepare to sanitize data
            $statement = $db->prepare($sqlEdit);

            //execute the statement
            $statement->execute(array(':title' => $newtitle, 'id' => $id));

        }

        if($newseries!=""){

            $sqlEdit = "UPDATE books SET series = :series WHERE id = :id";

            //use PDO prepare to sanitize data
            $statement = $db->prepare($sqlEdit);
        
            //execute the statement
            $statement->execute(array(':series' => $newseries, 'id' => $id));

        }

        if($newauthor!=""){

            $sqlEdit = "UPDATE books SET author = :author WHERE id = :id";

            //use PDO prepare to sanatize data
            $statement = $db->prepare($sqlEdit);

            //execute the statment
            $statement->execute(array(':author' => $newauthor, 'id' => $id));

        }

        //also change the filename in the database
        if($file_name!=""){

            $sqlEdit = "UPDATE books SET filename = :filename WHERE id = :id";

            //use PDO prepare to sanatize data
            $statement = $db->prepare($sqlEdit);

            //execute the statment
            $statement->execute(array(':filename' => $file_name, 'id' => $id));

        }


        //upload file if file errors is zero
        if($file_errors==0){

            //replace the image if there is one
            //"uploads . $owner . $file; if old file is not empty inside the upload if for the new file
            if($file!=""){
                $toDelete = 'uploads/' . $owner . '/' . $filetoDelete;
                unlink($toDelete);
            }

            
            //the echos are usless here since this page refreshes itself
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
                echo "<br>File is valid, and was successfully uploaded.<br>";
            } else {
                echo "<br>NOT UPLOADED!";
            }
        
        }

        //refresh page after successful edit
        header("Refresh:0");
    }
    

}

//the update code
if(isset($_POST['deletebtn'])){

    //echo '<script language="javascript">alert("Got into delete.");</script>';
    $id = $_SESSION['id'];

    //$sqlEdit = "UPDATE books SET author = :author WHERE id = :id";
    $sqlDelete = "DELETE FROM books WHERE id = :id";

    //use PDO prepare to sanatize data
    $statement = $db->prepare($sqlDelete);

    //execute the statment
    $statement->execute(array('id' => $id));

    header('location: index.php');
}

?>

<html>
<?php
    include_once 'resource/header.php';
?>
<body>
<?php 
    include_once 'resource/navbar.php';
?>

<div style="padding: 10px 20px;" class="container">
<?php 

//add some bootstrap, jumbotron?

echo "<h4>Title: $title</h4>";
//isset($series) werkt niet de tags zijn nog steeds te zien. mischien !==""?
if($series != ""){
    echo "<h4>Series: $series</h4>";
};
echo "<h4>Author: $author</h4>";
//echo "The filename is $file";

//image with uploads/$owner/$file as path
//<img src="smiley.gif" alt="Smiley face" height="42" width="42">

//only show image tags or series if the series exists and entry has an image
if($file != ""){
    include_once 'resource/bookimage.php';
}
?>


<form method="post" action="">
    <button name="Edit">Edit entry</button>
</form>
</div>

<?php
    //loop through error array, with a for loop?
    //if(isset()){} or if(!empty()){}
    if(!empty($form_errors)){
        echo show_errors($form_errors);
    }

?>


<?php
    if(isset($_POST['Edit'])){
        //echo "<div class='container'><h3>Appear!</h3></div>";
        include_once 'resource/editform.php';
    }
?>

    <!-- JS form validation script, also works down here right?-->
    <script type="text/javascript" src="resource/scripts.js"></script>
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

