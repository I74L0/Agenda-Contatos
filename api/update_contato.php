<?php
  require __DIR__ . '/../config/banco.php';

  function update_contato($conn, $id, $nome, $telefone, $cidade, $estado) {
    $sql = "UPDATE contatos
    SET nome=?,
    telefone=?,
    id_cidade=?,
    id_estado=?
    WHERE id_contato=?;";
    if ($stmt = $conn->prepare($sql)) {
      try {
        $stmt->bind_param("ssiii", $nome, $telefone, $cidade, $estado, $id);
        $stmt->execute();
      } catch (Exception $e) {
        echo "Erro: ".$e->getMessage();
      }
    } else {
      echo "Erro: ".$conn->error;
    }
  }