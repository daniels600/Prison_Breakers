<?php


// Include config file
include "../config/db_conn.php";


class Prisoner
{
    //Creating properties
    private $prisonerID;
    private $policeOfficerID;
    private $caseID;


    // PrisonerID getter function
    public function getPrisonerID()
    {
        return $this->prisonerID;
    }

    //PrisonerID setter function
    public function setPrisonerID($prisonerID)
    {
        $this->prisonerID = $prisonerID;
    }

    //PoliceOfficerID getter function
    public function getPoliceOfficerID()
    {
        return $this->policeOfficerID;
    }

    //PoliceOfficer setter function
    public function setPoliceOfficerID($policeOfficerID)
    {
        $this->policeOfficerID = $policeOfficerID;
    }

    //CaseID getter function 
    public function getCaseID()
    {
        return $this->caseID;
    }

    //CaseID setter function
    public function setCaseID($caseID)
    {
        $this->caseID = $caseID;
    }


    //A method to insert prisoner details 
    public function insert_prisoner($post)
    {
        session_start();

        //creating an instance of db_connection 
        $db = new DB_connection();

        $tm = md5(time()); //Hashing to make an image unique

        //Getting all the post or submitted input values
        $prisonerFname = $db->connect()->real_escape_string($_POST['pFname']);
        $prisonerLname = $db->connect()->real_escape_string($_POST['pLname']);
        $nationality = $db->connect()->real_escape_string($_POST['nationality']);
        $prison = $db->connect()->real_escape_string($_POST['prison']);
        $height = $db->connect()->real_escape_string($_POST['height']);
        $weight = $db->connect()->real_escape_string($_POST['weight']);
        $dob = $db->connect()->real_escape_string($_POST['dob']);
        $sex = $db->connect()->real_escape_string($_POST['gender']);
        $marital_status = $db->connect()->real_escape_string($_POST['marital_status']);
        $inmateStatus = $db->connect()->real_escape_string($_POST['inmateStatus']);
        $eyeColor = $db->connect()->real_escape_string($_POST['eyeColor']);
        $complexion = $db->connect()->real_escape_string($_POST['complexion']);
        $telephone = $db->connect()->real_escape_string($_POST['telephone']);
        $cellBlock = $db->connect()->real_escape_string($_POST['cellBlock']);
        $streetAddr = $db->connect()->real_escape_string($_POST['streetAddr']);
        $city = $db->connect()->real_escape_string($_POST['city']);
        $state = $db->connect()->real_escape_string($_POST['state']);
        $PostalCode = $db->connect()->real_escape_string($_POST['PostalCode']);
        $nextKinF = $db->connect()->real_escape_string($_POST['nextKinF']);
        $nextKinL = $db->connect()->real_escape_string($_POST['nextKinL']);
        $kinRelation = $db->connect()->real_escape_string($_POST['kinRelation']);
        $release_date = $db->connect()->real_escape_string($_POST['release_date']);

        $policeId = isset($_SESSION['policeOfficeId']) ? $_SESSION['policeOfficeId'] : $this->getPoliceOfficerID();
        $image_name = $_FILES['image']['name'];
        $dst = "../prisonerImages/" . $tm . $image_name;
        $dst1 = "prisonerImages/" . $tm . $image_name;
        $image_type = $_FILES['image']['type']; // getting the type to check if it is an image
        


        //Uncomment data below to use for PHP Unit Testing
        // $prisonerFname = 'Eugene';
        // $prisonerLname = 'Daniels';
        // $nationality = 'Ghanaian';
        // $prison = 'Ankaful';
        // $height = 23.00;
        // $weight = 33.00;
        // $dob = '2020-12-17';
        // $sex = 'Female';
        // $marital_status = 'Single';
        // $inmateStatus = 'Remand';
        // $eyeColor = 'Brown';
        // $complexion = 'Fair';
        // $telephone = '0293092343';
        // $cellBlock = 'H';
        // $streetAddr = 'Ajakroba st.';
        // $city = 'Accra';
        // $state = 'Greater Accra';
        // $PostalCode = 'P.o.Box BY3223';
        // $nextKinF = 'Mohammed';
        // $nextKinL = 'Mohammed';
        // $kinRelation = 'Brother';
        // $release_date = '2020-12-17';

        // $policeId = 1;


        // checking file upload if it is an image
        if (
            !empty($_FILES['image']['tmp_name'])
            && file_exists($_FILES['image']['tmp_name'])
        ) {
            $data = addslashes(file_get_contents($_FILES['image']['tmp_name']));

            $allowed = array("image/jpeg", "image/gif", "image/png", "image/jpg");

            if (!in_array($image_type, $allowed)) {
                //$error_message = 'Only jpg, gif, and png files are allowed.';
                header("Location: ../views/forms/prisonerForm.php?error=wrongImage");
                exit();
            } else {
                move_uploaded_file($_FILES['image']['tmp_name'], $dst);
            }
        }

        //Validating with regex
        if(!preg_match("/^[a-zA-Z ]*$/", $prisonerFname) && !preg_match("/^[a-zA-Z ]*$/", $prisonerLname) && !preg_match("/^[a-zA-Z ]*$/", $nationality) && !preg_match("/^[a-zA-Z ]*$/", $prison) && !preg_match("/^[a-zA-Z ]*$/", $eyeColor) && preg_match("/^[a-zA-Z ]*$/", $complexion) && preg_match("/^[a-zA-Z ]*$/", $inmateStatus)
        && !preg_match("/^[ A-Za-z0-9 z.,\/+-]*$/", $city) && !preg_match("/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/", $telephone) && !preg_match("/^[A-Za-z -]*$/", $state) && !preg_match("/^[ A-Za-z0-9 _.,\/+-]*$/", $PostalCode) && !preg_match("/^[a-zA-Z ]*$/", $nextKinF) && !preg_match("/^[a-zA-Z ]*$/", $nextKinL) &&!preg_match("/^[a-zA-Z ]*$/", $kinRelation)) 
        {
            $response['message'] = "Failed";
            echo 'What is it';
            return false;
            
        }else{
            //A query to insert a new prisoner
            $sql = "INSERT INTO Prisoner(Cell_block, P_Officer_Id,Prison_name, Prisoner_fname,Prisoner_lname,DOB,P_complexion,Marital_Status,Sex,Height_feets, Weight_kg,Nationality,Prisoner_tel,Next_of_Kin_fname,Next_of_Kin_lname,Next_of_Kin_Rel,Eye_color,Prisoner_status,address_street,address_city, address_region, address_postal_code,image)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            //preparing the query statement 
            $stmt = $db->connect()->prepare($sql);
            $stmt->bind_param('sdsssssssddssssssssssss', $cellBlock, $policeId, $prison, $prisonerFname, $prisonerLname, $dob, $complexion, $marital_status, $sex, $height, $weight, $nationality, $telephone, $nextKinF, $nextKinL, $kinRelation, $eyeColor, $inmateStatus, $streetAddr, $city, $state, $PostalCode, $dst1);


            //checking the execution of the query statement
            if ($stmt->execute()) {
                //getting the last inserted data id 
                $prisonerId = mysqli_insert_id($db->conn);

                $this->setPrisonerID($prisonerId);

                $_SESSION['prisonerId'] = $prisonerId;

                $prisonerId = isset($_SESSION['prisonerId']) ? $_SESSION['prisonerId'] : $this->getPrisonerID();

                $response['message'] = "Success";
                $caseId = isset($_SESSION['caseId']) ? $_SESSION['caseId'] : $this->getCaseID();

                //query to insert into the prisoner_case table
                $query = "INSERT INTO Prisoner_case(Case_id,Prisoner_id,Latest_Possible_Date)
                VALUES('$caseId', '$prisonerId','$release_date')";

                $result = $db->connect()->query($query);

                if ($result) {
                    //unset or removing the session variables from the policeOfficer and case forms
                    unset($_SESSION['policeOfficeId']);
                    unset($_SESSION['caseId']);

                    return true;
                  
                } else {
                    $response['message'] = "Failed";
                    return false;
                }
            } else {
               return false;

            }
        }
    }



