<?php
require_once(__DIR__.'/../admin/sql_connect.php');
// get the q parameter from URL
$q = $_REQUEST["q"];
global $mysqli;
$sql = "SELECT * FROM hours_open WHERE id NOT IN( SELECT reservation.hour_id FROM reservation WHERE reservation.date = ? )";


if($statment = $mysqli->prepare($sql)){
    if($statment->bind_param('s',$q)){
        $statment->execute();
        $result = $statment->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    }
}

$hint = "";

  foreach($rows as $r) {
    $hint .= '<option value = "'.$r['id'].'">'.$r['Hour'].'</option>';
}

echo $hint;
?>