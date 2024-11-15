<?php

/* Geração de arquivo CSV */

include("conexaoBD.php");

try {
    $stmt = $pdo->prepare("select * from AtividadesProjeto");
    $stmt->execute();

    $fp = fopen('arquivoAtividades.csv', 'w');
    
    $colunasTitulo = array("idAtividade", "nomeAtividade", "dataInicial", "dataFinal", "orcamento", "valorGasto", "status", "nomeProjeto", "nomeResponsavel");

    fputcsv($fp, $colunasTitulo);

    while ($row = $stmt->fetch()) {
        $idAtividade = $row["idAtividade"];
        $nomeAtividade = $row["nomeAtividade"];
        $dataInicial = $row["dataInicial"];
        $dataFinal = $row["dataFinal"];
        $orcamento = $row["orcamento"];
        $valorGasto = $row["valorGasto"];
        $status = $row["status"];
        $nomeProjeto = $row["nomeProjeto"];
        $nomeResponsavel = $row["nomeResponsavel"];

        $lista = array (
            array($idAtividade, $nomeAtividade, $dataInicial, $dataFinal, $orcamento, $valorGasto, $status, $nomeProjeto, $nomeResponsavel)
        );
        
        foreach ($lista as $linha) {
            fputcsv($fp, $linha);
        }        
    }

    $msg = "Arquivo gerado: <a href='arquivoAtividades.csv' download='arquivoAtividades.csv'>arquivoAtividades.csv</a>";
    fclose($fp);

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Alunos em CSV</title>
    <style>
            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Arial', sans-serif;
                background-color: #f4f7fb; 
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
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

            button {
                background-color: red;
                color: white;
                font-size: 1.2rem;
                padding: 8px 30px;
                border: none;
                border-radius: 8px;
                margin: 10px;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.3s;
            }

            button:hover {
                background-color: #b30012;
                transform: scale(1.05); 
            }

            button:active {
                background-color: #b30012;
            }

            @media (max-width: 768px) {
                h1 {
                    font-size: 2rem;
                }

                button {
                    font-size: 1rem;
                    padding: 12px 25px;
                }
            }

            a
            {
                color: red;
                text-decoration: none;
            }

            a:hover
            {
                color: #b30012;
            }

    </style>
</head>

<body>
    <h1>Listagem de Alunos em CSV</h1>
    <?= $msg ?>
    <br><br>
    <button onclick="window.open('home.html')">Home</button>
    <button onclick="window.open('cadastroAtividade.php')">Cadastro</button>
    <button onclick="window.open('consultaAtividade.php')">Consulta</button>
</body>
</html>