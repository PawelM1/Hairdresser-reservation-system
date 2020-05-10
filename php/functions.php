<?php
require_once(__DIR__.'/../admin/sql_connect.php');

//Get hairCut From DB
function get_hairCut()
{
    global $mysqli;
    $sql = "SELECT * from haircut";
    $result = $mysqli->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    return $rows;
}

//Get reservation data from DB
function get_reservation()
{
    global $mysqli;
    $sql = "SELECT client.surname, haircut.name, haircut.price, reservation.date FROM reservation INNER JOIN client ON reservation.client_id = client.id INNER JOIN haircut ON reservation.haircut_id = haircut.id";
    $result = $mysqli->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    return $rows;
}
?>