    //A method to insert the case details
    public function insertCaseForm($post)
    {
        // session_start();
        $errors = [];

        //creating an instance of db_connection 
        $db = new DB_connection();

        //getting the post data from the form and checking
        $magFname = $db->connect()->real_escape_string($_POST['mFname']);
        $magLname = $db->connect()->real_escape_string($_POST['mLname']);
        $court = $db->connect()->real_escape_string($_POST['court']);
        $crime = $db->connect()->real_escape_string($_POST['crime']);
        $catOffence = $db->connect()->real_escape_string($_POST['CatOffence']);
        $caseStartDate = $db->connect()->real_escape_string($_POST['case_start_date']);
        $caseEndDate = $db->connect()->real_escape_string($_POST['case_end_date']);
        $crimeTime = $db->connect()->real_escape_string($_POST['crimeTime']);
        $dateCrime = $db->connect()->real_escape_string($_POST['crimeDate']);
        $sentence = $db->connect()->real_escape_string($_POST['sentenceLength']);

        //Validating the case details submitted 
        if(!preg_match("/^[a-zA-Z ]*$/", $magFname) && !preg_match("/^[a-zA-Z ]*$/", $magLname) && !preg_match("/^[a-zA-Z ]*$/", $court) && !preg_match("/^[a-zA-Z ]*$/", $crime) && !preg_match("/^[a-zA-Z ]*$/", $catOffence) && !preg_match("/^[0-9]*$/", $sentence)){
            $response['message'] = "Failed";
        }
        else{
            //  A query to insert a new case 
            $sql = "INSERT into Cases(case_start_date,case_end_date,crime_committed,Category_of_Offence,Crime_time,Crime_date, sentence_length_Years,Court_of_commital,Magistrate_fname,Magistrate_lname) 
            VALUES(?,?,?,?,?,?,?,?,?,?)";

            $stmt = $db->connect()->prepare($sql);
            $stmt->bind_param('ssssssdsss', $caseStartDate, $caseEndDate, $crime, $catOffence, $crimeTime, $dateCrime, $sentence, $court, $magFname, $magLname);


            if ($stmt->execute()) {

                $caseId = mysqli_insert_id($db->conn);

                //setting the caseId
                $this->setCaseID($caseId);

                //Having a session for the caseId
                $_SESSION['caseId'] = $caseId;
                $response['message'] = "Success";

                // redirect if the case record was inserted successfully
                header('Location: ../views/forms/caseForm.php?message=success');
            } else {
                $response['message'] = "Failed";
            }

            //$stmt->close();
            echo json_encode($response);
            $stmt->close();
        }

    }


