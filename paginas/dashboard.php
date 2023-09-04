<?php
ob_start(); // Inicia o buffer de saída

session_start();

if (isset($_SESSION['nome_colaborador'])) {
    $nome_colaborador = $_SESSION['nome_colaborador'];
    echo "Olá, $nome_colaborador!";
} else {
    echo "Você não está logado.";
}

ob_end_flush(); // Envia a saída do buffer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSI - Dashboard</title>
</head>
<body>
    
</body>
</html>


