<html>
    <head>
        <style type="text/css">
            
        </style>
    </head>
    <body>
        <a href="home.html">Home</a> | <a href="cadastro.php">Cadastro</a>
        <h2>Consulta de Produtos</h2>
    </body>
</html>

<?php

    include("conexaoBD.php");
    try
    {
        $stmt = $pdo->prepare('select * from ProdutoPHP');
        $stmt->execute();
        $rows = $stmt->rowCount();
        if($rows<=0)
        {
            echo "Ainda não existem produtos cadastrados!";
        }
        else
        {
            $stmt->execute();
            echo "<table border='1px solid'><tr><th>Código</th><th>Produto</th><th>Valor</th></tr>";
            while($row = $stmt->fetch())
            {
                echo "<tr><td>".$row['codigo']."</td><td>".$row['produto']."</td><td>".$row['valor']."</td></tr>";
            }
            echo "</table>";
        }
    
    }
    catch(PDOException $e)
    {

    }

?>