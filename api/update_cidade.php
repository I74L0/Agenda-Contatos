<?php
  require __DIR__ . '/../config/banco.php';

  function update_cidade($conn, $id, $nome, $estado) {
    $sql = "UPDATE cidades
    SET nome=?,
    id_estado=?
    WHERE id_cidade=?;";
    if ($stmt = $conn->prepare($sql)) {
      try {
        $stmt->bind_param("sii", $nome, $estado, $id);
        $stmt->execute();
      } catch (Exception $e) {
        echo "Erro: ".$e->getMessage();
      }
    } else {
      echo "Erro: ".$conn->error;
    }
  }
