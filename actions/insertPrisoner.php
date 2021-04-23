<?php 
//Using sessions 
// session_start();

require_once '../controllers/prisonerController.php';

$prisoner = new Prisoner();

//an array to get the messages 
$response = array();

if(isset($_POST['submit'])) {

    //calling the insert prisoner function 
    if($prisoner->insert_prisoner($_POST)){
        header('Location: ../views/forms/prisonerForm.php?message=success');
    }else{
        
    }

}
