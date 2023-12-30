<?php
include "config.php";

if(!isset($_SESSION["id"]))
{
		header("Location:index.html");
}	
?><!DOCTYPE html>
<html>
	<head>
		<title>Création</title>
		<!-- Ajout des fichiers CSS de Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	</head>
	<body class="container my-5">
		<div class="container">
			<div class="text-left">
				<h1>Bonjour : <?php echo $_SESSION["nom"]. " ". $_SESSION["prenom"]; ?></h1>
				<h2 class="text-center">Nouvelle Alert</h2>
			</div>
			<form action="insert.php" method="POST">
				<div class="form-group">
					<label for="rasion_sociale">rasion_sociale</label>
					<input type="text" name="rasion_sociale" id="rasion_sociale" class="form-control" value=""/>
				</div>
				<div class="form-group">
					<label for="nom_alerte">nom_alerte</label>
					<input type="text" name="nom_alerte" id="nom_alerte" class="form-control" value=""/>
				</div>
				<div class="form-group">
					<label for="date_alerte">date_alerte</label>
					<input type="date" name="date_alerte" id="date_alerte" class="form-control" value=""/>
				</div>
				<div class="text-center">
					<input type="submit" value="Nouveau" class="btn btn-primary"/>
				</div>
			</form>	
		</div>
		
	</body>		
</html>