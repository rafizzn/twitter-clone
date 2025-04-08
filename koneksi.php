<?php
$host = '192.168.1.67';
$port = '5432';
$dbname = 'x';
$user = 'postgres';
$password = '1sampai8';

function koneksidb(){
    global $host, $port, $dbname, $user, $password;
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn) {
        echo "Koneksi gagal.";
    } else {
        echo "Koneksi berhasil.";
    }
    return $conn;
}
?>