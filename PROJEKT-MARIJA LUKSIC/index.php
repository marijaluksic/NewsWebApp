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
			$danasnjiDatum = date('d.m.Y');
			define('UPLPATH', 'img/');
			echo "
				<header class='container'>
					<div class='row' style='padding-left: 15px'>
						<img src='img/sternlogo.png' alt='stern logo' />
						<nav>
							<h1>stern</h1>
							<ul>
								<li><a href='index.php' style='color: firebrick'>Home</a></li>
								<li><a href='kategorija.php?id=politik' class=''>Politik</a></li>
								<li><a href='kategorija.php?id=gesundheit' class=''>Gesundheit</a></li>
								<li><a href='administracija.php'>Administracija</a></li>
								<li><a href='registracija.php'>Registracija</a></li>
							</ul>
						</nav>
					</div>
				</header>

			<main class='container'>
				<section class='row'>
					<h2 class='col-12 mx-auto'><a href='kategorija.php?id=politik' style='color: inherit; text-decoration: none;'>
						POLITIK
						<box-icon type='solid' name='chevron-right' size='md' class='chevron'></box-icon></a>
					</h2>
				</section>
				<section class='row'>";
				if ($dbc) {
					$query = "SELECT * FROM vijest WHERE (kategorija = 'politik') AND (arhiva = 0) ORDER BY id DESC LIMIT 3;";
    				$result = mysqli_query($dbc, $query) or die("Error");
					if ($result) {
						while ($row = mysqli_fetch_array($result)) {
							$id = $row['id'];
							$naslov = $row['sazetak'];
            				$slika = $row['slika'];
							$autor = $row['autor'];
            				$tematag = $row['temaTag'];
							if ($autor!=NULL) {
								echo "
									<article class='col-12 col-sm-4'><a href='clanak.php?ha=$id' style='color: inherit; text-decoration: none;'>";
								echo "<img src='" . UPLPATH . $slika . "'";
								echo " alt = 'Sadržaj se ne učitava'/>
										<p>";
								echo $tematag;
								echo "</p>
										<h3>";
								echo $naslov;
								echo "
										</h3>
										<p id='madrina'>Von ";
								echo $autor;
								echo "</p></a>
									</article>";
							} else {
								echo "
									<article class='col-12 col-sm-4'><a href='clanak.php?ha=$id' style='color: inherit; text-decoration: none;'>";
								echo "<img src='" . UPLPATH . $slika . "'";
								echo " alt = 'Sadržaj se ne učitava'/>
										<p>";
								echo $tematag;
								echo "</p>
										<h3>";
								echo $naslov;
								echo "
										</h3></a>
										</article>";
							}
						}
					}
				}
				echo "
				</section>
				<section class='row'>
					<h2 class='col-12 mx-auto'><a href='kategorija.php?id=gesundheit' style='color: inherit; text-decoration: none;'>
						GESUNDHEIT
						<box-icon type='solid' name='chevron-right' size='md' class='chevron'></box-icon></a>
					</h2>
				</section>
				<section class='row'>";
				if ($dbc) {
					$query1 = "SELECT * FROM vijest WHERE kategorija = 'gesundheit' AND arhiva = 0 ORDER BY id DESC LIMIT 3;";
    				$result1 = mysqli_query($dbc, $query1) or die("Error");
					if ($result1) {
						while ($row = mysqli_fetch_array($result1)) {
							$id = $row['id'];
							$naslov = $row['naslov'];
            				$slika = $row['slika'];
							$autor = $row['autor'];
            				$tematag = $row['temaTag'];
							if ($autor!=NULL) {
								echo "
									<article class='col-12 col-sm-4'><a href='clanak.php?ha=$id' style='color: inherit; text-decoration: none;'>";
								echo "<img src='" . UPLPATH . $slika . "'";
								echo " alt = 'Sadržaj se ne učitava'/>
										<p>";
								echo $tematag;
								echo "</p>
										<h3>";
								echo $naslov;
								echo '
										</h3>
										<p id="madrina">Von ';
								echo $autor;
								echo "</p></a>
									</article>";
							} else {
								echo "
									<article class='col-12 col-sm-4'><a href='clanak.php?ha=$id' style='color: inherit; text-decoration: none;'>";
								echo "<img src='" . UPLPATH . $slika . "'";
								echo " alt = 'Sadržaj se ne učitava'/>
										<p>";
								echo $tematag;
								echo "</p>
										<h3>";
								echo $naslov;
								echo "
										</h3></a>
										</article>";
							}
						}
					}
				}
			echo "</section>
			</main>

			<footer>
				<p>Nachrichten vom ";
				echo $danasnjiDatum;
				echo " | © stern.de GmbH | Home</p>
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
