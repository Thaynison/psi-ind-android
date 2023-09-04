<?php
ob_start(); // Inicia o buffer de saída
session_start();
include '../conexao/conexao.php';

if (isset($_SESSION['cargo_colaborador'])) {
    $cargo_colaborador = $_SESSION['cargo_colaborador'];
    $cargos_permitidos = array("Developer", "Planejador", "Almoxarife", "Supervisor", "Coordenador");

    if (in_array($cargo_colaborador, $cargos_permitidos)) {
        // Não faça o redirecionamento aqui, pois já está no local certo (Almoxarifado)
    } else {
        header("Location: dashboard.php");
        exit(); // Certifique-se de sair após o redirecionamento
    }
} else {
    echo "Você não está logado.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="shortcut icon" href="../img/psi-logo.png" type="image/x-icon">
    <title>PSI Industrial – Elétrica, Instrumentação e Automação Industrial</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Almoxarifado</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
            <?php
                if (isset($_SESSION['nome_colaborador'])) {
                    $nome_colaborador = $_SESSION['nome_colaborador'];
                    echo "Olá, $nome_colaborador!";
                } else {
                    echo "Você não está logado.";
                }
            ?>
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Principal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Suporte</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Almoxarifado
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-plus"></i> Cadastrar Material</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-plus"></i> Romaneio de Entrada</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-plus"></i> Lista de Material</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-minus"></i> Lista de Saida de Material</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-plus"></i> Entrada de Material</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-minus"></i> Saida de Material</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Log Out</a></li>
                </ul>
            </li>
            </ul>
        </div>
        </div>
    </div>
    </nav>
</body>
</html>

<?php
ob_end_flush(); // Envia a saída do buffer
?>