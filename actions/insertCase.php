<?php 
session_start();

require_once '../controllers/prisonerController.php';


$prisoner = new Prisoner();

$response = array();

if(isset($_POST['submit'])) {
   
    $prisoner->insertCaseForm($_POST);
}


















