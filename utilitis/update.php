<?php

include('../db.php');

$select_sql = "SELECT id, directory FROM images WHERE type IS NULL";
$result = $conn->query($select_sql);

while ($row = $result->fetch_assoc()) {
    // Obtém a extensão do arquivo
    $fileExtension = pathinfo($row['directory'], PATHINFO_EXTENSION);

    // Determina o tipo com base na extensão
    $tipo = ($fileExtension == 'gif') ? 'gif' : 'image'; // Corrigido 'gif' para 'image'

    // Atualiza o tipo no banco de dados
    $update_sql = "UPDATE images SET type = '$tipo' WHERE id = " . $row['id'];
    if ($conn->query($update_sql) !== TRUE) {
        echo "Erro ao atualizar tipo: " . $conn->error;
    }
}

?>
