<?php
include "config.php";
if(!isset($_SESSION["id"]))
{
		header("Location:index.html");
}		

$id = $_POST["id"];
$rasion_sociale = $_POST["rasion_sociale"];
$nom_alerte = $_POST["nom_alerte"];
$date_alerte =$_POST["date_alerte"];
$active = isset($_POST["active"]) ? 1 : 0;


$req = $db->prepare("Update agenda_comptable set rasion_sociale=? , nom_alerte=? , date_alerte=?,active=? where id=?"); 

$req->execute([$rasion_sociale, $nom_alerte, $date_alerte,$active, $id]);


$errors = $req->errorinfo();
if(intval($errors[1]) > 0)
{
		die("<b style='color:red'>".$errors[2]."</b>");
}

die("
<center>
		<b style='color:green'>L'Alert' à été modifié avec succès :) </b>
</center>
<script>

setTimeout(function(){
		document.location.href = './list.php';
}, 2000);


</script>
");