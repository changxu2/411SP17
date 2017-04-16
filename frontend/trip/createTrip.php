<?php
session_start();
 ?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

</head>
<?php
         function connectToDb() {
            $db = new mysqli('localhost', 'tripubproject_adm', '12345shangshandalaohu', 'tripubproject_DB1');
            if($db->connect_errno > 0) {
                die('Unable to connect to database [' . $db->connect_error . ']');
            }
            return $db;
         }
         function createPlan($crr_user, $pre_user, $db) { //insert a new plan and return the id
            if (!$db->query("INSERT INTO Plan VALUES (NULL,NULL,$pre_user, $crr_user)")) {
                echo "INSERT failed: (" . $mysqli->errno . ") " . $mysqli->error;
                return NULL;
            }
            return $mysqli->insert_id;
         }
         function checkPlan($db, $pid) { //insert a new plan and return the id
            if ($result = $db->query("SELECT Plan.Title, locations.NAME, locations.TYPE FROM Plan, contains, locations WHERE Plan.planID = $pid AND contains.planID = $pid AND locations.ID = contains.locationID")) {
//              $currentfield = mysqli_field_tell($result);
//              printf("Column %d:\n", $currentfield);
//              printf("Name:     %s\n", $finfo->name);
//              printf("Table:    %s\n", $finfo->table);
//              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
//              return $row;
              $myArray = array();
              while($row = $result->fetch_array(MYSQL_ASSOC)) {
                            $myArray[] = $row;

                          }
              //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              return $myArray;
            }
            echo "SELECT failed: (" . $mysqli->errno . ") " . $mysqli->error;
            return NULL;
         }
         function getTitle($db, $pid) {
          if ($result = $db->query("SELECT title FROM Plan WHERE Plan.planID = $pid")) {
              $result_fetch = $result->fetch_object();
              $fuck = $result_fetch->title;
              return $fuck;
          }
         }
         function closeDb($db) {
            $db->close();
         }
//         function getTrans($db) {
//            $sql = "SELECT id, firstname, lastname FROM MyGuests";
//            $result = $conn->query($sql);
//         }
//         function initTransQuery($db) {
//            $stmt = $db->prepare("SELECT Name FROM Transportation WHERE TrDID = ?");
//            return $stmt;
//         }
         function getPlaces($db, $zipcode, $place) {
          $zip = ltrim($zipcode, '0');
          //echo "zipcode is $zip";
          $sql = "SELECT longitude, latitude FROM zipcode WHERE ZIP = $zip";
          $result = $db->query($sql);
          if (!$result) {
              printf("Errormessage: %s\n", $db->error);
              return NULL;
          }
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $latitude = $row['latitude'];
          $longitude = $row['longitude'];
          //echo "la is $latitude, lo is $longitude";
          $sql = "SELECT ID, NAME, TYPE FROM locations WHERE (locations.LATITUDE < $latitude + 2) AND (locations.LATITUDE > $latitude - 2 ) AND (locations.LONGITUDE < $longitude + 2) AND (locations.LONGITUDE > $longitude - 2) AND (locations.NAME LIKE '%$place%');";
          $result = $db->query($sql);
          if(!$result){
            //echo "Nothing Found.";
            return NULL;
          }
          $myArray = array();
          while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray[] = $row;
          }
          return $myArray;
         }
         function getTransById($transID, $db) {
          $sql = "SELECT Type FROM Transportation WHERE trDID = $transID";
          $result = $db->query($sql);
          if (!$result) {
              printf("Errormessage: %s\n", $db->error);
          }
          return $result;
         }
        function getLocById($locID, $db) {
          $sql = "SELECT NAME, TYPE, LONGITUDE, LATITUDE FROM locations WHERE ID = $locID;";
          $result = $db->query($sql);
          if (!$result) {
              printf("Errormessage: %s\n", $db->error);
          }
          return $result->fetch_array(MYSQLI_ASSOC);
        }
        function addToPlan($planid, $locid, $db){
          $sql = "INSERT INTO contains(planID, locationID) VALUES ($planid, $locid);";
          $result = $db->query($sql);
          if (!$result) {
              printf("Errormessage: %s\n", $db->error);
          }
          return NULL;
        }
         function deleteFromPlan($planid, $locid, $db) { //insert a new plan and return the id
           if (!$db->query("DELETE FROM contains WHERE planID = ".$planid."and locationID = ".$locid.";")) {
               echo "DELETE failed: (" . $db->errno . ") " . $db->error;
               return;
           }
           return;
          }
        function changeName($planid, $newname, $db){
          $sql = "UPDATE Plan SET title='$newname' WHERE planID=$planid;";
          $result = $db->query($sql);
          if (!$result) {
              printf("Errormessage: %s\n", $db->error);
          }
          return NULL;
        }
