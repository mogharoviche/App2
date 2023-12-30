<?php
include "config.php";

if(!isset($_SESSION["id"]))
{
		header("Location:index.html");
}		

$nom_alerte = $_POST["nom_alerte"];
$rasion_sociale = $_POST["rasion_sociale"];
$date_alerte = $_POST["date_alerte"];

$req = $db->prepare("insert into agenda_comptable(fk_user, nom_alerte, rasion_sociale, date_alerte) values( ?, ?, ?, ? )"); 

$req->execute([$_SESSION["id"], $nom_alerte, $rasion_sociale, $date_alerte]);


$errors = $req->errorinfo();


if(intval($errors[1]) > 0)
{
		die("<b style='color:red'>".$errors[2]."</b>");
}

header("Location: ./list.php");