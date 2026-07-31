<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos - Criar Cidade</title>
    <link rel="stylesheet" href="style.css">
    <?php
    include 'api/set_cidade.php';
    ?>
</head>

<body>
    <a href="index.php">Home</a>
    <h1>Agenda de Contatos</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $nome = strip_tags($_POST['nome']);
        $estado = strip_tags($_POST['estado']);

        if (empty($nome) || empty($estado)) {
            die("Erro: Todos os campos são obrigatórios!");
        }

        set_cidade($conn, $nome, $estado);

        $_SESSION['mensagem'] = "Cidade criada com sucesso!";
        header("Location: index.php");
        exit();
    }
    ?>
    <hr>
    <div>
        <h3>Formulário de criação de cidade</h3>
        <form id="criar_cidade" action="" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" placeholder="Nome" name="nome" id="nome" required><br><br>
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="" hidden>Selecione...</option>
            </select><br><br>
            <input type="submit" value="Salvar">
        </form>
    </div>
    <script>
        const input_estado = document.getElementById('estado');

        // Popula os selects ao carregar a página
        document.addEventListener("DOMContentLoaded", async (event) => {
            getEstados().then(data => {
                data.forEach(element => {
                    let opcao = new Option(element['nome'], element['id_estado']);
                    input_estado.add(opcao);
                });
            });
        });

        // Retorna os estados
        async function getEstados() {
            const url = "api/get_estados.php";
            try {
                const resposta = await fetch(url);
                if (!resposta.ok) {
                    throw new Error(`Erro Status: ${resposta.status}`);
                }
                const data = await resposta.json();
                return data;
            } catch (error) {
                console.error('Erro:', error);
            }
        }
    </script>
</body>

</html>
