<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos - Editar Cidade</title>
    <link rel="stylesheet" href="style.css">
    <?php
    include 'api/update_cidade.php';
    ?>
</head>

<body>
    <a href="cidades.php">Voltar para Cidades</a> | <a href="index.php">Home</a>
    <h1>Agenda de Contatos</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id = strip_tags($_POST['id']);
        $nome = strip_tags($_POST['nome']);
        $estado = strip_tags($_POST['estado']);

        if (empty($id) || empty($nome) || empty($estado)) {
            die("Erro: Todos os campos são obrigatórios!");
        }

        update_cidade($conn, $id, $nome, $estado);

        $_SESSION['mensagem'] = "Cidade atualizada com sucesso!";
        header("Location: cidades.php");
        exit();
    }
    ?>
    <hr>
    <div>
        <h3>Formulário de edição de cidade</h3>
        <form id="criar" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" placeholder="Nome da cidade" name="nome" required><br><br>
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="" hidden>Selecione...</option>
            </select><br><br>
            <input type="submit" value="Salvar">
        </form>
    </div>
    <script>
        const input_nome = document.getElementById('nome');
        const input_estado = document.getElementById('estado');
        const parametro_url = new URLSearchParams(window.location.search);

        // Popula os campos ao carregar a página
        document.addEventListener("DOMContentLoaded", async (event) => {
            let cidade = await getCidadeById(parametro_url.get('id'));
            if (cidade && cidade.length > 0) {
                getEstados().then(data => {
                    data.forEach(element => {
                        let opcao;
                        if (cidade[0].id_estado == element.id_estado) {
                            opcao = new Option(element.nome, element.id_estado, true, true);
                        } else {
                            opcao = new Option(element.nome, element.id_estado);
                        }
                        input_estado.add(opcao);
                    });
                });
                input_nome.value = cidade[0].nome;
            }
        });

        // Retorna a cidade pelo id
        async function getCidadeById(id) {
            const url = "api/get_cidades.php?id_cidade=" + id;
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
