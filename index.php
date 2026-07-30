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
    <a href="criar.php">Criar</a>
    <h1>Agenda de Contatos</h1>
    <hr>
    <div>
        <h3>Formulário de pesquisa</h3>
        <form action="">
            <input id="nome" placeholder="Insira um nome...">
            <input id="telefone" placeholder="Insira um telefone...">
            <label for="estado">Escolha um estado...</label>
            <select name="estado" id="estado">
                <option value="">Selecione...</option>
                <?php
                $estados = get_estados($conn);
                foreach ($estados as $estado) {
                    echo "<option value='", $estado[0], "'>", $estado[1], "</option>";
                }
                ?>
            </select>
            <label for="cidade">Escolha uma cidade...</label>
            <select name="cidade" id="cidade">
            </select>
            <input id="btn-pesquisar" type="button" value="Pesquisar">
        </form>
    </div>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>
    <script>
        const input_nome = document.getElementById('nome');
        const input_telefone = document.getElementById('telefone');
        const input_estado = document.getElementById('estado');
        const input_cidade = document.getElementById('cidade');

        // Popula a tabela ao carregar a página
        document.addEventListener("DOMContentLoaded", async (event) => {
            let nome = input_nome.value;
            let telefone = input_telefone.value;
            let estado = input_estado.value;
            let cidade = input_cidade.value;

            let contatos = await getContatos(nome, telefone, estado, cidade);
            PopularTabela(contatos);
            getCidades("").then(data => {
                input_cidade.innerHTML = "";
                input_cidade.add(new Option("Selecione...", ""));
                data.forEach(element => {
                    const opcao = new Option(element['nome'], element['id_cidade']);
                    input_cidade.add(opcao);
                });
            });
        });

        // Popula a tabela com os parâmetros da pesquisa
        document.getElementById('btn-pesquisar').addEventListener('click', async (event) => {
            let nome = input_nome.value;
            let telefone = input_telefone.value;
            let estado = input_estado.value;
            let cidade = input_cidade.value;

            let contatos = await getContatos(nome, telefone, estado, cidade);
            PopularTabela(contatos);
        })

        // Popula tabela principal
        function PopularTabela(contatos) {
            let tabela = document.getElementById("table-body");
            tabela.innerHTML = "";
            contatos.forEach(contato => {
                let nova_linha = tabela.insertRow();
                let nome = nova_linha.insertCell(0);
                let telefone = nova_linha.insertCell(1);
                let cidade = nova_linha.insertCell(2);
                let estado = nova_linha.insertCell(3);
                let acoes = nova_linha.insertCell(4);
                nome.textContent = contato.nome;
                telefone.textContent = contato.telefone;
                cidade.textContent = contato.cidade;
                estado.textContent = contato.estado;
                acoes.innerHTML = `
                    <button onclick="editByID(${contato.id_contato})">Editar</button>
                    <button onclick="deleteByID(${contato.id_contato})">Excluir</button>
                `;
            });

        }

        // Retorna os contatos condizentes com a necessidade
        async function getContatos(nome, telefone, estado, cidade) {
            const url = "api/get_contatos.php?nome=" + nome + "&telefone=" + telefone + "&estado=" + estado + "&cidade=" + cidade;
            console.log(url);
            try {
                const resposta = await fetch(url);
                const data = await resposta.json();
                return data;
            } catch (error) {
                console.error('Erro:', error);
                return;
            }
        }

        // Função para editar contato (Vai para outra tela)
        function editByID(id) {
            window.location.href = "editar.php?id=" + id;
        }

        // Função para deletar contato (assíncrona)
        async function deleteByID(id) {
            let confirmacao = confirm("Você deseja realmente deletar esse contato?");
            if (confirmacao) {
                const url = "api/deletar_contato_by_id.php?id=" + id;
                try {
                    const resposta = await fetch(url);
                    const data = await resposta.json();
                    console.log(data.status);
                } catch (error) {
                    console.error('Erro:', error);
                }
                window.location.reload();
            }
        }

        // Renova as opções de cidades de acordo com o estado
        input_estado.addEventListener('change', (event) => {
            let estado_selecionado = event.target.value;
            getCidades(estado_selecionado).then(data => {
                input_cidade.innerHTML = "";
                input_cidade.add(new Option("Selecione...", ""));
                data.forEach(element => {
                    const opcao = new Option(element['nome'], element['id_cidade']);
                    input_cidade.add(opcao);
                });
            });
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