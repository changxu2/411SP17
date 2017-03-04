<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<table border="1" width="500" align="center">
<!-- register form -->
<form method="post" action="register.php" name="registerform">

    <!-- the user name input field uses a HTML5 pattern check -->
    <tr>
        <th><label for="login_input_username">Username (letters and numbers, 2 to 64 char)</label></th>
        <td><input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /></td>
    </tr>
    <!-- the email input field uses a HTML5 email type check -->
    <tr>
        <th><label for="login_input_email">User's email</label></th>
        <td><input id="login_input_email" class="login_input" type="email" name="user_email" required /></td>
    </tr>

    <tr>
        <th><label for="login_input_password_new">Password (min. 6 characters)</label></th>
        <td><input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /></td>
    </tr>

    <tr>
        <th><label for="login_input_password_repeat">Repeat password</label></th>
        <td><input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /></td>
    </tr>

    <tr>
        <td colspan="2" align="center"><input type="submit"  name="register" value="Register" /></td>
    </tr>

</form>
</table>

<!-- backlink -->
<a href="index.php">Back to Login Page</a>

