<?php
require_once './components/functions.php';

session_start();
$db = new PDO('mysql:dbname=game_list;host=localhost', 'root');
$connectedUser = reloadUserFormDatabase();
