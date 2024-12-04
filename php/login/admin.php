<?php
// Se o usuário estiver logado, exibe a página de boas-vindas
include './testa_sessaoAdmin.php';
echo "A session ID é: " . strtoupper(session_id());
echo "<br> Seja bem vindo: -> " . $_SESSION['nome'];
?>
<!DOCTYPE html>
<html>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Painel de Controle</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            padding: 20px;
        }

        h1 {
            margin-bottom: 30px;
        }
    </style>





</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="./index.html">index</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./teste.html">Teste</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./painel.html">Painel</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="logout.php">Sair</a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
























        <div class="container">
            <h1 class="text-center">Gerenciar Veiculos</h1>


            <form id="veiculoForm">
                <input type="hidden" id="id_veiculo" name="id_veiculo">

                <div class="mb-3">
                    <label for="id_categoria" class="form-label">Categoria:</label>
                    <select id="id_categoria" name="id_categoria" class="form-select" required>
                        <option value="" disabled selected>Escolha uma categoria</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ano_modelo" class="form-label">Ano Modelo:</label>
                    <input type="date" id="ano_modelo" name="ano_modelo" class="form-control" min="1950-01-01" required>
                </div>

                <div class="mb-3">
                    <label for="nome_veiculo" class="form-label">Nome Veiculo:</label>
                    <input type="text" id="nome_veiculo" name="nome_veiculo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="placa_veiculo" class="form-label">Placa Veiculo:</label>
                    <input type="text" id="placa_veiculo" name="placa_veiculo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="media_veiculo" class="form-label">media veiculo:</label>
                    <input type="text" id="media_veiculo" name="media_veiculo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>


            <table id="tabelaVeiculos" class="table table-hover mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Categoria</th>
                        <th>Ano Modelo</th>
                        <th>Nome Veiculo</th>
                        <th>Placa Veiculo</th>
                        <th>Media veiculo</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Veiculos serão inseridos aqui via AJAX -->
                </tbody>
            </table>
        </div>



        <div class="row">
            <div class="col-md-6">

                <h1>Listagem de Tabelas do Banco de Dados</h1>
                <!-- <button id="loadTables">Carregar Tabelas</button> -->
                <ul id="tablesList"></ul>
            </div>h3. Lorem ipsum dolor sit amet.
        </div>


        <script>
            $(document).ready(function() {
                carregarCategorias();
                carregarVeiculos();
                //     carregarMotoristas();

                // Função para carregar categorias no select
                function carregarCategorias() {
                    $.ajax({
                        url: 'php/categorias.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(categorias) {
                            categorias.forEach(function(categoria) {
                                $('#id_categoria').append(new Option(categoria.nome_categoria, categoria.id_categoria));
                            });
                        }
                    });
                }
                $('#veiculoForm').on('submit', function(e) {
                    e.preventDefault();
                    let dados = $(this).serialize();
                    $.ajax({
                        url: 'php/salvarveiculo.php',
                        method: 'POST',
                        data: dados,
                        success: function(response) {
                            console.log("Foi");
                            carregarVeiculos();
                            $('#veiculoForm')[0].reset(); // Limpar o formulário
                        },
                        error: function(response) {
                            console.log(response);
                        }

                    });
                });

                function carregarVeiculos() {
                    $.ajax({
                        url: 'php/veiculos.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(veiculos) {
                            let linhas = '';
                            veiculos.forEach(function(veiculo) {
                                linhas += `<tr>
                                <td>${veiculo.id_veiculo}</td>
                                <td>${veiculo.nome_categoria}</td>
                                <td>${veiculo.ano_modelo}</td>
                                <td>${veiculo.nome_veiculo}</td>
                                <td>${veiculo.placa_veiculo}</td>
                                 <td>${veiculo.media_veiculo}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1" onclick="editarVeiculo(${veiculo.id_veiculo})">Editar</button>
                                    <button class="btn btn-sm btn-danger" onclick="deletarVeiculo(${veiculo.id_veiculo})">Deletar</button>
                                </td>
                            </tr>`;
                            });
                            $('#tabelaVeiculos tbody').html(linhas);
                        }
                    });
                }







            });

            function editarVeiculo(id_veiculo) {
                $.ajax({
                    url: 'get_veiculo.php',
                    method: 'GET',
                    data: {
                        id_veiculo: id_veiculo
                    },
                    dataType: 'json',
                    success: function(veiculo) {
                        $('#id_veiculo').val(veiculo.id_veiculo);
                        $('#id_categoria').val(veiculo.id_categoria);
                        $('#ano_modelo').val(veiculo.ano_modelo);
                        $('#nome_veiculo').val(veiculo.nome_veiculo);
                        $('#placa_veiculo').val(veiculo.placa_veiculo);
                        $('#media_veiculo').val(veiculo.media_veiculo);
                    }
                });
            }




            function deletarVeiculo(id_veiculo) {
                if (confirm("Tem certeza que deseja deletar este Veiculo?")) {
                    $.ajax({
                        url: 'deletar_veiculo.php',
                        method: 'POST',
                        data: {
                            id_veiculo: id_veiculo
                        },
                        success: function(response) {
                            console.log('delete');
                            carregarVeiculos();

                        }
                    });
                }
            }
        </script>

















        <script>
            $(document).ready(function() {
                function carregartables() {
                    //  $('#loadTables').on('click', function () {
                    $.ajax({
                        url: 'php/php2.php',
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            setTimeout(function() {
                                carregartables()
                            }, 10000)

                            $('#tablesList').empty();

                            if (response.error) {
                                $('#tablesList').append('<li>' + response.error + '</li>');
                            } else {
                                $.each(response, function(index, table) {
                                    $('#tablesList').append('<li>' + table + '</li>');
                                });
                            }
                        },
                        error: function() {
                            alert('Erro ao buscar as tabelas.');
                        }
                    });
                    //   });


                    console.log('teste 10 segundos');
                }
                carregartables();




            });
        </script>


        <div class="row d-flex ">
            <div class="col-md-12    ">
                <h3>

                    Confira mais projetos By <a href="https://redminton.github.io"> redminton.cloud!
                    </a>
                </h3>
            </div>
        </div>
    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>