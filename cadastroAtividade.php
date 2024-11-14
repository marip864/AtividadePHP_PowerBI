<html>
    <head>
        <style type="text/css"></style>
    <body>
        <a href="home.html">Home</a> | <a href="consulta.php">Consulta</a>
        <h2>Cadastro de Produtos</h2>
        <form method="post" id="checkbox-container">
            Nome da Atividade: <input type="text" name="nome">
            <br><br>
            Data Inicial: <input type="date" name="dataInicial">
            <br><br>
            Data Final: <input type="date" name="dataFinal">
            <br><br>
            Orçamento: <input type="text" name="orcamento">
            <br><br>
            Valor gasto: <input type="text" name="valorGasto">
            <br><br>
            Status: <select value="status"><option></option><option>Não iniciado</option><option>Em andamento</option><option>Finalizado</option></select>
            <br><br>
            Projeto vinculado: 
            <?php
            $_POST['projeto']="";
            try {
                include('conexaoBD.php');
                $stmt = $pdo->prepare("select nomeProjeto from Projeto");
                $stmt->execute(); 

                echo '<select name="projeto" id="projeto">';
                
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
            <br><br>
            Responsável: <input type="text" name="responsavel">
            <br><br>
            <input type="submit" value="Cadastrar">
        </form>
    </body>
</html>

<?php

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $nome = $_POST['nome'];
        $dataInicial = $_POST['dataInicial'];
        $dataFinal = $_POST['dataFinal'];
        $orcamento  =$_POST['orcamento'];
        $valorGasto = $_POST['valorGasto'];
        $status = $_POST['status'];
        $projeto = $_POST['projeto'];
        $responsavel = $_POST['responsavel'];

        if((trim($nome)!="")&&(trim($dataInicial)!="")&&(trim($dataFinal)!="")&&(trim($orcamento)!="")&&(trim($valorGasto)!="")&&(trim($status)!=null)&&(trim($projeto)!="")&&(trim($responsavel)!=""))
        {
            include("conexaoBD.php");
            try
            {
                $stmt = $pdo->prepare('select * from AtividadesProjeto where nome = :nome and idProjeto = :nomeProjeto');
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':nomeProjeto', $projeto);
                $stmt->execute();

                $rows = $stmt->rowCount();
                if($rows<=0)
                {
                    $stmt = $pdo->prepare('insert into AtividadesProjeto (nomeAtividade, dataInicial, dataFinal, orcamento, valorGasto, status, idProjeto, idResponsavel) values (:nomeAtividade, :dataInicial, :dataFinal, :orcamento, :valorGasto, :status, :idProjeto, :idResponsavel)');
                    $stmt->bindParam(':nomeAtividade', $nomeAtividade);
                    $stmt->bindParam(':dataInicial', $dataInicial);
                    $stmt->bindParam(':dataFinal', $dataFinal);
                    $stmt->bindParam(':orcamento', $orcamento);
                    $stmt->bindParam(':valorGasto', $valorGasto);
                    $stmt->bindParam(':status', $status);
                    $stmt->bindParam(':idProjeto', $idProjeto);
                    $stmt->execute();
                    echo "<h4 id='sucesso'>Atividade cadastrada com sucesso!</h4>";
                }
                else
                {
                    echo "<h4 id='erroExiste'>A atividade já foi cadastrada!</h4>";
                }
            }   
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
        else
        {
            echo "<h4 id='erroPreenchimento'>Preencha todos os campos!</h4>";
        }
    }
    $pdo = null;

?>