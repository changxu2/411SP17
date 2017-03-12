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
    $userEmail = $_SESSION['user_email']:
    $db = new mysqli('localhost', 'triphubAdmin', 'xxxxx', 'xxxxx');

     if($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
     }
    $sql = "SELECT * FROM Plan WHERE createdByUserID = $userId";
    $result = $db->query($sql) or die($db->error);
    if (!$result) {
        printf("Errormessage: %s\n", $db->error);
    }
    


?>
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
    <div>

Hey, my dear <?php echo $_SESSION['user_name']; ?>. You are logged in!!!!!!!
You user id is: <?echo $_GET['user_id']?>



  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</body>
</html>