<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    />
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Stern</title>
  </head>

  <body>
    <?php
    session_start();

    $naslov=$_POST['naslov'];
    $naslov = ucfirst($naslov);
    $tematag=$_POST['tematag'];
    $tematag = strtoupper($tematag);
    $sazetak=$_POST['about'];
    $sazetak = ucfirst($sazetak);
    $sadrzaj=$_POST['sadrzaj'];
    $kategorija=$_POST['kategorija'];
    $slika= $_FILES['picture']['name'];
    $target_dir='img/' . $slika;
    move_uploaded_file($_FILES['picture']['tmp_name'], $target_dir);
    
    if (strlen($_POST['autor'])>0) {
      $autor = $_POST['autor'];
    } else {
      $autor = 0;
    }
    $datum = $_POST['datum'] ;
    $danasnjiDatum = date('d.m.Y');
    if (isset($_POST['arhiva'])) {
            $arhiva = 1;
    } else {
      $arhiva = 0;
    }
    $servername = "localhost";
    $username = "root";
    $password = "danup695";
    $basename = "projekt";

    $dbc = mysqli_connect($servername, $username, $password, $basename) or
    die('Error connecting to MySQL server.' . mysqli_error());

    if($dbc) {
        if ($autor == 0) {
          $query = "INSERT INTO vijest (naslov, datum, sazetak, tekst, slika, kategorija, arhiva, tematag)
          VALUES ('$naslov','$datum','$sazetak','$sadrzaj','$slika','$kategorija','$arhiva','$tematag');";
          $result = mysqli_query($dbc, $query) or
          die('Error querying database');
        } else {
          $query = "INSERT INTO vijest (naslov, datum, sazetak, tekst, slika, kategorija, arhiva, autor, tematag)
          VALUES ('$naslov','$datum','$sazetak','$sadrzaj','$slika','$kategorija','$arhiva','$autor','$tematag');";
          $result = mysqli_query($dbc, $query) or
          die('Error querying database');
        }      
    }
    define('UPLPATH', 'img/');
    mysqli_close($dbc); 
    $datum = date('j. M Y', strtotime($datum));
    
    echo "                      
    <header class='container'>
      <div class='row' style='padding-left: 15px;'>
        <img src='img/sternlogo.png' alt='stern logo' />
        <nav>
          <h1>stern</h1>
          <ul>
            <li><a href='index.php'>Home</a></li>";
            if ($kategorija == "politik") {
              echo "<li><a href='kategorija.php?id=politik' style='color: firebrick;'>Politik</a></li>
                    <li><a href='kategorija.php?id=gesundheit'>Gesundheit</a></li>";
            } else {
              echo "<li><a href='kategorija.php?id=politik'>Politik</a></li>
                    <li><a href='kategorija.php?id=gesundheit' style='color: firebrick;'>Gesundheit</a></li>";
            }
            echo "
            <li><a href='administracija.php'>Administracija</a></li>
            <li><a href='registracija.php'>Registracija</a></li>
            </ul>
        </nav> 
      </div>
    </header>

    <main class='container' id='clanak'>
      <header class='row'>
        <h2 class='col-10 mx-auto'>";
        echo $naslov;
        echo "
        </h2>
        <p class='col-2'>";
        echo $datum;
        echo "</p>
        <h3 class='col-12'>";
        echo $sazetak;
        echo "
        </h3>
      </header>
      <section class='row'>
        <article class='col-12'>";
        echo "<img src='" . UPLPATH . $slika . "'";
          echo " alt = 'Sadržaj se ne učitava' style='height: unset;'/>
          <hr />
          <p>";
          echo $sadrzaj;
          echo "
          </p>";
          if (strlen($_POST['autor'])>0)
          {
            $autor = $_POST['autor'];
            echo "<p style='color: gray;'>Von ";
            echo $autor;
            echo "</p>";
          }
          echo "
        </article>
      </section>
    </main>

    <footer>
      <p>
        Nachrichten vom ";
        echo $danasnjiDatum;
        echo " | © stern.de GmbH | ";
        echo $naslov;
        echo "</p>
      <box-icon
        type='solid'
        name='cookie'
        animation='spin'
        color='#713F12'
      ></box-icon>
    </footer>";
    ?>
  </body>
</html>
