<?php
    session_start();

    // Destroi todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Redireciona para a página de login (ou qualquer outra página desejada)
    header("location: index.php");
    exit();
?>
