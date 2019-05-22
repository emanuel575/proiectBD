<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php
global $varib;
$varib = true;
?>

<form class="form-horizontal" action='register.php' method="post">
    <fieldset>
        <div id="legend">
            <legend class="">Register</legend>
        </div>
        <div class="control-group">
            <!-- Username -->
            <label class="control-label"  for="username">Username</label>
            <div class="controls">
                <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
                <p class="help-block">Username can contain any letters or numbers, without spaces</p>
            </div>
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
                if(isset($_POST['submit'])) :
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
            <label class="control-label"  for="password_confirm">Password (Confirm)</label>
            <div class="controls">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
                <p class="help-block">Please confirm password</p>
                <?php
                if(isset($_POST['submit'])) :
                    if ( $_POST['password'] != $_POST['password_confirm']): ?>
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
            <label class="control-label"  for="first_name">First Name</label>
            <div class="controls">
                <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge">
            </div>
        </div>
        <div class="control-group">
            <!-- Username -->
            <label class="control-label"  for="last_name">Last Name</label>
            <div class="controls">
                <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge">
            </div>
        </div>
        <div class="control-group">
            <!-- Username -->
            <label class="control-label"  for="phone">Phone</label>
            <div class="controls">
                <input type="text" id="phone" name="phone" placeholder="" class="input-xlarge">
                <p class="help-block">Phone number length should be exactly 10 </p>
                <?php
                if(isset($_POST['submit'])) :
                    if ( strlen($_POST['phone']) < 10 ): ?>
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

<?php


$db = mysqli_connect("remotemysql.com", "mvxI3opY2H", "QSSr33vZ0U", "mvxI3opY2H");

if ($db->connect_error){
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

if(isset($_POST['submit']))
{
    if($varib == true)
    {
        $usr = $_POST['username'];
        $pwd = $_POST['password'];
        $pwd_confirm = $_POST['password_confirm'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone = $_POST['phone'];
        $sql = "INSERT INTO users (user_id, email, pass) VALUES ($z,'$email', '$pwd')";

        if( mysqli_query($db, $sql) == true)
        {
            echo "User inserted successfully";
        }
        else
        {
            echo "User was not succesfully inserted";
        }
    }
}

?>