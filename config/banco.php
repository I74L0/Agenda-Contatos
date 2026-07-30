<?php
$host = 'localhost';
$dbname = 'agenda_contatos';
$username = 'root';
$password = 'root123';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}
