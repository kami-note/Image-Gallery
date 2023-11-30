<?php
// Inclui o arquivo db.php
include('../db.php');

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Exclui todos os registros da tabela images
$delete_sql = "DELETE FROM images";

if ($conn->query($delete_sql) === TRUE) {
    echo "Todos os registros da tabela 'images' foram excluídos com sucesso.";
} else {
    echo "Erro ao excluir registros: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();

// Define o caminho do diretório de imagens
$imageDirectory = "public/images/uploads/";

// Obtém todos os arquivos no diretório
$files = glob($imageDirectory . '*');

// Exclui cada arquivo
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
        echo "Arquivo excluído: " . $file . "<br>";
    }
}

echo "Todos os arquivos no diretório de imagens foram excluídos com sucesso.";
?>
