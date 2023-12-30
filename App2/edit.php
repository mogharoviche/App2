<?php
include "config.php";

if(!isset($_SESSION["id"]))
{
		header("Location:index.html");
}		

$id = $_GET["id"];

$req = $db->prepare("Select * from agenda_comptable where id=?"); 

$req->execute([$id]);


$errors = $req->errorinfo();
if(intval($errors[1]) > 0)
{
		die("<b style='color:red'>".$errors[2]."</b>");
}
/*
						["rasion_sociale"]
						["nom_alerte"]
						["date_alerte"]*/

$agenda_comptable = $req->fetch(PDO::FETCH_ASSOC);

if(!isset($agenda_comptable["rasion_sociale"]))
{
	echo "<b style='color:red'>Alert introuvable!</b>";
	die();	
}
?>
<style> 
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}</style>
<!DOCTYPE html>
<html>
<head>
	<title>Modification</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container my-5">
	<div class="container">
		<h2 class="text-center">Modification <?php echo strtoupper($agenda_comptable["rasion_sociale"]); ?></h2>
		<form action="modifier.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $agenda_comptable["id"]; ?>"/>
			<div class="form-group">
				<label for="nom">rasion_sociale:</label>
				<input type="text" class="form-control" id="rasion_sociale" name="rasion_sociale" value="<?php echo $agenda_comptable["rasion_sociale"]; ?>" required>
			</div>
			<div class="form-group">
				<label for="categorie">nom_alerte:</label>
				<input type="text" class="form-control" id="nom_alerte" name="nom_alerte" value="<?php echo $agenda_comptable["nom_alerte"]; ?>" required>
			</div>
			<div class="form-group">
				<label for="poids">date_alerte:</label>
				<input type="text" class="form-control" id="date_alerte" name="date_alerte" value="<?php echo $agenda_comptable["date_alerte"]; ?>" required>
			</div>
				<div class="form-group">
    <label for="active">Status Active:</label>
    <label class="switch">
        <input type="checkbox" id="active" name="active" <?php echo $agenda_comptable["active"] == 1 ? 'checked' : ''; ?>>
        <span class="slider"></span>
    </label>
</div>

			<button type="submit" class="btn btn-primary">Modifier</button>
		</form>
	</div>
	</body>		
</html>