<?php

require_once '../controllers/prisonerController.php';

//checking for an id in the url to this page 
if(isset($_GET['id'])){
    $id = $_GET['id'];

    //creating an instance of Employee 
    $prisoner = new Prisoner();

    //storing the prisoner bio in a variable
    $prisonerBio = $prisoner->DisplayPrisonerBio($id);

    //getting prisoner case details
    $prisonerCaseInfo = $prisoner->getPrisonerCase($id);

    //saving the case info in a variable
    $caseInfo = $prisoner->getCaseDetails($prisonerCaseInfo['Case_id']);

    //getting the prisoner's image
    $image = isset($prisonerBio['image'])? $prisonerBio['image'] : "";
    $imageSrc = "../". $image;

    //policeOfficer ID
    $policeOfficerID =$prisonerBio['P_Officer_Id'];

    //getting officer details
    $policeOfficerInfo = $prisoner->getOfficerDetails($policeOfficerID);


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="styles.css">
  <title>View Details</title>
  <link rel="icon" href="../assets/images/imageedit_28_3939584200.png" type="image/png">
</head>

<body>
  <br />
  <div class="container emp-profile">
    <div class="row">
      <div class="col-md-4">
        <div class="profile-img">
            <img src="<?php echo  $imageSrc; ?>" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="profile-head">
          <h3>
            <?php echo 'Name: '.$prisonerBio['Prisoner_fname'] . ' ' . $prisonerBio['Prisoner_lname']; ?>
          </h3>
          <h3>
            <p>Inmate Status: <?php echo $prisonerBio['Prisoner_status']; ?></p>
          </h3>
          <h3>
            <p>Accused Crime: <?php echo $caseInfo['crime_committed']; ?></p>
          </h3>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Personal Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Case Details</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2">
        <a class="btn btn-primary" href="prisoner.php" role="button">Back</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">

      </div>
    </div>
    <div class="col-md-8">
      <div class="tab-content profile-tab" id="myTabContent" style='padding-left:40%; text-align:center;font-size:large'>
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="row">
            <div class="col-md-6">
              <label><strong>Nationality</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Nationality']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Gender</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Sex']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Date of Birth</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['DOB']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Marital Status</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Marital_Status']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Contact</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Prisoner_tel']; ?></p>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-6">
              <label><strong>Height</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Height_feets'].' feet'; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Weight</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Weight_kg'].' pounds'; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Kin's Name</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Next_of_Kin_fname'].' '.$prisonerBio['Next_of_Kin_lname']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Kin's Relation</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['Next_of_Kin_Rel']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Address</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $prisonerBio['address_street'].' '.$prisonerBio['address_city'].' '.$prisonerBio['address_region'].' '.$prisonerBio['address_postal_code']; ?></p>
            </div>
          </div>
          <hr/>
        </div>
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab" style='padding-left:40%; text-align:center'>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Magistrate Name</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['Magistrate_fname'].' '.$caseInfo['Magistrate_lname']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Court of Committal</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['Court_of_commital']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Category of Offence</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['Category_of_Offence']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Date of Crime</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['Crime_date']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Time of Crime</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['Crime_time']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Case start date</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['case_start_date']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong> end date</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['case_end_date']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Sentence Period</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $caseInfo['sentence_length_Years'].' Years'; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Officer Name</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo  $policeOfficerInfo['P_fname'].' '. $policeOfficerInfo['P_lname']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Officer's Rank</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $policeOfficerInfo['Ranks']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Service ID</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $policeOfficerInfo['Service_ID']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Station Contact</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $policeOfficerInfo['Station_Tel']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Officer Contact</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $policeOfficerInfo['Officer_contact']; ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label><strong>Police Station Name</strong></label>
            </div>
            <div class="col-md-6">
              <p><?php echo $policeOfficerInfo['Police_Station']; ?></p>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>

  </div>
</body>

</html>