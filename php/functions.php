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
    $sql = "SELECT client.surname, client.phone_number, haircut.name, haircut.price, reservation.date,hours_open.Hour FROM reservation INNER JOIN client ON reservation.client_id = client.id INNER JOIN haircut ON reservation.haircut_id = haircut.id INNER JOIN hours_open ON reservation.hour_id = hours_open.id ORDER BY reservation.date";
    $result = $mysqli->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    return $rows;
}

//Add reservation to DB
function reserve($name, $surname, $phone,$typeHairCut,$termin,$hour)
{
    global $mysqli;
    $sql = "INSERT INTO client (`name`, `surname`,`phone_number`) VALUES(?,?,?)";
    if($statment = $mysqli->prepare($sql)){
        if($statment->bind_param('sss',$name,$surname,$phone)){
            $statment->execute();
            $client_id = $mysqli->insert_id;
                $sql_2 = "INSERT INTO reservation(`client_id`,`haircut_id`,`date`,`hour_id`) VALUES(?,?,?,?)";

                if($statment_2 = $mysqli->prepare($sql_2)){
                    if($statment_2->bind_param('iiss',$client_id,$typeHairCut,$termin,$hour)){
                        $statment_2->execute();
                        $reservation_id = $mysqli->insert_id; //get id of new reservation for extOrderId in payu
                        make_pay($name, $surname, $phone,$typeHairCut,$reservation_id);
                    }
                }
        }
    }else{
        die('Niepoprawne zapytanie');
    }
}

function make_pay($name, $surname,$phone,$typeHairCut, $reservation_id)
{
    session_start();
    $_SESSION['reservationID'] = $reservation_id; //If the payment fails, we will remove reservations with this id number
    //Get necessary payment information from the database
    global $mysqli;
    $cost;
    $service_name;
    $sql ="SELECT name, price From haircut WHERE id = ?";
    if($statment = $mysqli->prepare($sql)){
        if($statment->bind_param('i',$typeHairCut)){
            $statment->execute();
            $result = $statment->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $service_name = $row['name'];
            $cost = $row['price'] * 100;
        }
    }

    require_once(__DIR__.'\..\openpayu_php\lib\openpayu.php');
    require_once(__DIR__.'\..\openpayu_php\examples\config.php');
    $order['continueUrl'] = 'http://localhost/barber/index.php'; //customer will be redirected to this page after successfull payment
    $order['notifyUrl'] = 'http://localhost/';
    $order['customerIp'] = $_SERVER['REMOTE_ADDR'];
    $order['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
    $order['description'] = 'Visit Reservation';
    $order['currencyCode'] = 'PLN';
    $order['totalAmount'] = $cost;
    $order['extOrderId'] = $reservation_id; //must be unique!

    $order['products'][0]['name'] = $service_name;
    $order['products'][0]['unitPrice'] = $cost;
    $order['products'][0]['quantity'] = 1;

    //optional section buyer
    $order['buyer']['phone'] = $phone;
    $order['buyer']['firstName'] = $name;
    $order['buyer']['lastName'] = $surname;

    $response = OpenPayU_Order::create($order);

    header('Location:'.$response->getResponse()->redirectUri); //You must redirect your client to PayU payment summary page.
}
?>