<?php

session_start();
require_once("config/db.php");

function createPlan($crr_user, $pre_user, $db) { //insert a new plan and return the id
  if (!$db->query("INSERT INTO Plan VALUES (NULL, NULL, $pre_user, $crr_user)")) {
      echo "INSERT failed: (" . $db->errno . ") " . $db->error;
      return NULL;
  }
  return $db->insert_id;
 }

  $userId = $_GET['user_id'];
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
  $len = $count;


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link rel="stylesheet" href="css/signInUp.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <script src="js/signUp.js"></script>
</head>

<style>
table {
  width: 100%;
}

table, th, td {
  border: 1px solid pink;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  text-align: center;
}

.imgcontainer {
  text_align: center;
  margin: 24px 0 12px 0;
}

img.profile {
  width: 50%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

table#t01 tr:nth-child(even) {
    background-color: #eee;
}
table#t01 tr:nth-child(odd) {
   background-color:#fff;
}

button{
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button: hover {
  opacity: 0.7;
}

</style>

<body>

  <ul class="nav nav-pills" style="background-color: aliceblue">
      <a class="navbar-brand" href="#" style="padding-left: 1%">Triphub</a>
      <li class="nav-item">
          <a class="nav-link active" href="#">My Profile</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="#">Create Trip Plan!</a>
      </li>
      <li class = "nav-item">
          <a class = "nav-link" href = "login.php?logout" style ="padding-left: 670px">Logout</a >
      </li>
  </ul>



<h1> Profile Form </h1>

<div class = "container">
  <table>
    <tr>
      <th> userName </th>
      <td> <?php echo $userName;?> </td>
    </tr>
    <tr>
      <th> userEmail </th>
      <td> <?php echo $userEmail;?> </td>
    </tr>
  </table>
</div>
<div class="row">
  <div class = "container">
    <div class="col-3">
    </div>
    <div class="col-6">
      <ul class="list-group">
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
          echo ("<li class=\"list-group-item active\">".$result_row->title."<button type=\"button\" class=\"btn btn-primary btn-sm\">Edit Plan</button>
    <button type=\"button\" class=\"btn btn-secondary btn-sm\">Delete Plan</button></li>");
        }
        if (isset($_POST['addTrip'])){
          if(!empty($_POST['addTrip'])){
            $newPlanId = createPlan($userId, $userId, $db);
            echo ("<li class=\"list-group-item active\">New Plan<button type=\"button\" class=\"btn btn-primary btn-sm\">Edit Plan</button>
      <button type=\"button\" class=\"btn btn-secondary btn-sm\">Delete Plan</button></li>");
          }
        }
        ?>
      </ul>
    </div>
    <div class="col-3">
    </div>
  </div>
</div>

<div class = "container" style = "background-color:#f1f1f1">
  <form  method="post" action="./profile.php">
  <button type = "submit" name = "addTrip" id="add_trip"> Add Trip Plans </button>
  <button type = "button"> Add Friend </button>
  </form>
</div>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

</body>
</html>
