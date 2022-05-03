<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lista_de_dados";
$port = 3306;

try {
  // Conexão com o banco de dados
  $conn = new PDO(
    "mysql:host=$host;port=$port;dbname=" . $dbname,
    $user,
    $pass
  );

  // echo "Conexão com o banco de dados realizada com sucesso";
} catch (PDOException $err) {
  echo "Erro: Conexão com o banco não realizada! " . $err->getMessage();
}
