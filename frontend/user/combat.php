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
 function updateRating($planID1,$planID2, $db){
    
    echo "<ul>";
    $sql_me = "SELECT createdByUserID FROM Plan WHERE planID = $planID1;";
    $sql_beat = "SELECT createdByUserID FROM Plan WHERE planID = $planID2;";

    $result_me = $db->query($sql_me);
    $user_me = $result_me->fetch_object()->createdByUserID;


    if($user_me == FALSE){
      echo "<script> alert(\"SELECT SELF ID FAILED\")</script>";
    }

    $result_beat = $db->query($sql_beat);
    $user_beat = $result_beat->fetch_object()->createdByUserID;


    if($user_beat == FALSE){
      echo "<script> alert(\"SELECT OPPONENT ID FAILED\")</script>";
    }
    
    $sql_rating1 = "SELECT user_rating FROM users WHERE user_id = '$user_me';";
    $sql_rating2 = "SELECT user_rating FROM users WHERE user_id = '$user_beat';";

    $result_rating1 = $db->query($sql_rating1);
    $user_rating1 = $result_rating1->fetch_object()->user_rating;

    if($user_rating1 == FALSE){
      echo "<script> alert(\"SELECT SELF RATING FAILED\")</script>";
    }
    
    $result_rating2 = $db->query($sql_rating2);
    $user_rating2 = $result_rating2->fetch_object()->user_rating;

    if($user_rating2 == FALSE){
      echo "<script> alert(\"SELECT OPPONENT RATING FAILED\")</script>";
    }
    
    echo "<li>Your current rating is ".$user_rating1." ";
    echo " VS ";
    echo "Your opponent's current rating is ".$user_rating2.". </li>";
      
    $sql1 = "SELECT COUNT(locationID) as haha FROM contains WHERE planID = $planID1 GROUP BY planID;";
    $sql2 = "SELECT COUNT(locationID) as hehe FROM contains WHERE planID = $planID2 GROUP BY planID;";

    $result_1 = $db->query($sql1);
    $row_1 = $result_1->fetch_assoc();
    $count1 = $row_1['haha'];
    // echo "count1: ".$count_1;
    
    if($count1 == FALSE){
      $count1 = 0;
    }

    $result_2 = $db->query($sql2);
    $row_2 = $result_2->fetch_assoc();
    $count2 = $row_2['hehe'];
    // echo "count2: ".$count_2;

    if($count2 == FALSE){
      $count2 = 0;
    }
    
    echo "<li>The number of locations in your plan is ".$count1." ";
    echo " VS ";
    echo "The number of locations in your opponent's plan is ".$count2.". </li>";
    
    $actualScoreLocation_Me =  ($count1 > $count2) ? 1 : (($count1 == $count2) ? 0.5 : 0);
    $actualScoreLocation_Beat = 1 - (($count1 > $count2) ? 1 : (($count1 == $count2) ? 0.5 : 0));
    
    
    $sql_me_likings = "SELECT SUM(likes) as me FROM likings WHERE planID = $planID1 GROUP BY planID;";
    $sql_beat_likings = "SELECT SUM(likes) as beat FROM likings WHERE planID = $planID2 GROUP BY planID;";
    
    $res_me_likings = $db->query($sql_me_likings);
    $user_me_likings = $res_me_likings->fetch_object()->me;
    $res_beat_likings = $db->query($sql_beat_likings);
    $user_beat_likings = $res_beat_likings->fetch_object()->beat;
    if ($user_me_likings == NULL){
        $user_me_likings = 0;
    }
    if ($user_beat_likings == NULL){
        $user_beat_likings = 0;
    }
    $actualScoreLiking_Me = ($user_me_likings > $user_beat_likings) ? 1 : (($user_me_likings < $user_beat_likings) ? 0 : 0.5);
    $actualScoreLiking_Beat = 1 - $actualScoreLiking_Me;
    
    echo "<li>The number of likes your plan get is ".$user_me_likings." ";
    echo " VS ";
    echo "The number of likes your opponent's plan get is ".$user_beat_likings.". </li>";
    
    $totalScore_Me = 0.5 * $actualScoreLiking_Me + 0.5 * $actualScoreLocation_Me;
    $totalScore_Beat = 0.5 * $actualScoreLiking_Beat + 0.5 * $actualScoreLocation_Beat;
    
    // The comparision between the number of messages in the chatroom in the table is to be added
    $actualScore1 = ($totalScore_Me > $totalScore_Beat) ? 1 : (($totalScore_Me == $totalScore_Beat) ? 0.5 : 0);
    $actualScore2 = 1 - ($totalScore_Me > $totalScore_Beat) ? 1 : (($totalScore_Me == $totalScore_Beat) ? 0.5 : 0);

    $ExpectationMe = 1 / (1 + (pow(10, ($user_rating2 - $user_rating1) / 400)));
    $ExpectationBeat = 1 / (1 + (pow(10, ($user_rating1 - $user_rating2) / 400)));

    if ($actualScore1 != $ExpectationMe) {
      $newRatingMe = $user_rating1 + 16 * ($actualScore1 - $ExpectationMe);
      $sql3 = "UPDATE users SET user_rating = '$newRatingMe' WHERE user_id = '$user_me';";
      $ret = $db->query($sql3);
      if($ret == FALSE){
        echo "<script> alert(\"UPDATE SELF RATING FAILED\")</script>";
      }

    }

    if ($actualScore2 != $ExpectationBeat) {
      $newRatingBeat = $user_rating2 + 16 * ($actualScore2 - $ExpectationBeat);
      $sql4 = "UPDATE users SET user_rating = '$newRatingBeat' WHERE user_id = '$user_beat';";
      $ret = $db->query($sql4);
      if($ret == FALSE){
        echo "<script> alert(\"UPDATE OPPONENT RATING FAILED\")</script>";
      }
    }

    echo "</ul>";
    $actualScore1 == 1? 1: (($actualScore1 == 0.5)? 0.5 : 0);

    return $actualScore1;
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
        <input type="hidden" name="myId" />
          <div id="notification-event">
              
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
            echo ("<option value = \"".$to_find."\" >".$result_row->title."</option>");
              }
            
            ?>
          </select>
          
          </div>
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
            echo ("<option value = \"".$to_find2."\">".$result_row->title."</option>");
            
          }
          ?>
          </select>
        <button type="submit" class="btn btn-primary startCombat">Start Combat!</button>
      </form>
      <?php
        if (isset($_POST['myPlanID'])){
            if(!empty($_POST['myPlanID'])){
                // echo "myPlanID: ";
                // echo($_POST['myPlanID']);
                // echo "yourPlanID: ";
                // echo($_POST['otherPlanID']);
                $myid = $_POST['myPlanID'];
            
            $sql = "SELECT title FROM Plan WHERE planID = $myid;";
            $result_query = $db->query($sql) or die($db->error);
            if (!$result_query) {
              printf("Errormessage: %s\n", $db->error);
            }
            $result_row = $result_query->fetch_object();
            // echo("<span>$result_row->title V.S </span>");
            $otherid = $_POST['otherPlanID'];
            $sql = "SELECT title FROM Plan WHERE planID = $otherid;";
            $result_query = $db->query($sql) or die($db->error);
            if (!$result_query) {
              printf("Errormessage: %s\n", $db->error);
            }
            $result_row = $result_query->fetch_object();
            // echo("<span>$result_row->title</span>");
            
            // echo "Im here and otherid is ".$otherid."!!!!";
              $result = updateRating($myid,$otherid,$db);
            //   echo("after");
            //   echo($result);
              if ($result == 1) {
              	echo("<p> You Win !</p>");
              } else if ($result == 0) {
              	echo("<p> Oooops.....You Lost !</p>");
              } else {
              	echo("<p> It is a draw !</p>");
              }
          }
        }
      ?>
    </div>
  </div>
  <script src="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/js/profile.js"></script>
</body>
</html>
