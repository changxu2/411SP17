<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
require_once("config/db.php");

function createPlan($crr_user, $pre_user, $db) { //insert a new plan and return the id

  if (!$db->query("INSERT INTO Plan (title, ownedByUserID, createdByUserID) VALUES ('New Plan', ".$pre_user.", ".$crr_user.");")) {
      echo "INSERT failed: (" . $db->errno . ") " . $db->error;
      return NULL;
  }
  return $db->insert_id;
 }
 function deletePlan($planid, $db) { //insert a new plan and return the id
   if (!$db->query("DELETE FROM Plan WHERE planID = ".$planid.";")) {
       echo "INSERT failed: (" . $db->errno . ") " . $db->error;
       return;
   }
   return;
  }
  function addFriend($myid, $friendName, $db) { //insert a new plan and return the id
    if (!$db->query("INSERT INTO Friend(userID1, userID2) VALUES ($myid, (SELECT MIN(user_id) FROM users WHERE user_name = '$friendName'));")) {  //advanced query 1
        echo "INSERT failed: (" . $db->errno . ") " . $db->error;
        return false;
    }
    return true;
  }
  function getFriend($uid, $db){
    $sql = "SELECT user_name FROM users WHERE user_id IN (SELECT userID2 FROM Friend WHERE userID1=$uid);";
    $result = $db->query($sql);
    $myArray = array();
    while($row = $result->fetch_array(MYSQL_ASSOC)) {
      $myArray[] = $row;
    }
    return $myArray;
  }

  function updateRating($planID1,$planID2){

    $sql_me = "SELECT createdByUserID FROM Plan WHERE planID = '$planID1';";
    $sql_beat = "SELECT createdByUserId FROM Plan WHERE planID = '$planID2';";
    $user_me = $db->query($sql_me);

    if($user_me == FALSE){
      echo "<script> alert(\"SELECT SELF ID FAILED\")</script>";
    }

    $user_beat = $db->query($sql_beat);

    if($user_beat == FALSE){
      echo "<script> alert(\"SELECT OPPONENT ID FAILED\")</script>";
    }

    $sql_rating1 = "SELECT user_rating FROM users WHERE user_id = '$user_me';";
    $sql_rating2 = "SELECT user_rating FROM users WHERE user_id = '$user_beat';";

    $user_rating1 = $db->query($sql_rating1);

    if($user_rating1 == FALSE){
      echo "<script> alert(\"SELECT SELF RATING FAILED\")</script>";
    }

    $user_rating2 = $db->query($sql_rating2);

    if($user_rating2 == FALSE){
      echo "<script> alert(\"SELECT OPPONENT RATING FAILED\")</script>";
    }

    $sql1 = "SELECT COUNT(locationID) FROM contains WHERE planID = '$planID1';";
    $sql2 = "SELECT COUNT(locationID) FROM contains WHERE planID = '$planID2';"; 

    $count1 = $db->query($sql1);

    if($count1 == FALSE){
      echo "<script> alert(\"SELECT SELF LOCATION NUMBER FAILED\")</script>";
    }

    $count2 = $db->query($sql2);

    if($count1 == FALSE){
      echo "<script> alert(\"SELECT SELF LOCATION NUMBER FAILED\")</script>";
    }

    // The comparision between the number of messages in the chatroom in the table is to be added
    $actualScore1 = ($count1 > $count2) ? 1 : (($count1 == $count2) ? 0.5 : 0);
    $actualScore2 = 1 - (($count1 > $count2) ? 1 : (($count1 == $count2) ? 0.5 : 0));

    $ExpectationMe = 1 / (1 + (pow(10, ($user_rating2 - $user_rating1) / 400)));
    $ExpectationBeat = 1 / (1 + (pow(10, ($user_rating1 - $user_rating2) / 400)));

    if ($actualScore1 != $ExpectationMe) {
      $newRatingMe = $sql_rating1 + 16 * ($actualScore1 - $ExpectationMe);
      $sql3 = "UPDATE users SET user_rating = '$newRatingMe' WHERE user_id = '$user_me';";
      $ret = $db->query($sql3);
      if($ret == FALSE){
        echo "<script> alert(\"UPDATE SELF RATING FAILED\")</script>";
      }

    }

    if ($actualScore2 != $ExpectationBeat) {
      $newRatingBeat = $sql_rating2 + 16 * ($actualScore2 - $ExpectationBeat);
      $sql4 = "UPDATE users SET user_rating = '$newRatingBeat' WHERE user_id = '$user_beat';";
      $ret = $db->query($sql4);
      if($ret == FALSE){
        echo "<script> alert(\"UPDATE OPPONENT RATING FAILED\")</script>";
      }
    }

    return $actualScore1 == 1? 1: (($actualScore1 == 0.5)? 0.5 : 0);
  }

  function selectTopUsers(){
    $sql = "SELECT user_name FROM users WHERE user_rating IN (SELECT TOP 3 user_rating FROM users ORDER BY 
    user_rating DESC);";
    $result = $db->query($sql);
    $topUserArray = array();
    while ($row = $result->fetch_array(MYSQL_ASSOC)) {
      $topUserArray[] = $row;
    }
    return $topUserArray;
  }

  $userId = $_SESSION['user_id'];
  $userName = $_SESSION['user_name'];
  $userEmail = $_SESSION['user_email'];
  $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

   if($db->connect_errno > 0) {
      die('Unable to connect to database [' . $db->connect_error . ']');
   }
  $sql = "SELECT * FROM Plan WHERE createdByUserID = $userId";
  $result = $db->query($sql) or die($db->error);
  if (!$result) {
      printf("Errormessage: %s\n", $db->error);
  }

  $ids = array();
  $count = 0;

  if ($result -> num_rows > 0) {
    while ($row = $result -> fetch_assoc()) {
      $ids[$count] = $row["planID"];
      $count ++;
    }
  }

  $sql2 = "SELECT Plan.planID FROM Plan INNER JOIN Friend ON (Plan.ownedByUserID = Friend.userID2 AND Friend.userID1 = ".$userId.");"; //Advanced Query 2
  $result2 = $db->query($sql2) or die($db->error);
  if (!$result2) {
      printf("Errormessage: %s\n", $db->error);
  }

  $ids2 = array();
  $count2 = 0;

  if ($result2 -> num_rows > 0) {
    while ($row2 = $result2 -> fetch_assoc()) {
      $ids2[$count2] = $row2["planID"];
      $count2 ++;
    }
  }

