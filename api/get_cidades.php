<?php
  require '../config/banco.php';

  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $sql = "SELECT
    cidades.id_cidade,
    cidades.nome,
    cidades.id_estado,
    estados.nome AS estado,
    estados.uf AS uf
    FROM cidades
    INNER JOIN estados
    ON cidades.id_estado = estados.id_estado
    WHERE 1=1";

    $valores = [];

    if (!empty($_GET['id_cidade'])) {
      $sql .= " AND cidades.id_cidade = ?";
      $valores[] = $_GET['id_cidade'];
    }
    if (!empty($_GET['id_estado'])) {
      $sql .= " AND cidades.id_estado = ?";
      $valores[] = $_GET['id_estado'];
    }
    if (!empty($_GET['nome'])) {
      $sql .= " AND cidades.nome LIKE ?";
      $valores[] = "%".$_GET['nome']."%";
    }
    if (!empty($_GET['estado'])) {
      $sql .= " AND estados.nome LIKE ?";
      $valores[] = "%".$_GET['estado']."%";
    }
    $sql .= " ORDER BY cidades.nome;";
    
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