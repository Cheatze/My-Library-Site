<?php
/**
 * param $required_fields_array, an array containing the list of all required fields
 * return array containing all errors
 */

 function check_empty_fields($required_fields_array){

    //initialize an array to store any error messages from the form
    $form_errors = array();

        //loop through the required field array
    foreach($required_fields_array as $name_of_field){
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL){
            $form_errors[] = $name_of_field . " is a required field";
        }
    }

    return $form_errors;

 }


/**
  * param $fields_to_check_lenght, an array containing the name of fields
  * for which to check min required field lenght e.g array('username' => 4, 'email' => 12)
  * return array containing all errors
*/

function check_min_lenght($fields_to_check_lenght){
    //initialize an array to check error messages
    $form_errors = array();

    foreach($fields_to_check_lenght as $name_of_field => $minimum_lenght_required){
        if(strlen(trim($_POST[$name_of_field])) < $minimum_lenght_required){
            if($minimum_lenght_required == 1){
                $form_errors[] = $name_of_field . " is too short, must have at least {$minimum_lenght_required} letter long";
            }else{
                $form_errors[] = $name_of_field . " is too short, must have at least {$minimum_lenght_required} letters";
            }
        }
    }

    return $form_errors;
}


/**
 * param $data, store a key/value pair array where key is the name of form control
 * return array containing email errors
 */

 function check_email($data){
     //initialize an array to store error messages
     $form_errors = array();
     $key = 'email';
     //check if email exists in data array
     if(array_key_exists($key, $data)){

        //check if the email field has a value
        if($_POST[$key] != NULL){

            // remove all illegal characters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            //check if input is a valid email address
            if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false){
                $form_errors[] = $key . " is not a valid email address";
            }
        }
     }

     return $form_errors;
 }


 /**
  * param $form_errors_array, the array holding all errors we want to loop through
  * return string, list of all error messages
  */

function show_errors($form_errors_array){
    $errors = "<p><ul class='error'>";
    //style='color:red;'
    //loop through error array and display all items in a list
    foreach($form_errors_array as $the_error){
        $errors .= "<li> {$the_error} </li>";
    }
    $errors .= "</ul></p>";

    return $errors;
  }

  //slightly addapted function for the nonrelational image error array
function show_image_errors($image_errors_array){
    $errors = "<p><ul class='error'>";
    foreach($image_errors_array as $item){
        $errors .= $item;
    }
    $errors .= "</ul></p>";

    return $errors;
}


?>