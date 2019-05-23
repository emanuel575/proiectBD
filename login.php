<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
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

<div class="cotainer">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail
                                Address</label>
                            <div class="col-md-6">
                                <input type="text" id="emailLogin" class="form-control" name="email_login" required
                                       autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" id="passwordLogin" class="form-control" name="password_login"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary" name="loginB">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

</body>
</html>

<?php

$db = oci_connect('emanuel', 'emanuel', 'localhost/XE');
if (!$db) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if (isset($_POST['loginB'])) {

    echo "salut iuliaan";
    $pwd = $_POST['password_login'];
    $email = $_POST['email_login'];

    $query_login = "SELECT * FROM users WHERE (email = :email AND pwd=:pwd)";

    $sql = oci_parse($db, $query_login);

    oci_bind_by_name($sql, ':email', $email);
    oci_bind_by_name($sql, ':pwd', $pwd);

    if (oci_execute($sql)) {
        echo "o mers";
        while (($row = oci_fetch_array($sql, OCI_BOTH)) != false) {
            // Use the uppercase column names for the associative array indices
            echo $row[0] . " and " . $row['USER_ID']   . " are the same<br>\n";
            echo $row[1] . " and " . $row['EMAIL'] . " are the same<br>\n";
        }
    } else {
        echo "failed ceva";
    }
    oci_free_statement($sql);
    oci_close($db);
    echo "Page will be reloaded in 5 seconds";
    header("Refresh: 5");
}

?>