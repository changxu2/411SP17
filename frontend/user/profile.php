<?
session_start();
 if (!isset($_SESSION['user_login_status'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="css/signInUp.css">

    <link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="js/signUp.js"></script>
  </head>

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