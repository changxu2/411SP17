<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Tripub</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<?php
$userId = $_GET['user_id'];
    $userName = $_SESSION['user_name'];
    $userEmail = $_SESSION['user_email'];
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

     if($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
     }
     ?>
<body>
<!--Google Font - Work Sans-->
<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>
<ul class="nav nav-pills" style="background-color: aliceblue">
    <a class="navbar-brand" href="/search.php" style="padding-left: 1%">Triphub</a>
    <li class="nav-item">
        <a class="nav-link active" href="../user/profile.php?profile.php?user_id=$the_user">My Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">Create Trip Plan!</a>
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
            require('functions.php');
            $db = connectToDb();
            echo "Test";
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
              if(isset($_GET['planid']) && !empty($_GET['planid'])){
                $_SESSION['currentPlan'] = $_GET['planid'];
                //echo "Got planid: ", $_SESSION['currentPlan'], "<br>";
                $res = checkPlan($db, $_GET['planid']);
                //echo "plan info" . $res;
              }
              // check if result is fine, if yes do something..
              if(isset($_GET['place']) && !empty($_GET['place']) && isset($_GET['zipcode']) && !empty($_GET['zipcode'])){
                $place = $_GET['place'];
                $zipcode = $_GET['zipcode'];
                $result = getPlaces($db, $zipcode, $place);
                //echo "search result" . $result;
                include showLocs.php

              }

              $_GET = array();
            }
            ?>
            <ul id = "planlist" class="list-group">
              <li class="list-group-item active">Plan: $res[0]['Title']</li>
              <?php
                    foreach ($res as $loc) {
                          echo htmlspecialchars("<li class=\"list-group-item\">".$loc['NAME']." ".$loc['TYPE']."</li>");

                          
                    }
              ?>

            </ul>
          </div>

          <div class="col-6">
            <li class="list-group-item">Add more entries to your plan!</li>
            <div class = "container">
              <form class="form-inline" id = "searchForm" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label class="sr-only" for="inlineFormInput">Place</label>
                <input type="text" class="form-control" id="inlineFormInput" placeholder="Things you want to explore" name = "place">

                <label class="sr-only" for="inlineFormInputGroup">Zipcode</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-addon">@</div>
                  <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="zipcode" name = "zipcode">
                </div>

                <button type="submit" id="searchBtn" class="btn btn-primary">Submit</button>
              </form>
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


<script src="js/index.js"></script>
<script>
</script>
</body>
</html>
