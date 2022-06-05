<?php
if (!isset($_SESSION)) session_start();

require_once 'rb.php';

$conectar = R::setup('mysql:host=localhost;dbname=unacon','root','');

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Belem');