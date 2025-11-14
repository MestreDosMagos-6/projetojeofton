<?php

    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'formulario-projeto';

    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

     if($conexao->connect_erro)
     {
       echo"Erro";
     }
     else
     {
       echo "conexão efetuada com sucesso";
     }
?>
