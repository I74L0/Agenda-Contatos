<?php
  require '../config/banco.php';

  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $sql = "SELECT
    id_contato,
    contatos.nome,
    telefone,
    cidades.nome AS cidade,
    estados.nome AS estado
    FROM contatos
    INNER JOIN cidades
    ON contatos.id_cidade = cidades.id_cidade
    INNER JOIN estados
    ON contatos.id_estado = estados.id_estado
    WHERE 1=1";

    $valores = [];

    if (!empty($_GET['id_contato'])) {
      $sql .= " AND contatos.id_contato = ?";
      $valores[] = $_GET['id_contato'];
    }
    if (!empty($_GET['nome'])) {
      $sql .= " AND contatos.nome LIKE ?";
      $valores[] = "%".$_GET['nome']."%";
    }
    if (!empty($_GET['telefone'])) {
      $sql .= " AND contatos.telefone LIKE ?";
      $valores[] = "%".$_GET['telefone']."%";
    }
    if (!empty($_GET['estado'])) {
      $sql .= " AND estados.nome LIKE ?";
      $valores[] = "%".$_GET['estado']."%";
    }
    if (!empty($_GET['cidade'])) {
      $sql .= " AND cidades.nome LIKE ?";
      $valores[] = "%".$_GET['cidade']."%";
    }
    
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