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

//Add reservation to DB
function reserve($name, $surname, $phone,$typeHairCut,$termin,$hour){
    global $mysqli;

    $from_date = $termin;
    $to_date = date('Y-m-d H:i',strtotime($from_date,'+ '.$days.' days + '.$hours.' hours'));

    $sql = "INSERT INTO client (`name`, `surname`,`phone_number`) VALUES(?,?,?)";
    if($statment = $mysqli->prepare($sql)){
        if($statment->bind_param('sss',$name,$surname,$phone)){
            $statment->execute();
            $client_id = $mysqli->insert_id;
                $sql_2 = "INSERT INTO reservation(`client_id`,`haircut_id`,`date`,`to_date`) VALUES(?,?,?,?)";

                if($statment_2 = $mysqli->prepare($sql_2)){
                    if($statment_2->bind_param('iiss',$client_id,$typeHairCut,$from_date,$to_date)){
                        $statment_2->execute();
                        header("Location: ../index.php");
                    }
                }
        }
    }else{
        die('Niepoprawne zapytanie');
    }
}


?>