//$userId = $_GET['user_id'];
//    $userName = $_SESSION['user_name'];
//    $userEmail = $_SESSION['user_email'];

    $db = new mysqli("localhost", "tripubproject_adm", "12345shangshandalaohu", "tripubproject_DB1");
     if($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
     }

     ?>
<body>
<!--Google Font - Work Sans-->

<ul class="nav nav-pills" style="background-color: aliceblue">
    <a class="navbar-brand" href="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/">Triphub</a>
    <li class="nav-item">
      <a class="navbar-brand" href="#">
        <?php echo $_SESSION['user_name']." Email:[".$_SESSION['user_email']."]";?>
      </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/profile.php">Profile</a>
    </li>
    <li class = "nav-item">
        <a class = "nav-link" href = "../user/login.php?logout">Logout</a >
    </li>
</ul>
<div class="container">

</div>
  <div class="row"  id = "p1">
    <div class="col align-self-start">
      <div class = "container">
      </div>
    </div>
    <div class="col align-self-center">
      <div class="container">
        <div class="jumbotron">
        <div class="row" id = "topblank">
          <div class="col-md-12"></div>
        </div>

        <div class="row">
          <div class="col-6">
            <?php

            $db = connectToDb();

            if(isset($_GET['planid']) && !empty($_GET['planid'])){
              $_SESSION['currentPlan'] = $_GET['planid'];
              //echo "Got planid: ", $_SESSION['currentPlan'], "<br>";
              $res = checkPlan($db, $_GET['planid']);
              $haha = getTitle($db, $_GET['planid']);

            }
            else{
              $_GET['planid'] = $_SESSION['currentPlan'];
              $res = checkPlan($db, $_GET['planid']);
              $haha = getTitle($db, $_GET['planid']);
            }
            if(isset($_POST['newname']) && !empty($_POST['newname'])){
              $haha = $_POST['newname'];
              changeName($_GET['planid'], $_POST['newname'], $db);
            }
            // check if result is fine, if yes do something..
            ?>
            <ul id = "planlist" class="list-group">
              <li class="list-group-item active"><?php echo "Plan: ".$haha ?></li>
              <?php
                  foreach ($res as $loc) {
                    echo "<li class=\"list-group-item\">".$loc['NAME']."   Type[".$loc['TYPE']."]<button type=\"button\" id = \"".$loc['ID']."\" class=\"btn btn-primary btn-sm deleteLoc\">Delete Location</button></li>";
                  }
                  if(isset($_POST['addID']) && !empty($_POST['addID'])){
                    $row = getLocById($_POST['addID'], $db);
                    echo "<li class=\"list-group-item\">".$row['NAME']."   Type[".$row['TYPE']."]<button type=\"button\" id = \"".$POST['addID']."\" class=\"btn btn-primary btn-sm deleteLoc\">Delete Location</button></li>";
                    addToPlan($_GET['planid'], $_POST['addID'], $db);
                  }
                  if (isset($_POST['deleteID'])){
                    if(!empty($_POST['deleteID'])){
                      deletePlan($_GET['planid'], $_POST['deleteID'], $db);
                      // $page = $_SERVER['PHP_SELF'];
                      // $sec = "1";
                      // header("Refresh: $sec; url=$page");
                    }
                  }
              ?>

            </ul>
          </div>

          <div class="col-6">
            <li class="list-group-item">Add more entries to your plan!</li><br>
            <div class = "container">
              <form class="form" id = "searchForm" method="POST" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php">
                <input type="text" class="form-control" id="inlineFormInput" placeholder="rename the plan" name = "newname">
                <button type="submit" id="searchBtn" class="btn btn-primary">Rename</button>
              </form>
            </div>
            <div class = "container">
              <form class="form" id = "searchForm" method="POST" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php">
                <label class="sr-only" for="inlineFormInput">Place</label>
                <input type="text" class="form-control" id="inlineFormInput" placeholder="Things you want to explore" name = "place">

                <label class="sr-only" for="inlineFormInputGroup">Zipcode</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">@</div>
                  <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="zipcode" name = "zipcode">
                </div>

                <button type="submit" id="searchBtn" class="btn btn-primary">Search</button>
              </form>
            </div>
            <div class = "container">
              <?php
              if(isset($_POST['place']) && !empty($_POST['place']) && isset($_POST['zipcode']) && !empty($_POST['zipcode'])){
                echo "<ul class=\"list-group\">";
                $place = $_POST['place'];
                $zipcode = $_POST['zipcode'];
                $result = getPlaces($db, $zipcode, $place);
                foreach ($result as $loc) {
                  echo "<li class=\"list-group-item active\">". $loc["NAME"]. "  Type: [".$loc["TYPE"]."] <button type=\"button\" id = \"".$loc["ID"]."\" class=\"btn btn-secondary btn-sm addLoc\">Add Entry</button></li>";
                }
                echo "</ul>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col align-self-end">
      <div id = "planlist">
      </div>
    </div>
  </div>
</div>


<script src="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/js/index.js"></script>

</body>
</html>
