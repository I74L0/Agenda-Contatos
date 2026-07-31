<?php
  require __DIR__ . '/../config/banco.php';

  function set_contato($conn, $nome, $telefone, $cidade, $estado) {
    $sql = "INSERT INTO contatos(nome, telefone, id_cidade, id_estado) VALUES (?, ?, ?, ?);";
    if ($stmt = $conn->prepare($sql)) {
      try {
        $stmt->bind_param("ssii", $nome, $telefone, $cidade, $estado);
        $stmt->execute();
      } catch (Exception $e) {
        echo "Erro: ".$e->getMessage();
      }
    } else {
        echo "Erro: ".$conn->error;
    }
  }