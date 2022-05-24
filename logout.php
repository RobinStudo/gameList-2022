<?php
require_once './components/data.php';

logout();
addFlash('success', 'Vous êtes bien déconnecté');
header('Location: index.php');
die();
