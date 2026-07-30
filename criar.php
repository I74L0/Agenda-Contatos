<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos</title>
    <link rel="stylesheet" href="style.css">
    <?php
    include 'config/funcoes.php';
    ?>
</head>

<body>
    <a href="index.php">Home</a>
    <h1>Agenda de Contatos</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $nome = strip_tags($_POST['nome']);
        $telefone = strip_tags($_POST['telefone']);
        $cidade = strip_tags($_POST['cidade']);
        $estado = strip_tags($_POST['estado']);

        set_contatos($conn, $nome, $telefone, $cidade, $estado);

        header("Location: index.php");
        exit();
    }
    ?>
    <hr>
    <div>
        <h3>Formulário de criação</h3>
        <form id="criar" action="" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" placeholder="Nome" name="nome" required><br><br>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" placeholder="(99) 99999-9999" required><br><br>
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="" hidden>Selecione...</option>
                <?php
                    $estados = get_estados($conn);
                    foreach ($estados as $estado) {
                        echo "<option value='", $estado[0], "'>", $estado[1], "</option>";
                    }
                ?>
            </select><br><br>
            <label for="cidade">Cidade:</label>
            <select name="cidade" id="cidade" disabled required>
                <option value="">Selecione...</option>
            </select><br><br>
            <input type="submit" value="Salvar">
        </form>
    </div>
    <script>
        const input_nome = document.getElementById('nome');
        const input_telefone = document.getElementById('telefone');
        const input_estado = document.getElementById('estado');
        const input_cidade = document.getElementById('cidade');

        // Popula a tabela ao carregar a página
        document.addEventListener("DOMContentLoaded", async (event) => {
            getCidades("").then(data => {
                input_cidade.innerHTML = "";
                input_cidade.add(new Option("Selecione...", ""));
                data.forEach(element => {
                    const opcao = new Option(element['nome'], element['id_cidade']);
                    input_cidade.add(opcao);
                });
            });
        });

        // Aplica máscara no campo de telefone
        const telefone_input = document.getElementById('telefone');
        telefone_input.addEventListener('input', (e) => {
            let i = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);

            e.target.value = !i[2] ? i[1] : `(${i[1]}) ${i[2]}` + (i[3] ? `-${i[3]}` : '');
        });

        // Renova as opções de cidades de acordo com o estado
        const estado = document.getElementById('estado');
        estado.addEventListener('change', (event) => {
            let estado_selecionado = event.target.value;
            const cidade = document.getElementById('cidade');
            if (estado_selecionado != "") {
                cidade.disabled = false;
                getCidades(estado_selecionado).then(data => {
                    cidade.innerHTML = "";
                    data.forEach(element => {
                        const opcao = new Option(element['nome'], element['id_cidade']);
                        cidade.add(opcao);
                    });
                });
            } else {
                cidade.disabled = true;
            }
        });

        // Retorna as cidades pertencentes à um estado
        async function getCidades(estado) {
            const url = "api/get_cidades.php?id_estado=" + estado;
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