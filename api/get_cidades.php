<?php
  require '../config/banco.php';

  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $sql = "SELECT * FROM cidades";
    $valores = [];
    if (!empty($_GET['id_estado'])) {
      $sql .= " WHERE id_estado = ?";
      $valores[] = $_GET['id_estado'];
    }
    $sql .= " ORDER BY nome;";
    
    if ($stmt = $conn->prepare($sql)) {
      try {
        $stmt->execute($valores);
        $resultado = $stmt->get_result();
        $resultados = $resultado->fetch_all(MYSQLI_ASSOC);
        echo json_encode($resultados);
      } catch (Exception $e) {
          http_response_code(500);
          echo json_encode(["erro" => $e->getMessage()]);
      }    
    }
  }