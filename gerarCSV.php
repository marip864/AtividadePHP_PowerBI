<?php

include("conexaoBD.php");

try {
    $stmt = $pdo->prepare("select * from AtividadesProjeto");
    $stmt->execute();

    $fp1 = fopen('arquivoAtividades.csv', 'w');
    
    $colunasTitulo1 = array("idAtividade", "nomeAtividade", "dataInicial", "dataFinal", "orcamento", "valorGasto", "status", "nomeProjeto", "nomeResponsavel");

    fputcsv($fp1, $colunasTitulo1);

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

        $lista1 = array (
            array($idAtividade, $nomeAtividade, $dataInicial, $dataFinal, $orcamento, $valorGasto, $status, $nomeProjeto, $nomeResponsavel)
        );
        
        foreach ($lista1 as $linha) {
            fputcsv($fp1, $linha);
        }

    }

        $stmt = $pdo->prepare("select * from Projeto");
        $stmt->execute();

        $fp2 = fopen('arquivoProjetos.csv', 'w');
        
        $colunasTitulo2 = array("nomeProjeto");

        fputcsv($fp2, $colunasTitulo2);

        while ($row = $stmt->fetch()) {
            $nomeProjeto = $row["nomeProjeto"];

            $lista2 = array (
                array($nomeProjeto)
            );
            
            foreach ($lista2 as $linha) {
                fputcsv($fp2, $linha);
            }
        }

        $stmt = $pdo->prepare("select * from ResponsavelAtividade");
        $stmt->execute();

        $fp3 = fopen('arquivoResponsaveis.csv', 'w');
        
        $colunasTitulo3 = array("idResponsavelAtividade", "nomeResponsavel");

        fputcsv($fp3, $colunasTitulo3);

        while ($row = $stmt->fetch()) {
            $idResponsavelAtividade = $row["idResponsavelAtividade"];
            $nomeResponsavel = $row["nomeResponsavel"];

            $lista3 = array (
                array($idResponsavelAtividade, $nomeResponsavel)
            );
            
            foreach ($lista3 as $linha) {
                fputcsv($fp3, $linha);
            }
        }

    $msg = "Arquivos gerados: <a href='arquivoAtividades.csv' download='arquivoAtividades.csv'>arquivoAtividades.csv</a><a href='arquivoProjetos.csv' download='arquivoProjetos.csv'>arquivoProjetos.csv</a><a href='arquivoResponsaveis.csv' download='arquivoResponsaveis.csv'>arquivoResponsaveis.csv</a>";
    fclose($fp1);
    fclose($fp2);

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
                background-color: #2e66b1;
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
                background-color: #05316b;
                transform: scale(1.05); 
            }

            button:active {
                background-color: #05316b;
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
                color: #2e66b1;
                text-decoration: none;
            }

            a:hover
            {
                color: #05316b;
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