<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'config/db.php';
require 'src/Controllers/AdminNewsController.php';

session_start();
$_SESSION['role'] = 'admin';
$_SESSION['user_id'] = 1;

$c = new AdminNewsController();
$c->index();
