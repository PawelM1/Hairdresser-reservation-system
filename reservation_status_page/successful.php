<?php
if(isset($_GET['error']))
header('Location:../reservation_status_page/unsuccessful.php?error=' . $_GET['error']);
?>
?>
header('Location:../reservation_status_page/unsuccessful.php?error=' . $_GET['error']);
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Dziękujemy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="content">
        <div class="comunicatSuccess">Rezerwacja przebiegła pomyślnie, zapraszamy do naszego salonu :)</div>
        <a href="../index.php" class="back">Wróć</a>
    </div>
</body>
</html>