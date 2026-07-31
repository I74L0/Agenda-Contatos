<?php
  require __DIR__ . '/../config/banco.php';

  function set_cidade($conn, $nome, $id_estado) {
    $sql = "INSERT INTO cidades(nome, id_estado) VALUES (?, ?);";
    if ($stmt = $conn->prepare($sql)) {
      try {
        $stmt->bind_param("si", $nome, $id_estado);
        $stmt->execute();
      } catch (Exception $e) {
        echo "Erro: ".$e->getMessage();
      }
    } else {
        echo "Erro: ".$conn->error;
    }
  }
