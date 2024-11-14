<html>
    <head>
        <style type="text/css">
            
        </style>
    </head>
    <body>
        <a href="home.html">Home</a> | <a href="cadastroAtividade.php">Cadastro</a>
        <h2>Consulta de Produtos</h2>
    </body>
</html>

<?php

    include("conexaoBD.php");
    try
    {
        $stmt = $pdo->prepare('select * from AtividadesProjeto');
        $stmt->execute();
        $rows = $stmt->rowCount();
        if($rows<=0)
        {
            echo "Ainda não existem atividades cadastrados!";
        }
        else
        {
            $stmt->execute();
            echo "<table border='1px solid'><tr><th>Código</th><th>Atividade</th><th>Data inicial</th><th>Data final</th><th>Orçamento</th><th>Valor gasto</th><th>Status</th><th>Nome do Projeto</th></tr>";
            while($row = $stmt->fetch())
            {
                echo "<tr><td>".$row['idAtividade']."</td><td>".$row['nomeAtividade']."</td><td>".$row['dataInicial']."</td><td>".$row['dataFinal']."</td><td>".$row['orcamento']."</td><td>".$row['valorGasto']."</td><td>".$row['status']."</td><td>".$row['nomeProjeto']."</td></tr>";
            }
            echo "</table>";
        }
    
    }
    catch(PDOException $e)
    {

    }

?>