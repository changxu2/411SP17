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

  // planID1 is the planID of the user itself
  function updateRating($planID1,$planID2){

    $sql_me = "SELECT createdByUserID FROM Plan WHERE planID = '$planID1';";
    $sql_beat = "SELECT createdByUserId FROM Plan WHERE planID = '$planID2';";
    $user_me = $db->query($sql_me);
    $user_beat = $db->query($sql_beat);
    $sql_rating1 = "SELECT user_rating FROM users WHERE user_id = '$user_me';";
    $sql_rating2 = "SELECT user_rating FROM users WHERE user_id = '$user_beat';";
    $user_rating1 = $db->query($sql_rating1);
    $user_rating2 = $db->query($sql_rating2);

    $sql1 = "SELECT COUNT(locationID) FROM contains WHERE planID = '$planID1';";
    $sql2 = "SELECT COUNT(locationID) FROM contains WHERE planID = '$planID2';"; 
    $count1 = $db->query($sql1);
    $count2 = $db->query($sql2);

    // The comparision between the number of messages in the chatroom in the table is to be added
    $actualScore1 = ($count1 > $count2) ? 1 : (($count1 == $count2) ? 0.5 : 0);
    $actualScore2 = 1 - (($count1 > $count2) ? 1 : (($count1 == $count2) ? 0.5 : 0));

    $ExpectationMe = 1 / (1 + (pow(10, ($user_rating2 - $user_rating1) / 400)));
    $ExpectationBeat = 1 / (1 + (pow(10, ($user_rating1 - $user_rating2) / 400)));

    if ($actualScore1 != $ExpectationMe) {
      $newRatingMe = $sql_rating1 + 16 * ($actualScore1 - $ExpectationMe);
      $sql3 = "UPDATE users SET user_rating = '$newRatingMe' WHERE user_id = '$user_me';";
      $db->query($sql3);
    }

    if ($actualScore2 != $ExpectationBeat) {
      $newRatingBeat = $sql_rating2 + 16 * ($actualScore2 - $ExpectationBeat);
      $sql4 = "UPDATE users SET user_rating = '$newRatingBeat' WHERE user_id = '$user_beat';";
      $db->query($sql4);
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
  //

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
      <a class="navbar-brand" href="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/">Triphub</a>
      <li class="nav-item">
        <a class="navbar-brand" href="#">
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
      <form id="combatForm" method="post" action="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/combat.php">
        
          
          <select class="form-control" id="SelectMyPlan" name="myPlanID">
          <option>Select My Pokemonplan!</option>
            <?php
              for ($i = 0; $i < $count; $i++) {
                $to_find = $ids[$i];

            $sql = "SELECT title FROM Plan WHERE planID = $to_find;";
            $result_query = $db->query($sql) or die($db->error);
            if (!$result_query) {
              printf("Errormessage: %s\n", $db->error);
            }
            $result_row = $result_query->fetch_object();
            echo ("<option id = \"".$to_find."\" >".$result_row->title."</option>");
              }
            ?>
          </select>
          <select class="form-control" id="SelectOtherPlan" name="otherPlanID">
          <option>Select Pokemonplan From Your Friends!</option>
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
            echo ("<option id = \"".$to_find2."\">".$result_row->title."</option>");
          }
          ?>
          </select>
        <button type="submit" class="btn btn-primary startCombat">Start Combat!</button>
      </form>
      <?php
        if (isset($_POST['myPlanID'])){
            if(!empty($_POST['myPlanID'])){
              $result = updateRating($_POST['myPlanID'],$_POST['otherPlanID']);
              if ($result == 1) {
              	echo("<p> You Win !</p>");
              } else if ($result == 0) {
              	echo("<p> It is a draw !</p>");
              } else {
              	echo("<p> You Lost !</p>");
              }
          }
        }
      }
      ?>
    </div>
  </div>
  <script src="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/js/profile.js"></script>
</body>
</html>
