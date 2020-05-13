<?php
//if payment not successfull
if(isset($_GET['error'])){
header('Location: reservation_status_page/unsuccessful.php');
}
require_once('php/functions.php');
?>
<!doctype html>
<html lang="pl">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
    integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/icon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/style.css">
  <title>VLOSACE Barber</title>

<!--Script data fill available hour to reservation visit-->
<script>
function getAvailableHours(select_date) {
  //data for date validation
  var d = new Date(select_date);
  var tommorow = new Date(new Date().getTime()-(1*24*60*60*1000));
  var to_date = new Date(new Date().getTime()+(21*24*60*60*1000));
  
  if(d < tommorow){
    alert("Nie możesz zarezerwować wizyty, na dzień, który już minął");
    document.getElementById("date").value = "";
    document.getElementById("Hour").innerHTML = "";
  }
  else if(d > to_date)
  {
    alert("Maksymalnie możesz zarezerwować wizytę na 3 tygodnie do przodu od dzisiaj.");
    document.getElementById("date").value = "";
    document.getElementById("Hour").innerHTML = "";
  }
  else{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("Hour").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "php/availableHours.php?q="+select_date, true);
    xmlhttp.send();
  }
}
</script>
</head>

<body>
  <!--header-->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark pl-5">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link pr-3" href="">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pr-3" onclick="smoothScroll('#price_list')">CENNIK</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pr-3" onclick="smoothScroll('#reservation')">ZAREZERWUJ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pr-3" onclick="smoothScroll('#about')">KONTAKT</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="container h-75 d-flex align-items-center">
      <div class="row">
        <div class="col-12">
          <h1 class="title display-4 mt-3 ">VLOSACE BARBER</h1>
        </div>
        <div class="col-12">
          <h4 class="text-white font-weight-bold ">Może nie najtaniej, ale jako tako</h4>
        </div>
      </div>
    </div>
  </header>
  <!--header-->
  <!--Price_List-->
  <section id="price_list">
    <div class="container-fluid">
      <h1 class="text-center pt-5 pb-5 text-white font-weight-bold">CENNIK</h1>
      <div class="row d-flex justify-content-center">
        <div class="col-12 d-flex justify-content-center font-weight-bold pt-5 pb-5">
          <table class="table table-dark">
            <thead class="thead-light">
              <tr>
                <th scope="col">Rodzaj strzyżenia</th>
                <th scope="col">Cena</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $rows = get_hairCut();
                foreach($rows as $r){
                  echo '<tr>';
                  echo '<td>'.$r['name'].'</td>';
                  echo '<td>'.$r['price'].' zł'.'</td>';
                  echo '</tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
        <button href="" class="mb-5 btn btn-primary btn-lg" onclick="smoothScroll('#reservation')">REZERWUJ</button>
      </div>
    </div>
  </section>
  <!--Price_List-->
  <!--Reservation-->
  <section id="reservation">
    <div class="container-fluid">
      <h1 class="text-center p-5 text-white font-weight-bold">ZAREZERWUJ</h1>
      <div class="row">
        <div class="col-12 d-flex justify-content-center p-5 text-white">
          <form action="php/reserve.php" method="POST">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="name">Imię</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Imię" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="nazwisko">Nazwisko</label>
                  <input type="text" class="form-control" name="surname" id="surname" placeholder="Nazwisko" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="phone">Telefon</label>
              <input type="tel" name = "phone" class="form-control" placeholder="Podaj nr telefonu" required>
            </div>
            <div class="form-group">
              <label for="cut">Rodzaj strzyżenia</label>
              <select name="cut" id="cut" class="form-control">
                <option value="" disabled>Rodzaj strzyżenia</option>
                <?php
                  $row = get_hairCut();
                  foreach($row as $r){
                    echo '<option value = "'.$r['id'].'">'.$r['name'].'</option>';
                  }
                  ?>
              </select>
            </div>
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="date">Data</label>
                  <input type="date" class="form-control" name="date" id="date" onchange="getAvailableHours(this.value)" required>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                     <label for="Hour">Godzina</label>
                      <select name="Hour"class="form-control" id="Hour" require>
                      <!--Fill by available hour from DB-->  
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-4">
                  <input type="submit" value="ZAREZERWUJ" class = "d-flex ml-auto mr-auto btn btn-danger">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!--Reservation-->
  <!--About-->
  <section id="about">
    <div class="container-fluid">
      <h1 class="text-center pt-5 pb-5 text-white font-weight-bold">KONTAKT</h1>
      <div class="row text-dark">
        <div class="col-lg-6 col-md-12 mb-5">
          <!--Google map-->
          <iframe class="map-size"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7187.79243387444!2d19.295107122422973!3d49.74407931640512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471683697bd635fb%3A0x2687f9ec2cb2427!2s%C5%81ysinkowo!5e0!3m2!1spl!2spl!4v1588844009849!5m2!1spl!2spl"
            frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <!--Google Maps-->
        <div class="col-lg-6 col-md-12 mb-5">
          <!--Contact-->
          <div class="row contact">
            <div class="col-lg-6 col-md-12">
              <div class="">
                <div class="text-center">
                  <i class="fa fa-phone fa-5x mb-3" aria-hidden="true"></i>
                  <h4 class="text-uppercase">Zadzwoń</h4>
                  <p>+11111111</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-mm-12">
              <div>
                <div class="text-center">
                  <i class="fa fa-map-marker fa-5x mb-3" aria-hidden="true"></i>
                  <h4 class="text-uppercase">Lokalizacja</h4>
                  <address>Łysinkowo</address>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div>
                <div class="text-center">
                  <i class="fa fa-clock-o fa-5x mb-3" aria-hidden="true"></i>
                  <h4 class="text-uppercase">Godziny otwarcia</h4>
                  <p>pn-pt: 8:00-16:00</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--Contact-->
      </div>
    </div>
  </section>
  <!--About-->
  <button onclick="smoothScroll('header')" id="up-button"></button>
  <!--Footer-->
  <Footer class="page-footer font-small bg-dark">
      <div class="container">
          <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                  <p>
                    <a href="https://pl-pl.facebook.com">
                    <i class = "fa fa-facebook p-4 fa-3x"></i>
                    </a>
                  </p>
                  <p>
                    <a href="https://twitter.com">
                    <i class = "fa fa-twitter p-4 fa-3x"></i>
                    </a>
                  </p>
                  <p>
                    <a href="https://www.instagram.com/?hl=pl">
                    <i class = "fa fa-instagram p-4 fa-3x"></i>
                    </a>
                  </p>
                </div>
            </div>
          </div>              
      </div>
      <div class="footer-copyright text-center text-white font-weight-bold">
          Strona wykonana w ramach projektu z przedmiotu: Technologie Internetowe
      </div>            
  </Footer>
  <!--Footer-->
  <!-- Optional JavaScript -->
  <script src="js/script.js"></script>
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