<?php

/* Geração de arquivo CSV */

include("conexaoBD.php");

try {
    $stmt = $pdo->prepare("select * from AtividadesProjeto");
    $stmt->execute();

    $fp = fopen('arquivoAtividades.csv', 'w');
    
    $colunasTitulo = array("idAtividade", "nomeAtividade", "dataInicial", "dataFinal", "diasPrevistos", "orcamento", "valorGasto", "status", "idProjeto", "idResponsavel");

    fputcsv($fp, $colunasTitulo);

    while ($row = $stmt->fetch()) {
        $idAtividade = $row["idAtividade"];
        $nomeAtividade = $row["nomeAtividade"];
        $dataInicial = $row["dataInicial"];
        $dataFinal = $row["dataFinal"];
        $diasPrevistos = $row["diasPrevistos"];
        $orcamento = $row["orcamento"];
        $valorGasto = $row["valorGasto"];
        $status = $row["status"];
        $idProjeto = $row["idProjeto"];
        $idResponsavel = $row["idResponsavel"];

        $lista = array (
            array($idAtividade, $nomeAtividade, $dataInicial, $dataFinal, $diasPrevistos, $orcamento, $valorGasto, $status, $idProjeto, $idResponsavel)
        );
        
        foreach ($lista as $linha) {
            fputcsv($fp, $linha);
        }        
    }

    $msg = "Arquivo gerado: arquivoAtividades.csv";
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
</head>

<body>
    <h1>Listagem de Alunos em CSV</h1>
    <?= $msg ?>
</body>
</html>