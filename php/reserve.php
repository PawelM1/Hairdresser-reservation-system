<?php
require_once(__DIR__.'/../admin/sql_connect.php');
if(!empty($_POST)){
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $phone = trim($_POST['phone']);
    $typeHairCut = $_POST['cut'];
    $termin = $_POST['date'];
    $hour = $_POST['Hour'];

    foreach($_POST as $p){
        if($p == ''){
            die('Uzupełnij pole!');
        }
    }

    $today = date('Y-m-d');
    $end_date = date('Y-m-d', strtotime($today.'+ 20 days')); 
    if($termin < $today || $termin > $end_date){
        die('Niepoprawna data. Maksymalnie można zarezerwować wiztę do 21 dni od dzisaj');
    }
    require_once('functions.php');
    reserve($name,$surname,$phone,$typeHairCut,$termin,$hour);
}
?>