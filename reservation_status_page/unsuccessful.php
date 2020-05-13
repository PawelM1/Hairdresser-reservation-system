<?php
require_once(__DIR__.'/../admin/sql_connect.php');
session_start();
//delete unsuccessful transactions
if(isset($_SESSION['reservationID']))
{
    global $mysqli;
    $id = $_SESSION['reservationID'];
    $sql = "DELETE FROM reservation WHERE id = $id";
    $mysqli->query($sql);
    unset($_SESSION['reservationID']);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Błąd</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="content">
        <div class="comunicatFail">Płatność nie powiodła się. Spróbuj ponownie, bądź skontaktuj się z naszym salonem.<br>Nasze dane kontaktowe znajdziesz na stronie głównej naszego salonu.</div>
        <a href="../index.php" class="back">Wróć</a>
    </div>
</body>
</html>