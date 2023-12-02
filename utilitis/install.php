<?php

// Verifica se o arquivo db.php existe
if (file_exists('../db.php')) {
    
    // Inclui o arquivo db.php
    include('../db.php');

    // Conecta ao banco de dados usando as informações de db.php
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Cria a tabela 'user' se ela não existir
    $sql_user = "CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        content TEXT
    )";

    // Executa a query para criar a tabela 'user'
    if ($conn->query($sql_user) === TRUE) {
        echo "Tabela 'user' criada com sucesso.";
    } else {
        echo "Erro ao criar a tabela 'user': " . $conn->error;
    }

    // Cria a tabela 'images' se ela não existir
    $sql_images = "CREATE TABLE IF NOT EXISTS images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL,
        description TEXT,
        tags VARCHAR(255),
        view INT DEFAULT 0,
        `like` INT DEFAULT 0,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        type VARCHAR(255) NULL
    )";
    
    // Executa a query para criar a tabela 'images'
    if ($conn->query($sql_images) === TRUE) {
        echo "Tabela 'images' criada com sucesso.";
    } else {
        echo "Erro ao criar a tabela 'images': " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

} else {
    echo "O arquivo db.php não foi encontrado.";
}

?>
