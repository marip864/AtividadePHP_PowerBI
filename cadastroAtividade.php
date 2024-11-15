<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Atividades - Projetos TCC</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                display: flex;
                justify-content: center;
                align-items: center; 
                margin: 0;
                flex-direction: column; 
            }

            nav {
                width: 100%;
                background-color: #333;
                padding: 20px 20px;
                box-sizing: border-box;
            }

            nav ul {
                display: flex;
                justify-content: center; 
                list-style: none;
                margin: 0;
                padding: 0;
            }

            nav ul li {
                margin: 0 15px;
            }

            nav ul li a {
                color: white;
                text-decoration: none;
                font-size: 16px;
                padding: 10px;
                transition: background-color 0.3s ease;
            }

            nav ul li a:hover {
                background-color: #575757;
                border-radius: 4px;
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

            form {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            input[type="text"], input[type="date"], select {
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
                width: 100%;
                box-sizing: border-box;
            }

            input[type="submit"] {
                background-color: red;
                color: white;
                border: none;
                padding: 15px;
                font-size: 16px;
                cursor: pointer;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }

            .message {
                text-align: center;
                font-weight: bold;
                margin-top: 20px;
            }

            .erroPreenchimento {
                color: red;
            }

            .sucesso {
                color: green;
            }

            .erroExiste {
                color: orange;
            }

            @media (max-width: 600px) {
                nav ul {
                    flex-direction: column; 
                    align-items: center; 
                }

                nav ul li {
                    margin: 10px 0;
                }

                .container {
                    padding: 15px;
                }

                h2 {
                    font-size: 20px;
                }

                input[type="submit"] {
                    padding: 12px;
                }
            }
        </style>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="consultaAtividade.php">Consulta</a></li>
                <li><a href="gerarCSV.php">Gerar CSV</a></li>
            </ul>
        </nav>

        <div class="container">
            <h2>Cadastro de Atividades - Projetos TCC</h2>
            <form method="post" id="checkbox-container">
                Nome da Atividade: <input type="text" name="nome" required>
                <br>
                Data Inicial: <input type="date" name="dataInicial" required>
                <br>
                Data Final: <input type="date" name="dataFinal" required>
                <br>
                Orçamento: <input type="text" name="orcamento" required>
                <br>
                Valor gasto: <input type="text" name="valorGasto" required>
                <br>
                Status: 
                <select name="status" required>
                    <option value=""></option>
                    <option value="Não iniciada">Não iniciado</option>
                    <option value="Em andamento">Em andamento</option>
                    <option value="Finalizada">Finalizado</option>
                </select>
                <br>
                Projeto vinculado: 
                <?php
                try {
                    include('conexaoBD.php');
                    $stmt = $pdo->prepare("SELECT nomeProjeto FROM Projeto");
                    $stmt->execute(); 

                    echo '<select name="projeto" id="projeto" required>';
                    echo '<option value=""></option>';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $nome = $row['nomeProjeto'];
                        echo "<option value=\"$nome\">$nome</option>";
                    }

                    echo '</select>';
                } 
                catch (PDOException $e) {
                    echo 'Erro na consulta: ' . $e->getMessage();
                }
                ?>
                <br>
                Responsável: <input type="text" name="responsavel" required>
                <br>
                <input type="submit" value="Cadastrar">
            </form>

            <?php
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $nome = $_POST['nome'];
                $dataInicial = $_POST['dataInicial'];
                $dataFinal = $_POST['dataFinal'];
                $orcamento = $_POST['orcamento'];
                $valorGasto = $_POST['valorGasto'];
                $status = $_POST['status'];
                $projeto = $_POST['projeto'];
                $responsavel = $_POST['responsavel'];
                setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'portuguese');
                $dataInicialFormatada = strftime("%A, %d de %B de %Y", strtotime($dataInicial));
                $dataFinalFormatada = strftime("%A, %d de %B de %Y", strtotime($dataFinal));
                if(trim($nome) != "" && trim($dataInicial) != "" && trim($dataFinal) != "" && trim($orcamento) != "" && trim($valorGasto) != "" && trim($status) != "" && trim($projeto) != "" && trim($responsavel) != "") {
                    include("conexaoBD.php");
                    try {
                        $stmt = $pdo->prepare('SELECT * FROM AtividadesProjeto WHERE nomeAtividade = :nome AND nomeProjeto = :nomeProjeto');
                        $stmt->bindParam(':nome', $nome);
                        $stmt->bindParam(':nomeProjeto', $projeto);
                        $stmt->execute();

                        $rows = $stmt->rowCount();
                        if($rows <= 0) {
                            $stmt = $pdo->prepare('INSERT INTO AtividadesProjeto (nomeAtividade, dataInicial, dataFinal, orcamento, valorGasto, status, nomeProjeto, nomeResponsavel) VALUES (:nomeAtividade, :dataInicial, :dataFinal, :orcamento, :valorGasto, :status, :idProjeto, :nomeResponsavel)');
                            $stmt->bindParam(':nomeAtividade', $nome);
                            $stmt->bindParam(':dataInicial', $dataInicialFormatada);
                            $stmt->bindParam(':dataFinal', $dataFinalFormatada);
                            $stmt->bindParam(':orcamento', $orcamento);
                            $stmt->bindParam(':valorGasto', $valorGasto);
                            $stmt->bindParam(':status', $status);
                            $stmt->bindParam(':idProjeto', $projeto);
                            $stmt->bindParam(':nomeResponsavel', $responsavel);
                            $stmt->execute();
                            echo "<div class='message sucesso'>Atividade cadastrada com sucesso!</div>";
                        } else {
                            echo "<div class='message erroExiste'>A atividade já foi cadastrada!</div>";
                        }
                    } catch(PDOException $e) {
                        echo $e->getMessage();
                    }
                } else {
                    echo "<div class='message erroPreenchimento'>Preencha todos os campos!</div>";
                }
            }
            ?>
        </div>
    </body>
</html>