//   function flush_webPage(){
//   $.ajax({
//     url: 'profile.php',
//     success: function(data){
//     $('.result').html(data);
//   }
// });
// }

// setInterval("flush_webPage()", 30000);
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="css/profile.css">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>

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
      <li class="nav-item">
          <a class="nav-link" href="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/combat.php">Combat</a>
      </li>
      <li class = "nav-item">
          <a class = "nav-link" href = "login.php?logout">Logout</a >
      </li>
  </ul>
  <div class="container" id = "mainW">
    <div class="row">
      <div class="col-6">
      	<div class="jumbotron">
        <ul class="list-group">
          <a href="#" class="list-group-item active">
            Plans you owned
          </a>
          <?php
          for ($i = 0; $i < $count; $i++) {
            //find the name of the plan with the ids array
            $to_find = $ids[$i];

            $sql = "SELECT title FROM Plan WHERE planID = $to_find;";
            $result_query = $db->query($sql) or die($db->error);
            if (!$result_query) {
              printf("Errormessage: %s\n", $db->error);
            }
            $result_row = $result_query->fetch_object();
            echo ("<li class=\"list-group-item\">".$result_row->title."<button type=\"button\" id = \"".$to_find."\" class=\"btn btn-secondary btn-sm editPlan\">Edit Plan</button>
      <button type=\"button\" id = \"".$to_find."d\" class=\"btn btn-primary btn-sm deletePlan\">Delete Plan</button></li>");
          }
          if (isset($_POST['addTrip'])){
            if(!empty($_POST['addTrip'])){
              $newPlanId = createPlan($userId, $userId, $db);
              echo ("<li class=\"list-group-item\">New Plan<button type=\"button\" id = \"".$newPlanId."\" class=\"btn btn-secondary btn-sm editPlan\">Edit Plan</button>
        <button type=\"button\" id = \"".$newPlanId."d\" class=\"btn btn-primary btn-sm deletePlan\">Delete Plan</button></li>");
              $page = $_SERVER['PHP_SELF'];
              $sec = "1";
              header("Refresh: $sec; url=$page");
            }
          }
          if (isset($_POST['deletePlan'])){
            if(!empty($_POST['deletePlan'])){
              deletePlan($_POST['deletePlan'], $db);
              $page = $_SERVER['PHP_SELF'];
              $sec = "1";
              header("Refresh: $sec; url=$page");
            }
          }
          if (isset($_POST['friend'])){
            if(!empty($_POST['friend'])){
              addFriend($userId, $_POST['friend'], $db);
              $page = $_SERVER['PHP_SELF'];
              $sec = "1";
              header("Refresh: $sec; url=$page");
            }
          }
          ?>
        </ul>
        <ul class="list-group" id = "friend_plan_list">
          <a href="#" class="list-group-item active">
            Plans From Your Followed Users
          </a>
          <?php
          for ($i = 0; $i < $count2; $i++) {
            //find the name of the plan with the ids array
            $to_find2 = $ids2[$i];

            $sql = "SELECT title FROM Plan WHERE planID = $to_find2;";
            $result_query = $db->query($sql) or die($db->error);
            if (!$result_query) {
              printf("Errormessage: %s\n", $db->error);
            }
            $result_row = $result_query->fetch_object();
            echo ("<li class=\"list-group-item\">".$result_row->title."<button type=\"button\" id = \"".$to_find2."\" class=\"btn btn-secondary btn-sm editPlan\">Edit Plan</button>
      </li>");
          }
          ?>
        </ul>
        </div>
      </div>
      <div class="col-6">
        <form  id="followUser" method="post" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/profile.php">
          <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" name="friend" placeholder="Follow by Username">
          <button type = "button" class="btn btn-primary" id="add_trip"> Add Trip Plans </button>
          <button type = "submit" class="btn btn-primary"> Follow This User </button>
        </form>

        <div class = "container">
          <ul class="list-group" id = "friend_plan_list">
            <li class="list-group-item active">You are following</li>
            <?php
              $row = getFriend($userId, $db);
              foreach ($row as $ele){
                echo "<li class=\"list-group-item\">".$ele['user_name']."</li>";
              }
            ?>
          </ul>
        </div>

      </div>
<!--         <div class = "container">
          <ul class = "list-group" id = "star_planner">
            <li class = "list-group-item active">Star Planner</li>
            <?php
              // $row = selectTopUsers();
              // foreach ($row as $ele) {
              //   echo "<li class =\"list-group-item\">".$ele['user_name']."</li>";
              }
            ?>
          </ul>
        </div> -->
    </div>

  </div>
  <script src="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/js/profile.js"></script>
</body>
</html>
