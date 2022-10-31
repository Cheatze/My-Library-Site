<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

    
    if(!isset($_SESSION['username'])){
        //echo '<script>alert("If things are ok you are not logged in.")</script>';
        //de redirect voorkomt dat de alert gezien word
        //echo "<h1>If you are not logged in you should see this.</h1>";
        header('location: index.php');
    }

    //redirect links back to insert and index
    echo "<br><a href='insertBook.php'>Back to insert</a><br>";
    echo "<br><a href='index.php'>Back to Index</a>";

    //colect form text data and store in variables
    $title = $_POST['title'];
    $author = $_POST['author'];
    $series = $_POST['series'];
    $owner = $_SESSION['username'];

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

    //show form text errors
    if(!empty($form_errors)){
        echo show_errors($form_errors);
    }


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
    //echo $uploadfile;
    //print_r($_FILES);

    //only do the following if file is not empty
    if($file_name != ""){

        //$file_ext=strtolower(end(explode('.',$_FILES['fileToUpload']['name'])));
        $file_errors = 0;

        //check if filesize is over 4mb, use smaller size for testing 4194304 bytes
        if($file_size > 4194304){
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
    $I = 0;
    $image_errors = array();


       
    //insert into db if $form_errors is empty
    if(empty($form_errors)){
        
        //create sql insert statement
        $sqlInsert = "INSERT INTO books (title, author, series, filename, owner)
        VALUES (:title, :author, :series, :filename, :owner)";
        
        //use PDO prepare to sanitize data
        $statement = $db->prepare($sqlInsert);
        
        //replace $fileToUpload with $uploadfile?
        $statement->execute(array(':title' => $title, ':author' => $author, ':series' => $series, 
        ':filename' => $fileToUpload, 'owner' => $owner));

        echo "<br><h3>Insert success!</h3>";

        //upload file if file errors is zero
        if($file_errors==0){

            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
                echo "<br>File is valid, and was successfully uploaded.<br>";
            } else {
                echo "<br>NOT UPLOADED!";
            }

        }
    }


    /* THESE WORK PUT BACK IN WHEN FROM VALIDATION WORKS IF NO ERRORS
    //upload when there are no file related errors
    if(){
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadfile)) {
            echo "<br>File is valid, and was successfully uploaded.<br>";
        } else {
            echo "<br>NOT UPLOADED!";
        }
    }

    //insert into database when there are no text errors
    if(){
        //create sql insert statement
        $sqlInsert = "INSERT INTO books (title, author, series, filename, owner)
        VALUES (:title, :author, :series, :filename, :owner)";


        //use PDO prepare to sanitize data
        $statement = $db->prepare($sqlInsert);


        //replace $fileToUpload with $uploadfile?
        $statement->execute(array(':title' => $title, ':author' => $author, ':series' => $series, 
        ':filename' => $fileToUpload, 'owner' => $owner));
    }
    */








//print_r($_FILES);
//print "</pre>";
?>

<html>
<body>

</body>
</html>