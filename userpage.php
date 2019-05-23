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
        echo "Welcome " . $row['FIRST_NAME'] . " " . $row['LAST_NAME'];
    }
}
oci_free_statement($sql);

global $info_emp;
global $info_terrain;
global $info_vehicles;

$get_info_emp = "SELECT name FROM employees WHERE users_user_id = :usr_id";
$get_info_vehicle = "SELECT vehicle_type, status FROM vehicles WHERE users_user_id = :usr_id";
$get_info_terrain = "SELECT area FROM terrains WHERE users_user_id = :usr_id";

//EMPLOYEES DETAILS QUERY
$sql = oci_parse($db, $get_info_emp);
oci_bind_by_name($sql, ':usr_id', $usr_id);
if(oci_execute($sql))
{
    $row = oci_fetch_array($sql,OCI_ASSOC);
    if($row)
    {
        $info_emp = $row;
    }
}
oci_free_statement($sql);
//EMP DETAILS QUERY

//VEHICLES DETAILS QUERY
$sql = oci_parse($db, $get_info_vehicle);
oci_bind_by_name($sql, ':usr_id', $usr_id);
if(oci_execute($sql))
{
    $row = oci_fetch_array($sql,OCI_ASSOC);
    if($row)
    {
        $info_vehicles = $row;
    }
}
oci_free_statement($sql);
//VEHICLES DETAILS QUERY

//TERRAINS DETAILS QUERY
$sql = oci_parse($db, $get_info_terrain);
oci_bind_by_name($sql, ':usr_id', $usr_id);
if(oci_execute($sql))
{
    $row = oci_fetch_array($sql,OCI_ASSOC);
    if($row)
    {
        $info_terrain = $row;
    }
}
oci_free_statement($sql);
//TERRAINS DETAILS QUERY

?>

<div class="center">

</div>
<div style="width:800px; margin:0 auto;">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Employees</th>
            <th scope="col">Vehicles</th>
            <th scope="col">Terrains</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $info_emp['NAME'];?></td>
            <td><?php echo $info_vehicles['VEHICLE_TYPE'] . "->" . $info_vehicles['STATUS'];?></td>
            <td><?php echo $info_terrain['AREA'] . " m<sup>2</sup>";?></td>
        </tr>
        </tbody>
    </table>
    <form action="" method="post">
        <input type="submit" class="btn btn-danger" name="reset_pwd" value="Reset Password" />
    </form>
    <form action="" method="post">
        <input type="submit" class="btn btn-danger" name="delete_acc" value="Delete Account" />
    </form>
</div>

<?php

if( isset($_POST['reset_pwd']))
{
    header('Location: resetpass.php');
}

if( isset($_POST['delete_acc']))
{
   header('Location: deleteacc.php');
}
?>