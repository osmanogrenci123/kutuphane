<?php

$host = 'localhost';
$dbname = 'kutuphane';
$username = 'root';
$password = '';

try{
$pdo = new PDO("mysql:host=$host;$dbname;charset=utf8mb4",$username,$password);
$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   
//echo"BAĞLANTI KURULDU";
} catch(PDOException $e){
    die("VERİ TABANINA BAĞLANILAMADI : ". $e->getMessage());
}
?>