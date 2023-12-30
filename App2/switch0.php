<?php

include "config.php";

$id = $_GET["id"];

if(!isset($_SESSION["id"]))
{
		header("Location:./index.html");
}

$req = $db->prepare("update agenda_comptable set active=0 where id=?");
$req->execute([$id]);

$errors = $req->errorinfo();
if(intval($errors[1]) > 0)
{
		die("<b style='color:red'>".$errors[2]."</b>");
}

header("Location:./list.php");
