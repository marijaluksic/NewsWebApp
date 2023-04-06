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
    
    define('UPLPATH', 'img/');
    $uspjesnaPrijava = false;
    $admin= false;
    $danasnjiDatum = date('d.m.Y');
    $servername = "localhost";
    $username = "root";
    $password = "danup695";
    $basename = "projekt";

    $dbc = mysqli_connect($servername, $username, $password, $basename) or
    die('Error connecting to MySQL server.' . mysqli_error());

    
    echo "                      
    <header class='container'>
      <div class='row' style='padding-left: 15px;'>
        <img src='img/sternlogo.png' alt='stern logo' />
        <nav>
          <h1>stern</h1>
          <ul>
            <li><a href='index.php'>Home</a></li>
            <li><a href='kategorija.php?id=politik'>Politik</a></li>
            <li><a href='kategorija.php?id=gesundheit'>Gesundheit</a></li>
            <li><a href='administracija.php' style='color: firebrick;'>Administracija</a></li>
            <li><a href='registracija.php'>Registracija</a></li>
          </ul>
        </nav> 
      </div>
    </header>

    <main class='container'>
    
    <section class='row'>";
    if (!isset($_SESSION['$usename']) && !isset($_POST['prijava'])) {
        echo '
        <div class="col-12"><br>
        <form action="administracija.php" name="prijava" method="POST"style="padding-left: 7px;">
        <div>
            <label for="username">Korisničko ime</label>
            <input type="text" name="username" id="username" /><br>
            <span id="porukaUsename"></span><br>
        </div>
        <div>
            <label for="password">Lozinka</label>
            <input type="password" name="password" id="password" /><br>
            <span id="porukaPassword"></span><br><br>
        </div>
        <button type="submit" id="prijava" name="prijava" value="prijava">Prijava</button>
        </form>
        </div>';}

        if(isset($_POST['prijava'])) {
                if (strlen($_POST['username']) > 0 && strlen($_POST['password']) > 0) {
                    $prijavaImeKorisnika = $_POST['username'];
                    $prijavaLozinkaKorisnika = $_POST['password'];
                    $sql = "SELECT korisnickoIme, lozinka, razina FROM korisnik
                    WHERE korisnickoIme = ?";
                    $stmt = mysqli_stmt_init($dbc);
                    if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }
                    mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, 
                    $levelKorisnika);
                    mysqli_stmt_fetch($stmt);

                    if (password_verify($prijavaLozinkaKorisnika, $lozinkaKorisnika) && 
                    mysqli_stmt_num_rows($stmt) > 0) {
                        $uspjesnaPrijava = true;
                        if($levelKorisnika == 1) {
                            $admin = true;
                        }
                        else {
                            echo "<div class='col-12'><p>";
                            echo $imeKorisnika;
                            echo ", nemate dovoljna prava za pristup ovoj stranici.</p></div>";
                            echo "<div class='col-12'>
                <a href='logout.php' style='padding: 10px;
                color: white;
                background-color: firebrick;
                border-radius: 20px;
                border: firebrick 1px solid; float: right; clear:both; text-decoration: none;'>Odjava</a>
                </div>";
                        }
                        $_SESSION['$usename'] = $imeKorisnika;
                        $_SESSION['$level'] = $levelKorisnika;
                    } else {
                        echo "<div class='col-12'><p>Prijava neuspješna!</p></div><br><br> <div class='col-12'><a href='registracija.php' style='padding: 10px;
                        color: white;
                        background-color: firebrick;
                        border-radius: 20px;
                        border: firebrick 1px solid; text-decoration: none; margin-left: 110px;'>REGISTRIRAJ SE</a></div><br><br>";
                    }
 
                } else {
                echo "<div class='col-12'><p>Ispunite sva polja!<p></div><br><br>";
                }
            }
    else if (isset($_SESSION['$usename']) && $_SESSION['$level'] == 0) {
        echo "<div class='col-12'><p>";
                            echo $_SESSION['$usename'];
                            echo ", nemate dovoljna prava za pristup ovoj stranici.</p></div>";
        echo "<div class='col-12'>
                <a href='logout.php' style='padding: 10px;
                color: white;
                background-color: firebrick;
                border-radius: 20px;
                border: firebrick 1px solid; float: right; clear:both; text-decoration: none;'>Odjava</a>
                </div>";
    }
    if (($uspjesnaPrijava == true && $admin == true) || 
    (isset($_SESSION['$usename']) && $_SESSION['$level'] == 1)) {
        echo "<div class='col-12'>
        <a href='unos.php' style='padding: 10px;
                color: white;
                background-color: firebrick;
                border-radius: 20px;
                border: firebrick 1px solid; text-decoration: none;'>Unos nove vijesti</a>
                <a href='logout.php' style='padding: 10px;
                color: white;
                background-color: firebrick;
                border-radius: 20px;
                border: firebrick 1px solid; float: right; clear:both; text-decoration: none;'>Odjava</a>
                </div></section><section class='row'>";
        $query = "SELECT * FROM vijest";
        $result = mysqli_query($dbc, $query);
        while($row = mysqli_fetch_array($result)) {
 
        echo '<form enctype="multipart/form-data" action="" method="POST" class="col-12 col-sm-4">
                <div class="form-item">
                    <label for="title">Naslov vijesti:</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" 
                        value="'.$row['naslov'].'">
                    </div>
                </div>
                <div class="form-item">
                    <label for="autor">Autor vijesti:</label>
                    <div class="form-field">
                        <input type="text" name="autor" class="form-field-textual" 
                        value="'.$row['autor'].'">
                    </div>
                </div>
                <div class="form-item">
                    <label for="tematag">Tema vijesti:</label>
                    <div class="form-field">
                        <input type="text" name="tematag" class="form-field-textual" 
                        value="'.$row['temaTag'].'">
                    </div>
                </div>
                <div class="form-item">
                    <label for="datum">Datum:</label>
                    <div class="form-field">
                        <input type="date" name="datum" class="form-field-textual" 
                        value="'.$row['datum'].'">
                    </div>
                </div>
                <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 100 
                    znakova):</label>
                    <div class="form-field">
                        <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">'.$row['sazetak'].'</textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="content">Sadržaj vijesti:</label>
                    <div class="form-field">
                        <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">'.$row['tekst'].'</textarea>
                    </div>
                </div>
                <div class="form-item">
                    <label for="picture">Slika:</label>
                    <div class="form-field">
                        <input type="file" class="input-text" id="picture" 
                        value="'.$row['slika'].'" name="picture"/> <br><img src="' . UPLPATH . 
                        $row['slika'] . '" style="width:100px;">
                    </div>
                </div>
                <div class="form-item">
                    <label for="category">Kategorija vijesti:</label>
                    <div class="form-field">
                        <select name="category" id="" class="form-field-textual" 
                        value="'.$row['kategorija'].'">';
                        if ($row['kategorija'] == 'politik') {
                            echo '<option value="politik">Politik</option>
                                <option value="gesundheit">Gesundheit</option>';
                        } else {
                            echo '<option value="gesundheit">Gesundheit</option>
                            <option value="politik">Politik</option>
                            ';
                        };
                        echo '</select>
                    </div>
                </div>
                <div class="form-item">
                    <label>Spremiti u arhivu: 
                    <div class="form-field">';
                        if($row['arhiva'] == 0) {
                            echo '<input type="checkbox" name="archive" id="archive"/> 
                            Arhiviraj?';
                        } else {
                            echo '<input type="checkbox" name="archive" id="archive" 
                            checked/> Arhiviraj?';
                        }
                    echo '</div>
                    </label>
                    </div>
                </div>
                <div class="form-item">
                    <input type="hidden" name="id" class="form-field-textual" 
                    value="'.$row['id'].'">
                    <button type="reset" value="Poništi">Poništi</button>
                    <button type="submit" name="update" value="Prihvati"> 
                    Izmjeni</button>
                    <button type="submit" name="delete" value="Izbriši"> 
                    Izbriši</button>
                </div>
            </form>';
        }
        if(isset($_POST['delete'])) {
        $id=$_POST['id'];
        $query = "DELETE FROM vijest WHERE id=$id ";
        $result = mysqli_query($dbc, $query) or
        die('Error querying database');
        }
        if(isset($_POST['update'])) {
        $slika = $_FILES['picture']['name'];
        $tematag = $_POST['tematag'];
        $naslov=$_POST['title'];
        $datum = $_POST['datum'];
        $sazetak=$_POST['about'];
        $sadrzaj=$_POST['content'];
        $kategorija=$_POST['category'];
        $id=$_POST['id'];
        if(isset($_POST['archive'])) {
         $arhiva=1;
        } else {
         $arhiva=0;
        }
        if (strlen($_POST['autor'])>0) {
            $autor = $_POST['autor'];
        } else {
            $autor = 0;
        }
        if (strlen($slika)>0) {
            $target_dir = 'img/'.$slika;
            move_uploaded_file($_FILES["picture"]["tmp_name"], $target_dir);
            $query = "UPDATE vijest SET naslov='$naslov', datum='$datum', sazetak='$sazetak', tekst='$sadrzaj', 
            slika='$slika', kategorija='$kategorija', arhiva='$arhiva', autor='$autor', temaTag='$tematag' WHERE id=$id;";
            $result = mysqli_query($dbc, $query) or
            die('Error querying database');
        } else {
            $query = "UPDATE vijest SET naslov='$naslov', datum='$datum', sazetak='$sazetak', tekst='$sadrzaj', 
            kategorija='$kategorija', arhiva='$arhiva', autor='$autor', temaTag='$tematag' WHERE id=$id;";
            $result = mysqli_query($dbc, $query) or
            die('Error querying database');
        }
        }

        mysqli_close($dbc); 
    }
    echo "</section></main>

    <footer>
      <p>
        Nachrichten vom ";
        echo $danasnjiDatum;
        echo " | © stern.de GmbH | Administracija</p>
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
