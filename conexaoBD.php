<?php
    /*conexaoBD.php*/

    try {           
        $db =  'mysql:host=143.106.241.3;dbname=cl202239;charset=utf8';
        $user = 'cl202239';
        $passwd = '@marip.864_frozen0905';
        $pdo = new PDO($db, $user, $passwd);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    } catch (PDOException $e) {
        $output = 'Impossível conectar BD : ' . $e . '<br>';
        echo $output;
    }    
?>