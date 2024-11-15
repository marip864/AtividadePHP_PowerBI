<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consulta de Atividades</title>
        <style>

            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                box-sizing: border-box;
            }

            .container {
                width: 100%;
                max-width: 1000px;
                padding: 20px;
                margin-top: 20px;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                box-sizing: border-box;
            }

            h2 {
                text-align: center;
                color: #333;
                margin-bottom: 20px;
            }

            .table-wrapper {
                width: 100%;
                overflow-x: auto; 
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 16px;
                text-align: left;
                border-radius: 8px;
                overflow: hidden;
            }

            th, td {
                padding: 12px 15px;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #333;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #f9f9f9; 
            }

            tr:nth-child(odd) {
                background-color: #ffffff; 
            }

            tr:hover {
                background-color: #e0e0e0; 
            }

            .a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 15px;
                background-color: red;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            @media (max-width: 768px) {

                th, td {
                    word-wrap: break-word;
                }

                table {
                    font-size: 14px;
                }

                th, td {
                    padding: 10px;
                }

                a {
                    font-size: 14px;
                }
            }
        </style>
    </head>
    <body>
        <?php
            include('navbar.html');
        ?>

        <div class="container">
            <h2>Consulta de Atividades</h2>

            <?php
                include("conexaoBD.php");
                try {
                    $stmt = $pdo->prepare('SELECT * FROM AtividadesProjeto');
                    $stmt->execute();
                    $rows = $stmt->rowCount();

                    if ($rows <= 0) {
                        echo "<p class='message erroPreenchimento'>Ainda não existem atividades cadastradas!</p>";
                    } else {
                        echo "<div class='table-wrapper'><table><tr><th>Código</th><th>Atividade</th><th>Data Inicial</th><th>Data Final</th><th>Orçamento</th><th>Valor Gasto</th><th>Status</th><th>Projeto</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>
                                    <td>".$row['idAtividade']."</td>
                                    <td>".$row['nomeAtividade']."</td>
                                    <td>".$row['dataInicial']."</td>
                                    <td>".$row['dataFinal']."</td>
                                    <td>R$ ".$row['orcamento']."</td>
                                    <td>R$ ".$row['valorGasto']."</td>
                                    <td>".$row['status']."</td>
                                    <td>".$row['nomeProjeto']."</td>
                                  </tr>";
                        }
                        echo "</table></div>";

                        echo "<a href='gerarCSV.php' class='a'>Gerar CSV</a>";
                    }
                } catch (PDOException $e) {
                    echo "<p class='message erroPreenchimento'>Erro ao consultar dados: " . $e->getMessage() . "</p>";
                }
            ?>
        </div>
    </body>
</html>
