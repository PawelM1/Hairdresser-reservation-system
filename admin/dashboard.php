<?php
session_start();
require_once(__DIR__.'\..\php\functions.php');
if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] !==true)
{
die("Nie uzyskano dostępu. Nie zalogowano się poprawnie");
}
?>

<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!--Add srcipt and font with polish characters to generate pdf raport -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.3/jspdf.plugin.autotable.min.js"></script>
    <script src="expressway-normal.js"></script>

    <title>Dashboard</title>
</head>

<body class="bg-dark">
    <div class="col-12">
        <h1 class="text-center text-white font-weight-bold p-5">REZERWACJE</h1>
        <div class="text-center text-white">
            <a href="../index.php" class="m-2 text-white">POWRÓT</a> | <a href="logout.php" class="m-2 text-white">WYLOGUJ</a>
        </div>
    </div>

    <div class="col-12">
        <div class = "d-flex justify-content-center mt-5">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Filtruj według daty" title="Type in a name" class = " mr-4">
            <button class="btn btn-primary" onclick="demoFromHTML()">Generuj PDF</button>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <table id="myTable" class="table bg-secondary text-white">
                <thead class="thead-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Zarezerwował</th>
                        <th scope="col">Kontakt</th>
                        <th scope="col">Rodzaj strzyżenia</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Data</th>
                        <th scope="col">Godzina</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $rows = get_reservation();
                        for($i = 0; $i < count($rows);$i++)
                        {
                            echo '<tr>';
                            echo '<th scope="row">'.($i+1).'</th>';
                            echo '<td>'.$rows[$i]['surname'].'</td>';
                            echo '<td>'.$rows[$i]['phone_number'].'</td>';
                            echo '<td>'.$rows[$i]['name'].'</td>';
                            echo '<td>'.$rows[$i]['price'].'</td>';
                            echo '<td>'.$rows[$i]['date'].'</td>';
                            echo '<td>'.$rows[$i]['Hour'].'</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- Search Filter -->
    <script>
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        } 
    </script>

    <!-- Generate PDF -->    
    <script type="text/javascript">
        function demoFromHTML() {
            var doc = new jsPDF()
            doc.text('Lista rezerwacji', 15, 10)
            doc.setFont('expressway');
            doc.autoTable({
                html: '#myTable',
                headerStyles: { fontStyle: 'expressway' },
                styles: {font: 'expressway'}
                })
           doc.save('Reservation.pdf')
        }
    </script>
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>

</html>