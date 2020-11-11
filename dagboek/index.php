<?php 
include __DIR__ ."/src/autoload.php";

$database = new database();

session_start();
//if the error has information display the info
$ERROR_LOGIN = (isset($_SESSION['ERROR_LOGIN'])) ? "display: block" : "";
$ERROR_SIGNUP = (isset($_SESSION['ERROR_SIGNUP'])) ? "display: block" : "";

?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<title>MijnDagboek.nl | Maak je eigen dagboek vandaag!</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" integrity>
	<link rel="stylesheet" type="text/css" href="css/diaryStyle.css" integrity>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js" integrity></script>
	<meta charset="utf-8">
	<meta name="description" content="Vindt jij het ook vervelend als je iedere keer dagboek niet bij je heb of niet kan vinden? Op deze website kan online dagboek bijhouden. Deze kan op iedere apparaat geopend worden die over internet bezit. Geen verveldende broertje of zusjes die je dagboek kunnen lezen door de goede beveiling van de website.">
	<meta name="keywords" content="Dagboek, diary">
	<meta name="author" content="Tyno schrama">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<header class="bg-flatgreen col py-1">
		<h5 class="float-left ml-2 mt-2">MijnDagboek</h5>
		<ul class="nav justify-content-end">
			<li class="nav-item">
				<a class="nav-link text-dark btn btn-light mr-2" id="btn-signin" href="#">Inloggen</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-dark btn btn-light btn-signup" href="#">Registreren</a>
			</li>
	    </ul>
	</header>
	<content class="">
		<div class="eclipse" id="eclipse" style="<?php echo $ERROR_LOGIN . $ERROR_SIGNUP; ?>">
			<form class="p-2 form-signin" id="form-signin" action="forms/login_form.php" method="POST" style="<?php echo $ERROR_LOGIN; ?>">
				<h5 class="text-center">Inloggen</h5>
				<?php 
				if ($ERROR_LOGIN) { ?>
					<div class="alert alert-danger" role="alert">
  					<?php echo $_SESSION['ERROR_LOGIN']; ?>
					</div>
				<?php } ?>
				<div class="form-group">
					<label for="InputEmail1">E-mailadres:</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="InputPassword1">Wachtwoord:</label>
					<input type="password" name="password" class="form-control">
				</div>
				<button type="submit" class="btn btn-info">Inloggen</button>
			</form>
			<form class="p-2 form-signup" id="form-signup" action="forms/signUp_form.php" method="POST" style="<?php echo $ERROR_SIGNUP; ?>">
				<h5 class="text-center">Registreren</h5>
				<?php 
				if ($ERROR_SIGNUP) { ?>
					<div class="alert alert-danger" role="alert">
  					<?php echo $_SESSION['ERROR_SIGNUP']; ?>
					</div>
				<?php } ?>
				<div class="form-group form-row">
					<div class="col">
						<label>Voornaam:</label>
						<input type="text" name="firstname" class="form-control">
					</div>
					<div class="col">
						<label>Tussenvoegsel:</label>
						<input type="text" name="insertion" class="form-control">
					</div>
					<div class="col">
						<label>Achternaam:</label>
						<input type="text" name="Lastname" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label>E-mailadres:</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label>Wachtwoord:</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label>Herhaal Wachtwoord:</label>
					<input type="password" name="passwordrepeat" class="form-control">
				</div>
				<button type="submit" class="btn btn-info">Registeren</button>
			</form>
		</div>
		<!-- Start content -->
		<div class="banner">
			<div class="container">
				<div class="col welkom">
						<h1 class="text-center display-4">MijnDagboek</h1>
						<div class="text-center">
							<p class="lead">Maak nu een account aan</p>
							<button class="font-weight-bold btn btn-outline-success btn-lg btn-signup">Start nu</button>
						</div>
				</div>
			</div>
		</div>
		<div class="w-100 bg-dark">
			<div class="w-75 mx-auto py-2">
				<div class="row row-cols-3">
					<div class="col-md-4">
						<div class="card" style="min-height: 200px;">
							<div class="card-body">
								<h5 class="card-title text-center">Veiligheid</h5>
								<p class="card-text">Niemand kan jouw dagboeken lezen zolang zij niet de inlog gegevens hebben. </p>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card" style="min-height: 200px;">
							<div class="card-body">
								<h5 class="card-title text-center">Verhalen</h5>
								<p class="card-text">Je kan verschillende dagboeken aanmaken om verschillende verhalen op te slaan.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card" style="min-height: 200px;">
							<div class="card-body">
								<h5 class="card-title text-center">Toegankelijk</h5>
								<p class="card-text">Als je niet thuis bent en toegang tot het internet dan kan je nog steeds bij je dagboeken en er eventuelen verhalen aan toevoegen</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</content>
	<footer class="w-100 bg-flatgreen" style="height: 100px;">
		<div class="container">
			<div class="row">
				<div class="col mt-4">
					<small>Copyright © 2020 | Mijndagboek.nl</small>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/diary_js.js"></script>
		<?php 
		//Empty Error
		unset($_SESSION['ERROR_LOGIN']);
		unset($_SESSION['ERROR_SIGNUP']);
		?>
	</footer>
</body>
</html>