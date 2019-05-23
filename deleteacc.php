<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
    $row = oci_fetch_array($sql, OCI_ASSOC);
    if ($row) {
        echo "Delete account mr/ms  " . $row['FIRST_NAME'] . " " . $row['LAST_NAME'];
    }
}
oci_free_statement($sql);
?>

<h1>If you are sure you want to delete your account enter your password and press OK otherwise press NO</h1>
<div class="form-group">
    <form action="" method="post">
        Password: <input type="password" id="pwd_control" name="pwd_control">
    </form>
    <form action="" method="post">
        <input type="submit" class="btn btn-danger" name="yes_btn" value="Yes"/>
    </form>
    <form action="" method="post">
        <input type="submit" class="btn btn-primary" name="no_btn" value="No"/>
    </form>
</div>

<?php


$usr_id = $_SESSION['user'];

$db = oci_connect('emanuel', 'emanuel', 'localhost/XE');
if (!$db) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


$query_get_pwd = "SELECT pwd FROM users WHERE (user_id = :usr_id)";

$sql = oci_parse($db, $query_get_pwd);

oci_bind_by_name($sql, ':usr_id', $usr_id);

$current_pwd = 0;
if (oci_execute($sql)) {
    $row = oci_fetch_array($sql, OCI_ASSOC);
    if ($row) {
        $current_pwd = $row['PWD'];
    }
}

if (isset($_POST['yes_btn'])) {
    $query_delete = "BEGIN
                     DELETE FROM users WHERE user_id = :usr_id;
                     DELETE FROM users_details WHERE users_user_id = :usr_id;
                     DELETE FROM terrains WHERE users_user_id = :usr_id;
                     DELETE FROM vehicles WHERE users_user_id = :usr_id;
                     DELETE FROM employees WHERE users_user_id = :usr_id;
                     END;"
                    ;

    $sql = oci_parse($db, $query_delete);

    oci_bind_by_name($sql, ':usr_id', $usr_id);

    if (oci_execute($sql)) {
        $_SESSION['user'] = null;
        session_destroy();
        header:
        ('Location: register.php');
    } else {
        echo "User cannot be deleted";
    }
}
if (isset($_POST['no_btn'])) {
    header('Location: userpage.php');
}
?>
