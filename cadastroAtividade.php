<html>
    <head>
        <style type="text/css"></style>
    </head>
    <body>
        <a href="home.html">Home</a> | <a href="consulta.php">Consulta</a>
        <h2>Cadastro de Produtos</h2>
        <form method="post">
            Código: <input type="text" name="codigo">
            <br><br>
            Decrição: <input type="text" name="produto">
            <br><br>
            Valor: <input type="text" name="valor">

            <br><br>
            <input type="submit" value="Cadastrar">
        </form>
    </body>
</html>

<?php

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $codigo = $_POST['codigo'];
        $produto = $_POST['produto'];
        $valor = $_POST['valor'];

        if((trim($codigo)!="")&&(trim($produto)!=""))
        {
            include("conexaoBD.php");
            try
            {
                $stmt = $pdo->prepare('select * from ProdutoPHP where codigo = :codigo');
                $stmt->bindParam(':codigo', $codigo);
                $stmt->execute();

                $rows = $stmt->rowCount();
                if($rows<=0)
                {
                    $stmt = $pdo->prepare('insert into ProdutoPHP (codigo, produto, valor) values (:codigo, :produto, :valor)');
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':produto', $produto);
                    $stmt->bindParam(':valor', $valor);
                    $stmt->execute();
                    echo "<h4 id='sucesso'>Produto cadastrado com sucesso!</h4>";
                }
                else
                {
                    echo "<h4 id='erroExiste'>Código de Produto já cadastrado!</h4>";
                }
            }   
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        else
        {
            echo "<h4 id='erroPreenchimento'>Preencha os campos de código e descrição!</h4>";
        }
    }
    $pdo = null;

?>