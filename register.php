<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet"
      id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php
global $varib;
$varib = true;
?>


<!doctype html>
<html>
<body>
<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<form class="form-horizontal" action='register.php' method="post">
    <fieldset>
        <div id="legend">
            <legend class="">Register</legend>
        </div>
        <div class="control-group">
            <!-- E-mail -->
            <label class="control-label" for="email">E-mail</label>
            <div class="controls">
                <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
                <p class="help-block">Please provide your E-mail</p>
            </div>
        </div>

        <div class="control-group">
            <!-- Password-->
            <label class="control-label" for="password">Password</label>
            <div class="controls">
                <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
                <p class="help-block">Password should be at least 6 characters</p>
                <?php
                if (isset($_POST['submit'])) :
                    if (strlen($_POST['password']) < 6): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> Password must be at least 6 characters.
                        </div>
                        <?php $varib = false; endif;
                endif;
                ?>
            </div>
        </div>

        <div class="control-group">
            <!-- Password -->
            <label class="control-label" for="password_confirm">Password (Confirm)</label>
            <div class="controls">
                <input type="password" id="password_confirm" name="password_confirm" placeholder=""
                       class="input-xlarge">
                <p class="help-block">Please confirm password</p>
                <?php
                if (isset($_POST['submit'])) :
                    if ($_POST['password'] != $_POST['password_confirm']): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> Passwords must match
                        </div>
                        <?php $varib = false; endif;
                endif;;
                ?>
            </div>
        </div>
        <div class="control-group">
            <!-- Username -->
            <label class="control-label" for="first_name">First Name</label>
            <div class="controls">
                <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge">
            </div>
        </div>
        <div class="control-group">
            <!-- Username -->
            <label class="control-label" for="last_name">Last Name</label>
            <div class="controls">
                <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge">
            </div>
        </div>
        <div class="control-group">
            <!-- Username -->
            <label class="control-label" for="phone">Phone</label>
            <div class="controls">
                <input type="text" id="phone" name="phone" placeholder="" class="input-xlarge">
                <p class="help-block">Phone number length should be exactly 10 </p>
                <?php
                if (isset($_POST['submit'])) :
                    if (strlen($_POST['phone']) < 10): ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> Phone numbers is incorrect
                        </div>
                        <?php $varib = false; endif;
                endif;
                ?>
            </div>
        </div>
        <div class="control-group">
            <!-- Button -->
            <div class="controls">
                <button class="btn btn-success" name="submit">Register</button>
            </div>
        </div>
    </fieldset>
</form>
</body>
</html>
<?php

$db = oci_connect('emanuel', 'emanuel', 'localhost/XE');
if (!$db) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if (isset($_POST['submit'])) {
    if ($varib == true) {
        $pwd = $_POST['password'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];


        $query_users = "INSERT INTO users (email, pwd) VALUES (:email, :pwd)";

        $query_userD = "INSERT INTO users_details (first_name, last_name, phone, users_user_id) VALUES (:first_name, :last_name, :phone,
(SELECT user_id from users WHERE email = :email)
)";

        $sql = oci_parse($db, $query_users);

        oci_bind_by_name($sql, ':email', $email);
        oci_bind_by_name($sql, ':pwd', $pwd);

        if (oci_execute($sql)) {
            echo "users inserted succesfully";
        } else {
            echo "User was not succesfully inserted";
        }

        $sql = oci_parse($db, $query_userD);

        oci_bind_by_name($sql, ':email', $email);
        oci_bind_by_name($sql, ':first_name', $first_name);
        oci_bind_by_name($sql, ':last_name', $last_name);
        oci_bind_by_name($sql, ':phone', $phone);

        if (oci_execute($sql)) {
            echo "users details inserted succesfully\n";
        } else {
            echo "users details have and error";
        }
    }
    echo "Page will be reloaded in 5 seconds";
    header("Refresh: 5");
}

?>