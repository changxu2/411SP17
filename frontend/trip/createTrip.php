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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>




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
            if ($result = $db->query("SELECT Plan.Title, locations.NAME, locations.TYPE, locations.ID FROM Plan, contains, locations WHERE Plan.planID = $pid AND contains.planID = $pid AND locations.ID = contains.locationID")) {
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
            $sql = "DELETE FROM contains WHERE planID =".$planid." AND locationID = ".$locid.";";
            $result = $db->query($sql);
            if (!$result) {
                printf("Errormessage: %s\n", $db->error);
            }
            return NULL;
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
    <?php
    $page = $_SERVER['PHP_SELF'];
    ?>
    <a class="navbar-brand" href="<?php echo $page?>">Triphub</a>
    <li class="nav-item">
      <a class="navbar-brand" href="<?php echo $page?>">
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
  <div class="col align-self-center" id="real-size">
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
                  $the_plan_id = $_GET['planid'];
                  foreach ($res as $loc) {
                    echo "<li class=\"list-group-item\">".$loc['NAME']."   Type[".$loc['TYPE']."]<button type=\"button\" id = \"".$loc['ID']."\" class=\"btn btn-primary btn-sm deleteLoc\">Delete Location</button></li>";
                  }

                  if(isset($_POST['addID']) && !empty($_POST['addID'])){
                    $row = getLocById($_POST['addID'], $db);
                    echo "<li class=\"list-group-item\">".$row['NAME']."   Type[".$row['TYPE']."]<button type=\"button\" id = \"".$POST['addID']."\" class=\"btn btn-primary btn-sm deleteLoc\">Delete Location</button></li>";
                    addToPlan($_GET['planid'], $_POST['addID'], $db);
                  }


                  if (isset($_POST['deleteID']) && !empty($_POST['deleteID'])){
                    // if(!empty($_POST['deleteID'])){

                      deleteFromPlan($_GET['planid'], $_POST['deleteID'], $db);
                      $page = $_SERVER['PHP_SELF'];
                      $sec = "1";
                      header("Refresh: $sec; url=$page");

                  }
              ?>

            </ul>
          </div>

          <div class="col-6">
            <li class="list-group-item">Add more entries to your plan!</li><br>
            <div class = "container">
              <form class="form" id = "searchForm" method="POST" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php?<?php echo "planid=$the_plan_id"?>">
                <input type="text" class="form-control" id="inlineFormInput" placeholder="rename the plan" name = "newname">
                <button type="submit" id="searchBtn" class="btn btn-primary">Rename</button>
              </form>
            </div>
            <div class = "container">
              <form class="form" id = "searchForm" method="POST" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php?<?php echo "planid=$the_plan_id"?>">
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

<div class="container col-5" id="chat-container" style="position: fixed;bottom:0px;right:10px;z-index:999">
  <div class="jumbotron col-11" style="padding:10px; background-color:#bbbbbb;float:right">

    <div class = "row" style="margin-bottom:10px;margin-left:5px;">
        <div class="col-9" id="plain-words">
            <p>Chat with potential travel mates!</p>
        </div>

        <div class="col-1">
            <b id="minimize" onclick="close_chat()">close</b>
        </div>
    </div>

    <div class="container" id="to-close" style="display:block">
        <div class="container" style="height:300px;width:95%;background-color:#ffffff;overflow: scroll">
          <ul class="list-group" id="all-messages" >
          </ul>
        </div>
        <form class="form row" id = "chat-form" style="margin-top:30px;margin-left:15px;margin-bottom:10px;" id = "chat_message" method="POST" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php?<?php echo "planid=$the_plan_id"?>">
          <input type="text" class="form-control col-10" id="messege_box" placeholder="Instant messeges?" name = "place">

          <button type="submit" id="searchBtn" class="btn btn-primary">Send</button>
        </form>
        <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script>
          $(function () {
            var username =
'<?php echo $_SESSION['user_name'];?>'
            var socket = io('http://tripubproject.web.engr.illinois.edu:3000/')
            $('#chat-form').submit(function(){
              socket.emit('chat message', {'msg': username+': '+$('#messege_box').val(), 'room': 123})
              $('#messege_box').val('')
              return false
            })
            socket.on('connect', function() {
               socket.emit('room', 123);
            });
            socket.on('chat message', function(msg){
              $('#all-messages').append($('<li>').attr('class', 'list-group-item').text(msg))
              // nmsg.text(msg)
              // nmsg.className += "list-group-item"
            })
          })
        </script>
    </div>
  </div>
</div>

<!--<div class="container" id="chat-container" style="padding-left: 500px;">-->
<!--  <div class="jumbotron col-12" style="padding:20px;">-->
<!--    <div id="plain-words" style="margin-bottom:20px">-->
<!--        <b>Chat with potential travel mates!</b>-->
<!--    </div>-->

<!--    <div class="container" id="all-messages" style="height:300px;width:95%;background-color:#ffffff">-->
<!--        Start here:-->
<!--    </div>-->
<!--    <form class="form row" style="margin-top:30px;margin-left:15px" id = "chat_message" method="POST" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/createTrip.php?<?php echo "planid=$the_plan_id"?>">-->
<!--      <input type="text" style="width:500px" class="form-control col-10" id="messege_box" placeholder="Instant messeges?" name = "place">-->

<!--      <button type="submit" id="searchBtn" class="btn btn-primary">Send</button>-->
<!--    </form>-->
<!--  </div>-->
<!--</div>-->


 <!--    <div class="row-fluid" style="background-color:#0000ff">-->
 <!--     <div class="span6">-->
 <!--          <p>Text left</p>-->
 <!--     </div>-->
 <!--     <div class="span6 pull-right" style="text-align:right">-->
 <!--          <p>text right</p>-->
 <!--     </div>-->
 <!-- </div>-->
 <!--</div>      -->




<script src="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/trip/js/index.js"></script>

</body>
</html>
