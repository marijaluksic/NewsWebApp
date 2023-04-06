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

    $servername = "localhost";
    $username = "root";
    $password = "danup695";
    $basename = "projekt";

    $dbc = mysqli_connect($servername, $username, $password, $basename) or
    die('Error connecting to MySQL server.' . mysqli_error());
    $id = $_GET['ha'];
    if($dbc) {
          $query = "SELECT * FROM vijest WHERE id=$id;";
          $result = mysqli_query($dbc, $query) or
          die('Error querying database');
          if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                if (strlen($row['autor'])>0) {
                    $naslov = $row['naslov'];
                    $datum = $row['datum'];
                    $sazetak = $row['sazetak'];
                    $sadrzaj = $row['tekst'];
                    $slika = $row['slika'];
                    $kategorija = $row['kategorija'];
                    $autor = $row['autor'];
                } else {
                    $naslov = $row['naslov'];
                    $datum = $row['datum'];
                    $sazetak = $row['sazetak'];
                    $sadrzaj = $row['tekst'];
                    $slika = $row['slika'];
                    $kategorija = $row['kategorija'];
                    $autor = 0;
                }      
            }
        }
    }
    mysqli_close($dbc); 

    $danasnjiDatum = date('d.m.Y');
    $datum = date('j. M Y', strtotime($datum));
    define('UPLPATH', 'img/');

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
          if ($autor != 0)
          {
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
