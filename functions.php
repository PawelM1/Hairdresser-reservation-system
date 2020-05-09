<?php
require('admin/sql_connect.php');

function get_hairCut()
{
    global $mysqli;
    $sql = "SELECT * from haircut";
    $result = $mysqli->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    return $rows;
}
?>