    public function insertPoliceOfficer($postdata)
    {
        session_start();

        //creating an instance of db_connection 
        $db = new DB_connection();

        //getting the post data from the form and checking
        $officerFname = $db->connect()->real_escape_string($_POST['pFname']);
        $officerLname = $db->connect()->real_escape_string($_POST['pLname']);
        $serviceId = $db->connect()->real_escape_string($_POST['serviceId']);
        $officerContact = $db->connect()->real_escape_string($_POST['pContact']);
        $stationContact = $db->connect()->real_escape_string($_POST['stationContact']);
        $ranks = $db->connect()->real_escape_string($_POST['ranks']);
        $stationName = $db->connect()->real_escape_string($_POST['stationName']);

        //Validating the police officer details submitted using regex
        if(!preg_match("/^[a-zA-Z ]*$/",  $officerFname) && !preg_match("/^[a-zA-Z ]*$/", $officerLname) && !preg_match("/^[a-zA-Z0-9 ]*$/", $serviceId) && !preg_match("/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/", $officerContact) && !preg_match("/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/", $stationContact) && !preg_match("/^[0-9]*$/", $stationName)){
            $response['message'] = "Failed";
        } else{
            // A query to insert a new policeOfficer record 
            $sql = "INSERT INTO Police_Officer(Service_ID, P_fname, P_lname,Ranks, Officer_contact,Police_Station,Station_Tel)
            VALUES(?,?,?,?,?,?,?)";

            $stmt = $db->connect()->prepare($sql);
            $stmt->bind_param('sssssss', $serviceId, $officerFname, $officerLname, $ranks, $officerContact, $stationName, $stationContact);


            // checking if query was a success
            if ($stmt->execute()) {
                $response['message'] = "Success";

                //Getting the last inserted policeOfficer data
                $policeOfficerId = mysqli_insert_id($db->conn);

                $this->setPoliceOfficerID($policeOfficerId);

                $_SESSION['policeOfficeId'] =  $policeOfficerId;

                header('Location: ../views/forms/policeOfficerForm.php?message=success');

            } else {
                $response['message'] = "Failed";
                echo ("The error is " . mysqli_error($db->connect()));
            }
            // echo json_encode($response);
            $stmt->close();
        }
    }


    public function Display_All_Prisoners()
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        //A query to get all prisoners details

