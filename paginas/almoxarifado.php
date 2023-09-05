<?php
ob_start(); // Inicia o buffer de saída
session_start();
include '../conexao/conexao.php';

mysqli_set_charset($conexao, 'utf8');
$BuscarMaterial = "SELECT * FROM lista_materiais";
$result_BuscarMaterial = mysqli_query($conexao, $BuscarMaterial );

if (isset($_SESSION['cargo_colaborador'])) {
    $cargo_colaborador = $_SESSION['cargo_colaborador'];
    $cargos_permitidos = array("Developer", "Planejador", "Almoxarife", "Supervisor", "Coordenador");

    if (in_array($cargo_colaborador, $cargos_permitidos)) {
        // Não faça o redirecionamento aqui, pois já está no local certo (Almoxarifado)
    } else {
        header("Location: dashboard.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../styles/almoxarifado.css">
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
                    header("Location: ../index.php");
                    exit();
                }
            ?>
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="dashboard.php">Principal</a>
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
                <li><a class="dropdown-item" href="../index.php">Log Out</a></li>
                </ul>
            </li>
            </ul>
        </div>
        </div>
    </div>
    </nav>
    <nav class="materiais_am01">
        <div class="center_materias">
            <div class="add4">
                <h1 class="components"></h1>
                <h1 class="components">COD</h1>
                <h1 class="components">Material</h1>
                <h1 class="components">Quantidade</h1>
                <h1 class="components">Valor Unitário</h1>
            </div>
            <div class="add5-container">
            <?php
                while ($row = mysqli_fetch_assoc($result_BuscarMaterial)) {?>
                    <div class="add5 material-item">
                        <h1 class="components" style="font-size: 15px; display: flex; justify-content: space-evenly; align-items: center;">
                            <img class="componentsimg" src="<?php echo ($row['foto_material']); ?>" alt="">
                        </h1>
                        <h1 class="components">#<?php echo utf8_encode($row['codigo_material']); ?></h1>
                        <h1 class="components"><?php echo utf8_encode($row['nome_material']); ?></h1>
                        <h1 class="components"><?php echo utf8_encode($row['quantidade_material']); ?></h1>
                        <h1 class="components">R$ <?php echo utf8_encode($row['valor_material']); ?></h1>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>
</body>
</html>

<?php
ob_end_flush(); // Envia a saída do buffer
?>