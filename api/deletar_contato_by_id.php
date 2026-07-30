<?php
  require '../config/banco.php';

  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id_contato = $_GET['id'];
    $sql = "DELETE FROM contatos WHERE id_contato=?;";
    if ($stmt = $conn->prepare($sql)) {
      try {
        $stmt->bind_param("i", $id_contato);
        $stmt->execute();
        echo json_encode(["status" => "Contato deletado com sucesso!"]);
      } catch (Exception $e) {
          http_response_code(500);
          echo json_encode(["erro" => $e->getMessage()]);
      }    
    }
  }