        $sql = "SELECT FirstName,LastName,prisoner.PrisonerId, work_id,income, Age, SkinColor
        FROM WORK_ALLOTMENT, person,prisoner
        WHERE  WORK_ALLOTMENT.prisonerID=PRISONER.prisonerID and person.PersonId=PRISONER.personID order by FirstName asc";

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
        } else {
            echo "No found records";
        }
    }

    //A method to display a prisoner Detail
    public function DisplayPrisonerBio($id)
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        //A query to select a specific prisoner by his/her ID
        $sql1 = "SELECT * from Prisoner where Prisoner_id = '$id'";

        //Executing the query
        $result = $db->connect()->query($sql1);

        //checking if the query affected any row then is a success
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            echo "Record not found";
        }
    }

    //A method to get the prisoner Case details 
    public function getPrisonerCase($id)
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        $sql2 = "SELECT * from Prisoner_case where Prisoner_id = '$id'";

        $record =  $db->connect()->query($sql2);

        //checking if the query affected any row then is a success
        if ($record->num_rows > 0) {
            $row = $record->fetch_assoc();
            return $row;
        } else {
            echo "Record not found";
        }
    }

    //A method to get the Case Info details
    public function getCaseDetails($idCase)
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        // A query to get a specific case information
        $sql3 = "SELECT * from Cases where Case_id = '$idCase'";
        $case_record =   $db->connect()->query($sql3);


        //checking if the query affected any row then is a success
        if ($case_record->num_rows > 0) {
            $row = $case_record->fetch_assoc();
            return $row;
        } else {
            echo "Record not found";
        }
    }

    //A method to get the PoliceOfficer details
    public function getOfficerDetails($id)
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        $sql4 = "SELECT * from Police_Officer where P_Officer_Id = '$id'";
        $officerRecords = $db->connect()->query($sql4);


        //checking if the query affected any row then is a success
        if ($officerRecords->num_rows > 0) {
            $row = $officerRecords->fetch_assoc();
            return $row;
        } else {
            echo "Record not found";
        }
    }


    //a method to update the prisoner Information
    public function updatePrisonerInfo($id)
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        //getting the post data from the form and checking
        $idUpdate = $db->connect()->real_escape_string($_POST['prisoner_id']);
        $fname = $db->connect()->real_escape_string($_POST['pFname']);
        $lname = $db->connect()->real_escape_string($_POST['pLname']);
        $prison_name = $db->connect()->real_escape_string($_POST['prison']);
        $pComplexion = $db->connect()->real_escape_string($_POST['complexion']);
        $dob = $db->connect()->real_escape_string($_POST['dob']);
        $Marital_Status = $db->connect()->real_escape_string($_POST['marital_status']);
        $Height_feets = $db->connect()->real_escape_string($_POST['height']);
        $Weight_kg = $db->connect()->real_escape_string($_POST['weight']);
        $Sex = $db->connect()->real_escape_string($_POST['gender']);
        $cell_block = $db->connect()->real_escape_string($_POST['cellBlock']);
        $Nationality = $db->connect()->real_escape_string($_POST['nationality']);
        $Prisoner_tel = $db->connect()->real_escape_string($_POST['telephone']);
        $Next_of_Kin_fname = $db->connect()->real_escape_string($_POST['nextKinF']);
        $Next_of_Kin_lname = $db->connect()->real_escape_string($_POST['nextKinL']);
        $Next_of_Kin_Rel = $db->connect()->real_escape_string($_POST['kinRelation']);
        $Eye_color = $db->connect()->real_escape_string($_POST['eyeColor']);
        $Prisoner_status = $db->connect()->real_escape_string($_POST['inmateStatus']);
        $address_street = $db->connect()->real_escape_string($_POST['streetAddr']);
        $address_city = $db->connect()->real_escape_string($_POST['city']);
        $address_region = $db->connect()->real_escape_string($_POST['state']);
        $address_postal_code = $db->connect()->real_escape_string($_POST['PostalCode']);


        //A query to update the prisoner information 
        $updatePrisoner = $db->connect()->query( "UPDATE Prisoner SET Prisoner_fname='$fname', Prisoner_lname=' $lname', Prison_name ='$prison_name', P_complexion='$pComplexion', dob='$dob',marital_status='$Marital_Status',Height_feets='$Height_feets', Weight_kg='$Weight_kg',Sex='$Sex',cell_block='$cell_block',nationality='$Nationality',Prisoner_tel='$Prisoner_tel', Next_of_Kin_fname='$Next_of_Kin_fname',Next_of_Kin_lname= '$Next_of_Kin_lname',Next_of_Kin_Rel='$Next_of_Kin_Rel', Eye_color ='$Eye_color', Prisoner_status = '$Prisoner_status',address_street='$address_street',address_city='$address_city',address_region='$address_region',address_postal_code='$address_postal_code' WHERE Prisoner_id=$idUpdate");

        if ($updatePrisoner) {
            return true;
        } else {
            return false;
        }
    }


    //A method to delete a prisoner from the Database 
    public function deletePrisoner($id)
    {
        //creating an instance of db_connection 
        $db = new DB_connection();

        // a query to delete the prisoner record
        $sql = "DELETE FROM Prisoner WHERE Prisoner_id='$id'";

        //checking if the query is successful
        if ($db->connect()->query($sql)) {
            return true; 
        }else{
            return false;
        }
    }
}
