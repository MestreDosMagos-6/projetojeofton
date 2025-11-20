<?php
$conexao = new mysqli('localhost', 'root', '');

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Criação do Banco
$sql = "CREATE DATABASE IF NOT EXISTS `formulario-projeto`";
if ($conexao->query($sql) === TRUE) {
    echo "Banco de dados criado com sucesso!<br>";
} else {
    echo "Erro ao criar banco: " . $conexao->error;
}

$conexao->select_db('formulario-projeto');

// Criação da Tabela
$tabela = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    sexo VARCHAR(15),
    data_nascimento DATE,
    cidade VARCHAR(50),
    estado VARCHAR(50),
    endereco TEXT
)";

if ($conexao->query($tabela) === TRUE) {
    echo "Tabela usuarios configurada com sucesso!";
} else {
    echo "Erro ao criar tabela: " . $conexao->error;
}

$conexao->close();
?>