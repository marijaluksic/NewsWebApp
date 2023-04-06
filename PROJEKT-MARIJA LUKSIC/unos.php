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
      <div class="row" style="padding-left: 15px">
        <img src="img/sternlogo.png" alt="stern logo" />
        <nav>
          <h1>stern</h1>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="kategorija.php?id=politik">Politik</a></li>
            <li><a href="kategorija.php?id=gesundheit">Gesundheit</a></li>
            <li><a href="administracija.php" style="color: firebrick">Administracija</a></li>
            <li><a href="registracija.php">Registracija</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main class="container">
      <section>
        <div class="row" style="padding-left: 15px">
          <form
            action="skripta.php"
            method="POST"
            name="unos"
            enctype="multipart/form-data"
          >
            <div class="form-item">
              <label for="naslov">Naslov vijesti</label>
              <div class="form-field">
                <input type="text" name="naslov" id="naslov" /><br>
                <span id="porukaNaslov"></span>
              </div>
            </div>
            <div class="form-item">
              <label for="autor">Autor</label>
              <div class="form-field">
                <input type="text" name="autor" />
              </div>
            </div>
            <div class="form-item">
              <label for="tematag">Tema vijesti</label>
              <div class="form-field">
                <input type="text" name="tematag" id="tematag" /><br>
                <span id="porukaTemaTag"></span>
              </div>
            </div>
            <div class="form-item">
              <label for="datum">Datum</label>
              <div class="form-field">
                <input type="date" name="datum" id="datum" /><br>
                <span id="porukaDatum"></span>
              </div>
            </div>
            <div class="form-item">
              <label for="about">Kratki sadržaj vijesti (do 100 znakova)</label>
              <div class="form-field">
                <textarea
                  name="about"
                  id="about"
                  cols="30"
                  rows="10"
                  class="form-field-textual"
                ></textarea><br>
                <span id="porukaAbout"></span>
              </div>
            </div>
            <div class="form-item">
              <label for="sadrzaj">Sadržaj vijesti</label>
              <div class="form-field">
                <textarea
                  name="sadrzaj"
                  id="sadrzaj"
                  cols="30"
                  rows="10"
                  class="form-field-textual"
                ></textarea><br>
                <span id="porukaSadrzaj"></span>
              </div>
            </div>
            <div class="form-item">
              <label for="picture">Slika: </label>
              <div class="form-field">
                <input
                  type="file"
                  accept="image/jpg,image/gif"
                  class="input-text"
                  name="picture"
                  id="picture"
                /><br>
                <span id="porukaSlika"></span>
              </div>
            </div>
            <div class="form-item">
              <label for="kategorija">Kategorija vijesti</label>
              <div class="form-field">
                <select
                  name="kategorija"
                  id="kategorija"
                  class="form-field-textual"
                >
                  <option disabled="disabled" selected>
                    Odaberi kategoriju
                  </option>
                  <option value="politik">Politik</option>
                  <option value="gesundheit">Gesundheit</option>
                </select><br>
                <span id="porukaKategorija"></span>
              </div>
            </div>
            <div class="form-item">
              <label
                >Spremiti u arhivu:
                <div class="form-field">
                  <input type="checkbox" name="arhiva" />
                </div>
              </label>
            </div>
            <div class="form-item">
              <button type="reset" value="Poništi">Poništi</button>
              <button type="submit" value="Prihvati" id="id_g">Prihvati</button>
            </div>
          </form>
        </div>
      </section>
    </main>

    <footer>
      <p>Nachrichten vom ';
      $danasnjiDatum = date('d.m.Y');
      echo $danasnjiDatum;
      echo '
       | © stern.de GmbH | Administracija</p>
      <box-icon
        type="solid"
        name="cookie"
        animation="spin"
        color="#713F12"
      ></box-icon>
    </footer>';
    ?>
    <script type="text/javascript">
      document.getElementById("id_g").onclick = function (event) {
        var slanje_forme = true;

        var poljeNaslov = document.getElementById("naslov");
        var naslov = document.getElementById("naslov").value;
        var porukaNaslov = document.getElementById("porukaNaslov");

        if (naslov.length < 5 || naslov.length > 30) {
          slanje_forme = false;
          poljeNaslov.style.border = "1px dashed red";
          porukaNaslov.style.color = "red";

          document.getElementById("porukaNaslov").innerHTML =
            "Naslov vijesti mora imati 5-30 znakova!<br><br>";
        } else {
          poljeNaslov.style.border = "1px solid green";

          document.getElementById("porukaNaslov").innerHTML =
            "";
        }
        var poljeTemaTag = document.getElementById("tematag");
        var tematag = document.getElementById("tematag").value;
        var porukaTemaTag = document.getElementById("porukaTemaTag");

        if (naslov.length < 1) {
          slanje_forme = false;
          poljeTemaTag.style.border = "1px dashed red";
          porukaTemaTag.style.color = "red";

          document.getElementById("porukaTemaTag").innerHTML =
            "Polje ne smije ostati prazno!<br><br>";
        } else {
          poljeTemaTag.style.border = "1px solid green";

          document.getElementById("porukaTemaTag").innerHTML =
            "";
        }
        var poljeDatum = document.getElementById("datum");
        var datum = document.getElementById("datum").value;
        var porukaDatum = document.getElementById("porukaDatum");

        if (!datum) {
          slanje_forme = false;
          poljeDatum.style.border = "1px dashed red";
          porukaDatum.style.color = "red";

          document.getElementById("porukaDatum").innerHTML =
            "Odaberite datum!<br><br>";
        } else {
          poljeDatum.style.border = "1px solid green";

          document.getElementById("porukaDatum").innerHTML =
            "";
        }
        var poljeAbout = document.getElementById("about");
        var about = document.getElementById("about").value;
        var porukaAbout = document.getElementById("porukaAbout");

        if (about.length < 10 || about.length > 100) {
          slanje_forme = false;
          poljeAbout.style.border = "1px dashed red";
          porukaAbout.style.color = "red";

          document.getElementById("porukaAbout").innerHTML =
            "Kratki sadržaj vijesti mora imati 10-100 znakova!<br><br>";
        }else {
          poljeAbout.style.border = "1px solid green";

          document.getElementById("porukaAbout").innerHTML =
            "";
        }
        var poljeSadrzaj = document.getElementById("sadrzaj");
        var sadrzaj = document.getElementById("sadrzaj").value;
        var porukaSadrzaj = document.getElementById("porukaSadrzaj");

        if (!sadrzaj) {
          slanje_forme = false;
          poljeSadrzaj.style.border = "1px dashed red";
          porukaSadrzaj.style.color = "red";

          document.getElementById("porukaSadrzaj").innerHTML =
          "Polje ne smije ostati prazno!<br><br>";
        } else {
          poljeSadrzaj.style.border = "1px solid green";

          document.getElementById("porukaSadrzaj").innerHTML =
            "";
        }
        var poljeSlika = document.getElementById("picture");
        var slika = document.getElementById("picture").value;
        var porukaSlika = document.getElementById("porukaSlika");

        if (!slika) {
          slanje_forme = false;
          poljeSlika.style.border = "1px dashed red";
          porukaSlika.style.color = "red";

          document.getElementById("porukaSlika").innerHTML =
          "Odaberite sliku!<br><br>";
        }else {
          poljeSlika.style.border = "1px solid green";

          document.getElementById("porukaSlika").innerHTML =
            "";
        }
        var poljeKategorija = document.getElementById("kategorija");
        var kategorija = document.getElementById("kategorija").selectedIndex;
        var porukaKategorija = document.getElementById("porukaKategorija");

        if (!kategorija) {
          slanje_forme = false;
          poljeKategorija.style.border = "1px dashed red";
          porukaKategorija.style.color = "red";

          document.getElementById("porukaKategorija").innerHTML =
          "Odaberite kategoriju!<br><br>";
        }else {
          poljeKategorija.style.border = "1px solid green";

          document.getElementById("porukaKategorija").innerHTML =
            "";
        }
        if (slanje_forme != true) {
          event.preventDefault();
        }
      };
    </script>
  </body>
</html>
