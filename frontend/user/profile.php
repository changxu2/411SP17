<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tripub</title>
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<?php
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

   <!--  <?
    while ($row = $result->fetch_assoc()) {
        printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);
    }
    ?> -->
   <!--  <div> -->

<!-- Hey, my dear <?php echo $_SESSION['user_name']; ?>. You are logged in!!!!!!!
You user id is: <?echo $_GET['user_id']?>
    </div> -->

<h1> Profile Form </h1>

<div class = "imgcontainer">
  <img src = "Profile.png"  alt = "Profile" class = "profile">
</div>

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
</body>

<head>
<meta charset = "utf-8">
<title><?php echo $userName;?>'s Trip Plans</title>
</head>

<table id = "t01" style = "width: 100%">
  <?php for ($i = 0; $i < $count; $i++) { 
    //find the name of the plan with the ids array
    $sql = "SELECT title FROM Plan WHERE planID = ids[$i]"; 
    $title = $db->query($sql) or die($db->error);
    if (!$titles) {
      printf("Errormessage: %s\n", $db->error);
    } ?>
    <tr>
      <td> $title </td>
    </tr>
  <?php } ?>
</table>

<div class = "container" style = "background-color:#f1f1f1">
  <button type = "button" onclick = "{}"> Add Trip Plans </button>
  <?php 
  function createPlan($crr_user, $pre_user, $db) { //insert a new plan and return the id
    if (!$db->query("INSERT INTO Plan VALUES ($pre_user, $crr_user)")) {
        echo "INSERT failed: (" . $mysqli->errno . ") " . $mysqli->error;
        return NULL;
    }
    return $mysqli->insert_id;
   }
   $newPlanId = createPlan($userId, NULL, $db);
   //$the_user = $_SESSION['user_id'];
    header("Location:../trip/createTrip.php?planid=$newPlanId");
   ?>
  <button type = "button"> Add Friend </button>
</div>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</body>
</html>