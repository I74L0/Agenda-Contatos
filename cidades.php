<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contatos - Cidades</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <a href="index.php">Home</a> | <a href="criar_cidade.php">Criar Cidade</a><br>
    <h1>Agenda de Contatos</h1>
    <hr>
    <div>
        <h3>Formulário de pesquisa de cidades</h3>
        <form action="">
            <input id="nome" placeholder="Insira um nome de cidade...">
            <label for="estado">Escolha um estado...</label>
            <input id="estado" placeholder="Insira um estado...">
            <input id="btn-pesquisar" type="button" value="Pesquisar">
        </form>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <?php
    if (isset($_SESSION['mensagem'])) {
        echo '<div class="mensagem">' . $_SESSION['mensagem'] . '</div>';
        unset($_SESSION['mensagem']);
    }
    ?>
    <script>
        const input_nome = document.getElementById('nome');
        const input_estado = document.getElementById('estado');

        // Popula a tabela ao carregar a página
        document.addEventListener("DOMContentLoaded", async (event) => {
            let nome = input_nome.value;
            let estado = input_estado.value;

            let cidades = await getCidades(nome, estado);
            PopularTabela(cidades);
        });

        // Popula a tabela com os parâmetros da pesquisa
        document.getElementById('btn-pesquisar').addEventListener('click', async (event) => {
            let nome = input_nome.value;
            let estado = input_estado.value;

            let cidades = await getCidades(nome, estado);
            PopularTabela(cidades);
        });

        // Popula tabela principal de cidades
        function PopularTabela(cidades) {
            let tabela = document.getElementById("table-body");
            tabela.innerHTML = "";
            if (cidades && Array.isArray(cidades)) {
                cidades.forEach(cidade => {
                    let nova_linha = tabela.insertRow();
                    let nome = nova_linha.insertCell(0);
                    let estado = nova_linha.insertCell(1);
                    let acoes = nova_linha.insertCell(2);
                    nome.textContent = cidade.nome;
                    estado.textContent = cidade.estado;
                    acoes.innerHTML = `
                        <button onclick="editByID(${cidade.id_cidade})">Editar</button>
                    `;
                });
            }
        }

        // Retorna as cidades condizentes com a pesquisa
        async function getCidades(nome, estado) {
            const url = "api/get_cidades.php?nome=" + encodeURIComponent(nome) + "&estado=" + encodeURIComponent(estado);
            try {
                const resposta = await fetch(url);
                const data = await resposta.json();
                return data;
            } catch (error) {
                console.error('Erro:', error);
                return [];
            }
        }

        // Função para editar cidade (Vai para tela de edição de cidade)
        function editByID(id) {
            window.location.href = "editar_cidade.php?id=" + id;
        }
    </script>
</body>

</html>
