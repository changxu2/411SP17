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
  <body onload="show_function()">
    <ul class="nav nav-pills" style="background-color: aliceblue">
        <a class="navbar-brand" href="#" style="padding-left: 1%">Triphub</a>
        <li class="nav-item">
            <a class="nav-link active" href="#">My Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Create Trip Plan!</a>
        </li>
    </ul>
    <div>
    <p>
    <?
        if (isset($registration)) {
          if ($registration->errors) {
              foreach ($registration->errors as $error) {
                  echo $error;
              }
          
        }
        else if ($registration->messages) {
            foreach ($registration->messages as $message) {
                echo $message;
            }
        }
        }?>
    </p>
    </div>
  <div class="Tcontainer_up">
    <div class="profile">
      <button class="profile__avatar" id="toggleProfile">
        <img src="../img/Profile.png" alt="Avatar" />
      </button>

      <form class="profile--open profile__form" method="post" action="./register.php" name="registerform">

<!--          <div class="profile-open profile__fields">-->
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="user_email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
<!--            <div class="field">
              <input type="text" id="fieldUser" class="input" required pattern=.*\S.* />
              <label for="fieldUser" class="label">Username</label>
            </div>
-->
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="usernameInput" pattern="[a-zA-Z0-9]{2,64}" placeholder="Username" name="user_name" required>
            <small id="emailHelp" class="form-text text-muted">only letters and numbers, 2 to 64 characters</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="InputPassword1" pattern="[a-zA-Z0-9]{6,64}" name="user_password_new" required placeholder="Password">
            <small id="emailHelp" class="form-text text-muted">only letters and numbers, 6 to 64 characters</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password repeat</label>
            <input type="password" class="form-control" id="InputPassword2" pattern="[a-zA-Z0-9]{6,64}" name="user_password_repeat" required placeholder="Repeat">
          </div>
<!--            <div class="field">
              <input type="password" id="fieldPassword" class="input" required pattern=.*\S.* />
              <label for="fieldPassword" class="label">Password</label>
            </div> -->
            <div class="profile__footer">
              <div>
                <div class="button raised blue button_left">
                  <a href="./signIn.php" id="signIn"><div class="center" fit>LOGIN</div></a>
                  <paper-ripple fit></paper-ripple>
                </div>
                <div class="button_right">
                  <div class="center" fit><button  type="submit"  name="register"  value="Register"  class="center btn btn-primary fit">SIGN UP</button></div>
                  <paper-ripple fit></paper-ripple>
                </div>
              </div>
            </div>
 <!--         </div>-->

        </form>

      </div>
    </div>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</body>
</html>
