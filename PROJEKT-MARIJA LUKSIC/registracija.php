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
        echo '
        <header class="container">
            <div class="row" style="padding-left: 7px;">
                <img src="img/sternlogo.png" alt="stern logo" />
                <nav>
                    <h1>stern</h1>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="kategorija.php?id=politik">Politik</a></li>
                        <li><a href="kategorija.php?id=gesundheit">Gesundheit</a></li>
                        <li><a href="administracija.php">Administracija</a></li>
                        <li><a href="registracija.php" style="color: firebrick;">Registracija</a></li>
                    </ul>
                </nav> 
            </div>
        </header>

        <main class="container">
            <section>
                <div class="row" style="padding-left: 7px">
                <form method="POST" action = "">
                    <label for="username">Korisničko ime: </label>
                    <input type="text" name="username" id="username"/><br /><br />
                    <span id="porukaUseName"></span>
                    <label for="firstname">Ime: </label>
                    <input type="text" name="firstname" id="firstname"/><br /><br />
                    <span id="porukaFirstName"></span>
                    <label for="lastname">Prezime: </label>
                    <input type="text" name="lastname" id="lastname"/><br /><br />
                    <span id="porukaLastName"></span>
                    <label for="password">Lozinka: </label>
                    <input type="password" name="password" id="password"/><br /><br />
                    <span id="porukaPassword"></span>
                    <label for="password1">Ponovite lozinku: </label>
                    <input type="password" name="password1" id="password1"/><br /><br />
                    <span id="porukaPassword1"></span>
                    <button type="submit" name="submit" value="Registracija" id="gumb">Registracija</button><br /><br />
                </form>
                </div>';
            
        

        $servername = "localhost";
        $username = "root";
        $password = "danup695";
        $basename = "projekt";

        $dbc = mysqli_connect($servername, $username, $password, $basename) or
        die("Error connecting to MySQL server." . mysqli_error());
        if($dbc) {
            if (isset($_POST['submit'])) {
                if (strlen($_POST['username']) > 0 && strlen($_POST['firstname']) > 0 && strlen($_POST['lastname']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['password1']) > 0) {
                    $sql = "SELECT korisnickoIme FROM korisnik WHERE korisnickoIme = ?;";
                    $stmt = mysqli_stmt_init($dbc);
                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, 's', $_POST['username']);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }
                    if(mysqli_stmt_num_rows($stmt) > 0) {
                        echo "<p>Korisničko ime se već koristi!</p><br><br>";
                    } else {
                        $lozinka1 = $_POST['password'];
                        $lozinka2 =  $_POST['password1'];
                        if (strcmp($lozinka1, $lozinka2) == 0) {
                            $novoime = $_POST['firstname'];
                            $novoprezime = $_POST['lastname'];
                            $novikorisnik = $_POST['username'];
                            $razina = 0;
                            $novalozinka = $_POST['password'];
                            $hashPassword = password_hash($novalozinka, CRYPT_BLOWFISH);
                            $sql = "INSERT INTO korisnik (ime, prezime, korisnickoIme, lozinka, 
                            razina)VALUES (?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($dbc);
                            if (mysqli_stmt_prepare($stmt, $sql)) {
                            mysqli_stmt_bind_param($stmt, 'ssssi', $novoime, $novoprezime, $novikorisnik, 
                            $hashPassword, $razina);
                            mysqli_stmt_execute($stmt);
                            echo "<p style='color: green; font-size: 30px;'>REGISTRACIJA JE USPJEŠNA!</p><br><br>";
                            } else {
                                echo "<p>Registracija je neuspješna</p><br><br>";
                            }

                        } else {
                            echo "<p>Lozinka i ponovljena lozinka moraju biti jednake!</p><br><br>";
                        }
                    }
                }
                else {
                    echo "<p>Ispunite sva polja!<p><br><br>";
                }
            }
        }
        mysqli_close($dbc);
        echo '
    </section>
        </main>
    <footer>
      <p>Nachrichten vom ';
      $danasnjiDatum = date('d.m.Y');
      echo $danasnjiDatum;
      echo ' | © stern.de GmbH | Registracija</p>
      <box-icon
        type="solid"
        name="cookie"
        animation="spin"
        color="#713F12"
      ></box-icon>
    </footer>';
    ?>
    </body>
</html>