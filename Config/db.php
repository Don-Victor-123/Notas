<?php
// config/db.php
$host = '127.0.0.1';
$db   = 'tu_app';
$user = 'root';      // XAMPP default
$pass = '';
$opts = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ];
$pdo  = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,$opts);
