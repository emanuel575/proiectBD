<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<?php

session_start();

$usr_id = $_SESSION['user'];

$db = oci_connect('emanuel', 'emanuel', 'localhost/XE');
if (!$db) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$query_login = "SELECT first_name, last_name FROM users_details WHERE (users_user_id = :usr_id)";

$sql = oci_parse($db, $query_login);

oci_bind_by_name($sql, ':usr_id', $usr_id);

if (oci_execute($sql)) {
    $row = oci_fetch_array($sql,OCI_ASSOC);
    if($row)
    {
        echo "Reset password mr/ms " . $row['FIRST_NAME'] . " " . $row['LAST_NAME'];
    }
}
oci_free_statement($sql);
?>
<form method="post">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">

                    <label>Current Password</label>
                    <div class="form-group pass_show">
                        <input type="password" value="" class="form-control" placeholder="Current Password"
                               name="current_pwd">
                    </div>
                    <label>New Password</label>
                    <div class="form-group pass_show">
                        <input type="password" value="" class="form-control" placeholder="New Password" name="new_pwd">
                        <p class="help-block">Password should be at least 6 characters</p>
                        <?php
                        if (isset($_POST['confirm'])) :
                            if (strlen($_POST['new_pwd']) < 6): ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> Password must be at least 6 characters.
                                </div>
                                <?php $check = false; endif;
                        endif;
                        ?>
                    </div>
                    <label>Confirm Password</label>
                    <div class="form-group pass_show">
                        <input type="password" value="" class="form-control" placeholder="Confirm Password"
                               name="conf_new_pwd">
                        <p class="help-block">Please confirm password</p>
                        <?php
                        if (isset($_POST['submit'])) :
                            if ($_POST['password'] != $_POST['conf_new_pwd']): ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> Passwords must match
                                </div>
                                <?php $check = false; endif;
                        endif;;
                        ?>
                    </div>
                </div>
            </div>
            <form action="" method="post">
                <input type="submit" class="btn btn-success" name="confirm" value="Ok"/>
            </form>
        </div>

</form>
<?php

global $check;
$check = true;

if(isset($_POST['confirm']))
{
    $usr_id = $_SESSION['user'];

    $db = oci_connect('emanuel', 'emanuel', 'localhost/XE');
    if (!$db) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $query_get_pwd = "SELECT pwd FROM users WHERE (user_id = :usr_id)";

    $sql = oci_parse($db, $query_login);

    oci_bind_by_name($sql, ':usr_id', $usr_id);

    $current_pwd = 0;
    if (oci_execute($sql)) {
        $row = oci_fetch_array($sql,OCI_ASSOC);
        if($row)
        {
            $current_pwd = $row['PWD'];
        }
    }

    if($check)
    {
        $new_pwd = $_POST['new_pwd'];
        $conf_new_pwd = $_POST['conf_new_pwd'];

        $query_for_update = "ALTER USER :usr_id IDENTIFIED by "
    }

    oci_free_statement($sql);
}

?>