<?php
  require 'banco.php';

  function get_estados($conn) {
    $sql = "SELECT * FROM estados;";
    $query = $conn->query($sql);
    $estados = [];
    if ($query) {
      foreach ($query as $linha) {
        $estados[$linha['id_estado']] = [$linha['id_estado'], $linha['nome'], $linha['uf']];
      }
    }
    return $estados;
  }

  function get_estado_by_id($conn, $id) {
    $sql = "SELECT * FROM estados WHERE id_estado=$id;";
    $query = $conn->query($sql);
    if ($query) {
      return $query->fetch_assoc();
    }
    return null;
  }

  function get_cidades($conn) {
    $sql = "SELECT * FROM cidades;";
    $query = $conn->query($sql);
    $cidades = [];
    if ($query) {
      foreach ($query as $linha) {
        $cidades[$linha['id_cidade']] = [$linha['id_cidade'], $linha['nome'], $linha['id_estado']];
      }
    }
    return $cidades;
  }

  function get_contato_by_id($conn, $id) {
    $sql = "SELECT
    id_contato,
    contatos.nome,
    telefone,
    contatos.id_cidade,
    contatos.id_estado,
    cidades.nome AS cidade,
    estados.nome AS estado
    FROM contatos
    INNER JOIN cidades
    ON contatos.id_cidade = cidades.id_cidade
    INNER JOIN estados
    ON contatos.id_estado = estados.id_estado
    WHERE id_contato=$id;";
    $query = $conn->query($sql);
    if ($query) {
      return $query->fetch_assoc();
    }
    return null;
  }

  function set_contatos($conn, $nome, $telefone, $cidade, $estado) {
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

  function update_contato_by_id($conn, $id, $nome, $telefone, $cidade, $estado) {
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