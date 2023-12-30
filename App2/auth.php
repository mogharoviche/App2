<?php
include "config.php";


$user = $_POST["username"] ;
$passe= $_POST["password"] ;


$req = $db->prepare("Select * from users where login=? and passe=?"); 


$req->execute([$user, $passe]);



$errors = $req->errorinfo();
if(intval($errors[1]) > 0)
{
		die("<b style='color:red'>".$errors[2]."</b>");
}
//echo "<pre>";


$userRes = $req->fetch(PDO::FETCH_ASSOC);

if(!isset($userRes["nom"]))
{
	echo "<b style='color:red'>Login ou mot de passe incorrect!</b>";
	die();	
}

$_SESSION = $userRes;

header("Location: ./list.php");