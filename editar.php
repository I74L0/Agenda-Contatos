<?php session_start(); ?>

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
    $contato = "";
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $id_contato = $_GET['id'];
        $contato = get_contato_by_id($conn, $id_contato);
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id = strip_tags($_POST['id']);
        $nome = strip_tags($_POST['nome']);
        $telefone = strip_tags($_POST['telefone']);
        $cidade = strip_tags($_POST['cidade']);
        $estado = strip_tags($_POST['estado']);

        if (empty($nome) || empty($telefone) || empty($estado) || empty($cidade)) {
            die("Erro: Todos os campos são obrigatórios!");
        }

        update_contato_by_id($conn, $id, $nome, $telefone, $cidade, $estado);

        $_SESSION['mensagem'] = "Contato atualizado com sucesso!";
        header("Location: index.php");
        exit();
    }
    ?>
    <hr>
    <div>
        <h3>Formulário de edição</h3>
        <form id="criar" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" placeholder="Nome" name="nome" required><br><br>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" placeholder="(99) 99999-9999" required><br><br>
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="" hidden>Selecione...</option>
            </select><br><br>
            <label for="cidade">Cidade:</label>
            <select name="cidade" id="cidade" required>
                <option value="" hidden>Selecione...</option>
            </select><br><br>
            <input type="submit" value="Salvar">
        </form>
    </div>
    <script>
        const input_nome = document.getElementById('nome');
        const input_telefone = document.getElementById('telefone');
        const input_estado = document.getElementById('estado');
        const input_cidade = document.getElementById('cidade');
        const parametro_url = new URLSearchParams(window.location.search);

        // Popula os campos ao carregar a página
        document.addEventListener("DOMContentLoaded", async (event) => {
            let contato = await getContatoById(parametro_url.get('id'));
            getEstados().then(data => {
                data.forEach(element => {
                    let opcao;
                    if (contato[0].id_estado == element.id_estado) {
                        opcao = new Option(element.nome, element.id_estado, true, true);
                    } else {
                        opcao = new Option(element.nome, element.id_estado);
                    }
                    input_estado.add(opcao);
                });
            });
            getCidades(contato[0].id_estado).then(data => {
                data.forEach(cidade => {
                    console.log(cidade.id_cidade);
                    console.log(contato[0].id_cidade);
                    let opcao;
                    if (contato[0].id_cidade == cidade.id_cidade) {
                        opcao = new Option(cidade.nome, cidade.id_cidade, true, true);
                    } else {
                        opcao = new Option(cidade.nome, cidade.id_cidade);
                    }
                    input_cidade.add(opcao);
                })
            });
            input_nome.value = contato[0].nome;
            input_telefone.value = contato[0].telefone;
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
            if (estado_selecionado != "") {
                AtualizarCidades(estado_selecionado);
            } else {
                document.getElementById('cidade').disabled = true;
            }
        });

        // Popula as cidades com base no estado
        function AtualizarCidades(estado_selecionado) {
            const cidade = document.getElementById('cidade');
            cidade.disabled = false;
            getCidades(estado_selecionado).then(data => {
                cidade.innerHTML = "";
                data.forEach(element => {
                    const opcao = new Option(element['nome'], element['id_cidade']);
                    cidade.add(opcao);
                });
            });
        }

        // Retorna o contato pelo id
        async function getContatoById(id) {
            const url = "api/get_contatos.php?id_contato=" + id;
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