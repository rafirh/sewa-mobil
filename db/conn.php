<?php

ini_set('display_errors', 1);

$host = "localhost";
$username = "root";
$password = "";
$database = "sewa_mobil";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
  die("Koneksi Gagal: " . $conn->connect_error);
}
