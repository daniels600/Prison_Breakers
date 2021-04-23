<?php 

require_once '../controllers/prisonerController.php';

$prisoner = new Prisoner();

//checking for the id in the URL
if(isset($_GET['id'])){
    $prisonerID = $_GET['id'];

    //calling the delete method of prisoner class
    if($prisoner->deletePrisoner($prisonerID)){
        header('Location: ../views/prisoner.php?message=success');
    }

}






