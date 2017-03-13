<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
if(isset($_GET['user_id'])){
  if(!empty($_GET['user_id'])){
    header("Location: profile.php?user_id=".$_GET['user_id']);
  }
}
 ?>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/index.css">

    <link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>
    <ul class="nav nav-pills" style="background-color: aliceblue">
        <a class="navbar-brand" href="#" style="padding-left: 1%">Triphub</a>
        <li class="nav-item">
            <a class="nav-link active" href="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="http://tripubproject.web.engr.illinois.edu/411SP17/frontend/user/signUp.php">Sign Up!</a>
        </li>
    </ul>

  <div class="Tcontainer">
    <div class="profile">
      <button class="profile__avatar" id="toggleProfile">
        <img src="./img/Profile.png" alt="Avatar" />
      </button>
      <form class="profile--open profile__form" method="post" action="user/login.php" name="login">

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="usernameInput" name="user_name" placeholder="Username" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="user_password" placeholder="Password" required>
          </div>

            <div class="profile__footer">
              <div>
                <div class="button_left">
                  <div class="center"><button type="submit" name="login" value="Log_in" class="center btn btn-primary fit">LOG IN</button></div>
                  <paper-ripple fit></paper-ripple>
                </div>

                <div class="button raised blue button_right">
                  <a href="user/signUp.php" id="signUp"><div class="center" fit>SIGN UP</div></a>
                  <paper-ripple fit></paper-ripple>
                </div>
              </div>
            </div>

        </form>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <script src="js/index.js"></script>
</body>
</html>
