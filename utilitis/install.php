<?php

// Verifica se o arquivo db.php existe
if (file_exists('db.php')) {
    
    // Inclui o arquivo db.php
    include('db.php');

    // Conecta ao banco de dados usando as informações de db.php
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Cria a tabela 'images' se ela não existir
    $sql = "CREATE TABLE IF NOT EXISTS images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        directory VARCHAR(255) NOT NULL,
        description TEXT,
        tag VARCHAR(255),
        view INT DEFAULT 0,
        `like` INT DEFAULT 0,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    

    if ($conn->query($sql) === TRUE) {
        echo "Tabela 'images' criada com sucesso.";
    } else {
        echo "Erro ao criar a tabela: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();

} else {
    echo "O arquivo db.php não foi encontrado.";
}

?>
