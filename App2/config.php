<?php
$host = "localhost"; // 127.0.0.1
$dbname = "ensa";
$userdb = "ensa";
$passedb = 'ensa951753190$ENSA';

$db = new PDO("mysql:host=".$host.";dbname=".$dbname, $userdb, $passedb);

session_set_cookie_params(60 * 30);
session_start();