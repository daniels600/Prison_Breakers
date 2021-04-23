<?php

//initialize a session
session_start();

// Include config file
include "../config/db_conn.php";

class Visitor {

    //Function to insert visitors data into database 
    public function insertVisitor($post){

        //creating an instance of db_connection 
        $db = new DB_connection();

        $vFname = $db->connect()->real_escape_string( $_POST['fName']);
        $vLname = $db->connect()->real_escape_string( $_POST['lName']);
        $rel = $db->connect()->real_escape_string( $_POST['rel']);
        $vContact = $db->connect()->real_escape_string($_POST['telephone']);
        $sex = $db->connect()->real_escape_string( $_POST['sex']);
        $visitDate = $db->connect()->real_escape_string( $_POST['visitDate']);
        $visitTime = $db->connect()->real_escape_string($_POST['visitTime']);
        $prisonerName= $db->connect()->real_escape_string( $_POST['prisonerName']);
        $prisonName = $db->connect()->real_escape_string($_POST['prison']);

        //Uncomment Test data for Testing 
        // $vFname = 'Eugene';
        // $vLname = 'Amanin';
        // $rel = 'Brother';
        // $vContact = '0203034022';
        // $sex = 'Male';
        // $visitDate = '2020-12-07';
        // $visitTime = '03:34:00';
        // $prisonerName= 'Prince Osei';
        // $prisonName = 'Tamale';

        if(!preg_match("/^[a-zA-Z ]*$/",  $vFname) && !preg_match("/^[a-zA-Z ]*$/", $vLname) && !preg_match("/^[a-zA-Z ]*$/", $rel) && !preg_match("/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/", $vContact) && !preg_match("/^[a-zA-Z ]*$/", $prisonerName) && !preg_match("/^[a-zA-Z ]*$/", $prisonName) && !preg_match("/^[a-zA-Z ]*$/", $sex)){
            $response['message'] = "Failed";
            return false;
        }else{

            //A query to insert into the database 
            $sql = "INSERT INTO Visitor( v_fname,v_lname,relationship,prisoner_name,sex,v_ph_number,time_of_visit,date_of_visit,Prison_name)
            VALUES(?,?,?,?,?,?,?,?,?)";

            //preparing the query
            if($stmt = $db->connect()->prepare($sql)){
                $stmt->bind_param('sssssssss',$vFname,$vLname,$rel,$prisonerName, $sex,$vContact,$visitTime,$visitDate,$prisonName);
            
                if($stmt->execute()){
                    $response['message'] = "Success";
                    return true;
                }else {
                    return false;
                }
            }else {
                $response['message'] = "Failed";
                    return false;
            }
            $stmt->close();
        }
    }


    //Function to Display all the visitors data in the Database
    public function Display_All_Visitors(){
        //creating an instance of db_connection 
        $db = new DB_connection();

        //A query to select the all visitors data
        $sql = "SELECT Person.FirstName, Person.LastName, Visitor.timeIn, Visitor.timeOut, Visitor.VisitDate FROM Visitor, PERSON WHERE VISITOR.PersonId = Person.PersonID";


        //executing the query
        $results = $db->connect()->query($sql);

        //Checking if rows have been affected 
        if ($results->num_rows > 0) {
            $data = array();
            while ($row = $results->fetch_assoc()) {

                //Saving data in an associative array
                $data[] = $row;
            }

            //returning the data
            return $data;

            }else{
            echo "No found records";
            }
    }

    //Function to display the a specific visitor data from the DB
    public function DisplayVisitor($id){
        //creating an instance of db_connection 
        $db = new DB_connection();

        //Uncomment to test if Display visitor with 
        //an Id works
        //$id=3;

        $sql = "SELECT * FROM Visitor WHERE visitor_id='$id'";
        
        $result = $db->connect()->query($sql);
        
        //checking if the query affected any row then is a success
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;

        }else{
            echo "Record not found";
        }
    }

    //A function to delete a specific visitor data from the DB
    public function DeleteVisitor($id){
         //creating an instance of db_connection 
         $db = new DB_connection();

         //Uncomment to test if Delete visitor works on a 
         //particular visitor id
         //$id= 3;

        //a query to delete the visitor record with this id
        $sql = "DELETE FROM Visitor WHERE Visitor_id='$id'";

        $result = mysqli_query($db->connect(),$sql);

        //checking if the query was successful and 
        if($result){
            return true;
        }else{
            return false;
        }
    }

    //Function to update a specific visitor's data
    public function UpdateVisitorData($visitorData){
        //creating an instance of db_connection 
        $db = new DB_connection();

        $id = $db->connect()->real_escape_string($_POST['visitor_id']);
        $vFname =  $db->connect()->real_escape_string($_POST['fName']);
        $vLname = $db->connect()->real_escape_string($_POST['lName']);
        $rel = $db->connect()->real_escape_string($_POST['rel']);
        $vContact =$db->connect()->real_escape_string($_POST['telephone']);
        $sex = $db->connect()->real_escape_string($_POST['sex']);
        $visitDate = $db->connect()->real_escape_string($_POST['visitDate']);
        $visitTime = $db->connect()->real_escape_string($_POST['visitTime']);
        $prisonerName= $db->connect()->real_escape_string($_POST['prisonerName']);
        $prison_name= $db->connect()->real_escape_string($_POST['prison']);
        
        //Uncomment Test data for Testing, changing First and last name
        // $vFname = 'Kwesi';
        // $vLname = 'Okai';
        // $rel = 'Brother';
        // $vContact = '0203034022';
        // $sex = 'Male';
        // $visitDate = '2020-12-07';
        // $visitTime = '03:34:00';
        // $prisonerName= 'Prince Osei';
        // $prison_name = 'Tamale';

        // $id =3;

        if(!preg_match("/^[a-zA-Z ]*$/",  $vFname) && !preg_match("/^[a-zA-Z ]*$/", $vLname) && !preg_match("/^[a-zA-Z ]*$/", $rel) && !preg_match("/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/", $vContact) && !preg_match("/^[a-zA-Z ]*$/", $prison_name) && !preg_match("/^[a-zA-Z ]*$/", $prisonerName) && !preg_match("/^[a-zA-Z ]*$/", $sex)){
            return false;
        }
        else{
            //Executing the query
            $result = $db->connect()->query("UPDATE Visitor SET v_fname='$vFname', v_lname='$vLname',relationship='$rel', prisoner_name='$prisonerName', v_ph_number = '$vContact', time_of_visit='$visitTime', date_of_visit='$visitDate', sex='$sex', Prison_name ='$prison_name' WHERE visitor_id='$id'");
            
            //Checking if the update query return a true or false
            if(isset($result)){
                return true;
            }else{
                return false;
            }

        }

    }


}