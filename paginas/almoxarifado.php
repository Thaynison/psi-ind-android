<?php
ob_start(); // Inicia o buffer de saída
session_start();
include '../conexao/conexao.php';

mysqli_set_charset($conexao, 'utf8');

if (isset($_SESSION['cargo_colaborador'])) {
    $cargo_colaborador = $_SESSION['cargo_colaborador'];
    $cargos_permitidos = array("Developer", "Planejador", "Almoxarife","Encarregado", "Supervisor", "Coordenador", "Dono");

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

$BuscarColaboradores = "SELECT * FROM lista_colaboradores";
$result_BuscarColaboradores = mysqli_query($conexao, $BuscarColaboradores );

$BuscarMaterial = "SELECT * FROM lista_materiais";
$result_BuscarMaterial = mysqli_query($conexao, $BuscarMaterial );

$BuscarSaidaMaterial = "SELECT * FROM saida_material";
$result_BuscarSaidaMaterial = mysqli_query($conexao, $BuscarSaidaMaterial );
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
    <script src="../scripts/quagga.min.js"></script>
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
                <li><a class="dropdown-item" id="cadastrarmaterial-btn" href="#"><i class="fa-regular fa-plus"></i> Cadastrar Material</a></li>
                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-plus"></i> Romaneio de Entrada</a></li>
                <li><a class="dropdown-item" id="listasaidamaterial-btn" href="#"><i class="fa-regular fa-minus"></i> Lista de Saida de Material</a></li>
                <li><a class="dropdown-item" id="entradamaterial-btn" href="#"><i class="fa-regular fa-plus"></i> Entrada de Material</a></li>
                <li><a class="dropdown-item" id="saidamaterial-btn" href="#"><i class="fa-regular fa-minus"></i> Saida de Material</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../index.php">Log Out</a></li>
                </ul>
            </li>
            </ul>
            <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                <button class="btn btn-outline-success" type="submit" id="searchButton">Search</button>
            </form>
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

<div class="backgroundOptions" id="CadastrarMaterial" style="display: none;">
    <div class="GroundOptions">
        <div class="opts1">
            <h1>Criar novo material</h1>
            <i class="fa-regular fa-xmark" id="btn-ocultar-CadastrarMaterial"></i>
        </div>
        <div class="opts2">
        <form class="form" action="" method="post" enctype="multipart/form-data">
            <div class="forms1">
                <div class="dadosform">
                    <h1>Nome do Material:</h1>
                    <input class="inputdads" type="text" name="nome_material" id="nome_material">
                </div>
                <div class="dadosform" style="display: flex;flex-direction: row;justify-content: center;">
                    <div class="dadosform1" style="display: flex; align-items: center; flex-direction: column; justify-content: center;">
                        <h1>Quantidade:</h1>
                        <input class="inputdads" type="text" name="quantidade_material" id="quantidade_material">
                    </div>
                    <div class="dadosform1" style="display: flex; align-items: center; flex-direction: column; justify-content: center;">
                        <h1>Valor unitário:</h1>
                        <input class="inputdads" type="text" name="valor_material" id="valor_material">
                    </div>
                </div>
                <div class="dadosform">
                    <h1>Foto do Material</h1>
                    <input class="inputdads" type="file" accept="image/*" name="foto_material" id="foto_material">
                    <input class="inputdads" type="hidden" name="codigo_material" id="codigo_material">
                </div>
                <div class="dadosform">
                    <input class="btn-send" type="submit" name="CadastrarMaterialNovo" value="Cadastrar">
                </div>
            </div>
        </form>
        </div>
        <div class="opts3">
            <h1>© 2023 PSI Industrial - Todos os direitos reservados.</h1>
            <h1>Desenvolvido por Thaynison Couto</h1>
        </div>
    </div>
</div>

<div class="backgroundOptions" id="ListaSaidaMaterial" style="display: none;">
    <div class="GroundOptions">
        <div class="opts1">
            <h1>Lista de Saida de Materiais</h1>
            <i class="fa-regular fa-xmark" id="btn-ocultar-ListaSaidaMaterial"></i>
        </div>
        <div class="opts2">
            <div class="add4">
                <h1 class="components">COD</h1>
                <h1 class="components">Material</h1>
                <h1 class="components">Quantidade</h1>
                <h1 class="components">Colaborador</h1>
                <h1 class="components">Data</h1>
            </div>
            <div class="add5-container">
            <?php
                while ($row = mysqli_fetch_assoc($result_BuscarSaidaMaterial)) {
                    $codigo_colaborador = $row['codigo_colaborador'];
                    
                    // Consulta SQL para buscar o nome do colaborador com base no código
                    $query_nome_colaborador = "SELECT nome_colaborador FROM lista_colaboradores WHERE codigo_colaborador = $codigo_colaborador";
                    $result_nome_colaborador = mysqli_query($conexao, $query_nome_colaborador);
                    $row_nome_colaborador = mysqli_fetch_assoc($result_nome_colaborador);
                    $nome_colaborador = utf8_encode($row_nome_colaborador['nome_colaborador']);
                    ?>

                    <div class="add5 material-item">
                        <h1 class="components">#<?php echo utf8_encode($row['codigo_material']); ?></h1>
                        <h1 class="components"><?php echo utf8_encode($row['nome_material']); ?></h1>
                        <h1 class="components"><?php echo utf8_encode($row['quantidade_saida']); ?></h1>
                        <h1 class="components"><?php echo $nome_colaborador; ?></h1>
                        <h1 class="components"><?php echo utf8_encode($row['data_retirada']); ?></h1>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
        <div class="opts3">
            <h1>© 2023 PSI Industrial - Todos os direitos reservados.</h1>
            <h1>Desenvolvido por Thaynison Couto</h1>
        </div>
    </div>
</div>
    </div>
</div>

<div class="backgroundOptions" id="EntradaMaterial" style="display: none;">
    <div class="GroundOptions">
        <div class="opts1">
            <h1>Entrada de material</h1>
            <i class="fa-regular fa-xmark" id="btn-ocultar-EntradaMaterial"></i>
        </div>
        <div class="opts2">
            <form class="form" action="" method="post" enctype="multipart/form-data">
                <div class="forms1">
                    <!--  -->
                    <div class="dadosform">
                        <h1>Material:</h1>
                        <select class="inputdads" name="codigo_material">
                            <?php
                            $consultaMateriais = "SELECT codigo_material, nome_material, foto_material FROM lista_materiais";
                            $result_consultaMateriais = $conexao->query($consultaMateriais);

                            while ($row = $result_consultaMateriais->fetch_assoc()) {
                                $nome_material = $row['nome_material'];
                                $codigo_material = $row['codigo_material'];
                                echo "<option value='$codigo_material'>$nome_material | #$codigo_material</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--  -->
                    <div class="dadosform">
                        <h1>Quantidade:</h1>
                        <input class="inputdads" type="text" name="quantidade_material" id="quantidade_material">
                    </div>
                    <!--  -->
                    <div class="dadosform">
                    <!--  -->
                    </div>
                    <!--  -->
                    <div class="dadosform">
                        <input class="btn-send" type="submit" name="SalvarEntradaMaterial" value="Salvar">
                    </div>
                    <!--  -->
                </div>
            </form>
        </div>
        <div class="opts3">
            <h1>© 2023 PSI Industrial - Todos os direitos reservados.</h1>
            <h1>Desenvolvido por Thaynison Couto</h1>
        </div>
    </div>
</div>

<div class="backgroundOptions" id="SaidaMaterial" style="display: none;">
    <div class="GroundOptions">
        <div class="opts1">
            <h1>Saida de material</h1>
            <i class="fa-regular fa-xmark" id="btn-ocultar-SaidaMaterial"></i>
        </div>
        <div class="opts2">
            <form class="form" action="" method="post" enctype="multipart/form-data">
                <div class="forms1">
                    <!--  -->
                    <div class="dadosform">
                        <h1>Material:</h1>
                        <select class="inputdads" name="codigo_material">
                            <?php
                            $consultaMateriais = "SELECT codigo_material, nome_material, foto_material FROM lista_materiais";
                            $result_consultaMateriais = $conexao->query($consultaMateriais);

                            while ($row = $result_consultaMateriais->fetch_assoc()) {
                                $nome_material = $row['nome_material'];
                                $codigo_material = $row['codigo_material'];
                                echo "<option value='$codigo_material'>$nome_material | #$codigo_material</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!--  -->
                    <div class="dadosform">
                        <h1>Quantidade:</h1>
                        <input class="inputdads" type="text" name="quantidade_material" id="quantidade_material">
                    </div>
                    <!--  -->
                    <div class="dadosform">
                        <h1>Codigo Colaborador:</h1>
                        <div id="camera"></div>
                        <input id="resultado" disabled>
                        <input id="resultado" class="resultado" type="hidden" name="codigo_colaborador">
                    </div>
                    <!--  -->
                    <div class="dadosform">
                        <input class="btn-send" type="submit" name="SalvarSaidaMaterial" value="Salvar">
                    </div>
                    <!--  -->
                </div>
            </form>
        </div>
        <div class="opts3">
            <h1>© 2023 PSI Industrial - Todos os direitos reservados.</h1>
            <h1>Desenvolvido por Thaynison Couto</h1>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Certifique-se de incluir o jQuery -->
<script>
    $(document).ready(function() {
        $('#searchButton').click(function(e) {
            e.preventDefault(); // Impede o envio do formulário
            var searchText = $('#searchInput').val().toLowerCase();
            $('.material-item').each(function() {
                var materialName = $(this).find('.components:eq(2)').text().toLowerCase();
                var materialCode = $(this).find('.components:eq(1)').text().toLowerCase();
                if (materialName.includes(searchText) || materialCode.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

<script>
    document.getElementById("cadastrarmaterial-btn").addEventListener("click", function() {
        document.getElementById("CadastrarMaterial").style.display = "block";
    });
    
    document.getElementById("btn-ocultar-CadastrarMaterial").addEventListener("click", function() {
        document.getElementById("CadastrarMaterial").style.display = "none";
    });

    document.getElementById("listasaidamaterial-btn").addEventListener("click", function() {
        document.getElementById("ListaSaidaMaterial").style.display = "block";
    });
    
    document.getElementById("btn-ocultar-ListaSaidaMaterial").addEventListener("click", function() {
        document.getElementById("ListaSaidaMaterial").style.display = "none";
    });

    document.getElementById("entradamaterial-btn").addEventListener("click", function() {
        document.getElementById("EntradaMaterial").style.display = "block";
    });
    
    document.getElementById("btn-ocultar-EntradaMaterial").addEventListener("click", function() {
        document.getElementById("EntradaMaterial").style.display = "none";
    });

    document.getElementById("saidamaterial-btn").addEventListener("click", function() {
        document.getElementById("SaidaMaterial").style.display = "block";
        startCamera();
    });

    document.getElementById("btn-ocultar-SaidaMaterial").addEventListener("click", function() {
        document.getElementById("SaidaMaterial").style.display = "none";
        stopCamera();
    });

    function gerarNumerosAleatoriosUnicos() {
        var numeros = [];
        while(numeros.length < 6) {
            var numero = Math.floor(Math.random() * 10);
            if(numeros.indexOf(numero) === -1) numeros.push(numero);
        }
        return numeros.join('');
    }
    document.getElementById("codigo_material").value = gerarNumerosAleatoriosUnicos();
    
    let isCameraActive = false;

    function startCamera() {
        if (!isCameraActive) {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#camera')
                },
                decoder: {
                    readers: ["code_128_reader"]
                }
            }, function (err) {
                if (err) {
                    console.log(err);
                    return;
                }
                console.log("Initialization finished. Ready to start");
                Quagga.start();
                isCameraActive = true;
            });

            Quagga.onDetected(function (data) {
                document.querySelector('#resultado').value = data.codeResult.code;
                document.querySelector('.resultado').value = data.codeResult.code;
                NumeroColab = data.codeResult.code
                console.log(NumeroColab);

            });
        }
    }

    function stopCamera() {
        if (isCameraActive) {
            Quagga.stop();
            isCameraActive = false;
        }
    }
</script>

<?php
if (isset($_POST['SalvarEntradaMaterial'])) {
    $codigo_material = $_POST['codigo_material'];
    $quantidade_material_entrar = $_POST['quantidade_material'];

    $consultarCodigoMaterial = "SELECT codigo_material, quantidade_material FROM lista_materiais WHERE codigo_material = '$codigo_material'";
    $result_consultarCodigoMaterial = $conexao->query($consultarCodigoMaterial);

    if ($result_consultarCodigoMaterial->num_rows > 0) {
        $row = $result_consultarCodigoMaterial->fetch_assoc();
        $quantidade_material = $row['quantidade_material'];

        $nova_quantidade = $quantidade_material + $quantidade_material_entrar;

        $atualizarQuantidadeMaterial = "UPDATE lista_materiais SET quantidade_material = '$nova_quantidade' WHERE codigo_material = '$codigo_material'";
        if ($conexao->query($atualizarQuantidadeMaterial) === TRUE) {
            // echo "Quantidade do material atualizada com sucesso.";
            header("Location: almoxarifado.php");
            exit();
        } else {
            header("Location: almoxarifado.php");
            exit();
        }
    } else {
        header("Location: almoxarifado.php");
        exit();
    }
};

if (isset($_POST['SalvarSaidaMaterial'])) {
    // Dados do formulário
    $codigo_material = $_POST['codigo_material']; // Código do material selecionado
    $quantidade_saida = $_POST['quantidade_material'];
    $codigo_colaborador = $_POST['codigo_colaborador'];

    // Consulta para obter o nome do material com base no código selecionado
    $consultaNomeMaterial = "SELECT nome_material, quantidade_material FROM lista_materiais WHERE codigo_material = '$codigo_material'";
    $resultadoNomeMaterial = $conexao->query($consultaNomeMaterial);

    if ($resultadoNomeMaterial->num_rows > 0) {
        $row = $resultadoNomeMaterial->fetch_assoc();
        $nome_material = $row['nome_material'];
        $quantidade_material_atual = $row['quantidade_material'];

        $row_cod_colaborador = mysqli_fetch_assoc($result_BuscarColaboradores);
        $codigo_colaborador_real = $row_cod_colaborador['codigo_colaborador'];

        if ($codigo_colaborador_real == $codigo_colaborador) {
        // Verifique se há material suficiente disponível para a saída
            if ($quantidade_saida <= $quantidade_material_atual) {
                // Calcule a nova quantidade de material após a saída
                $nova_quantidade_material = $quantidade_material_atual - $quantidade_saida;

                // Atualize a quantidade de material na tabela 'lista_materiais'
                $atualizarQuantidadeQuery = "UPDATE lista_materiais SET quantidade_material = '$nova_quantidade_material' WHERE codigo_material = '$codigo_material'";

                // Execute a query de atualização
                if ($conexao->query($atualizarQuantidadeQuery) === TRUE) {
                    // Query para inserir os dados na tabela 'saida_material'
                    $brasilTimeZone = new DateTimeZone('America/Sao_Paulo');
                    $dataHoraBrasil = new DateTime('now', $brasilTimeZone);
                    $dataHoraBrasilFormatada = $dataHoraBrasil->format('Y-m-d H:i:s');

                    $inserirSaidaQuery = "INSERT INTO saida_material (codigo_material, nome_material, quantidade_saida, codigo_colaborador, data_retirada) 
                    VALUES ('$codigo_material', '$nome_material', '$quantidade_saida', '$codigo_colaborador', '$dataHoraBrasilFormatada')";

                    // Execute a query de inserção na tabela 'saida_material'
                    if ($conexao->query($inserirSaidaQuery) === TRUE) {
                        // echo "dados adicionados ao banco dados";
                        header("Location: almoxarifado.php");
                        exit();
                    } else {
                        header("Location: almoxarifado.php");
                        exit();
                    }
                } else {
                    header("Location: almoxarifado.php");
                    exit();
                }
            } else {
                header("Location: almoxarifado.php");
                exit();
            }
        } else {
            header("Location: almoxarifado.php");
            exit();
        }
    } else {
        header("Location: almoxarifado.php");
        exit();
    }
};

if (isset($_POST['CadastrarMaterialNovo'])) {
    $nome_material = $_POST['nome_material'];
    $quantidade_material = $_POST['quantidade_material'];
    $valor_material = $_POST['valor_material'];
    $codigo_material = $_POST['codigo_material'];

    // Save the image in a predefined folder
    $target_dir = "img/Materiais/";
    
    // Create the directory if it does not exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["foto_material"]["name"]);
    move_uploaded_file($_FILES["foto_material"]["tmp_name"], $target_file);

    // Change the name of the image to '$codigo_material.png'
    $new_image_name = $codigo_material . '.png';
    rename($target_file, $target_dir . $new_image_name);

    // Save the image URL in the database
    $foto_material = $target_dir . $new_image_name;

    mysqli_set_charset($conexao, 'utf8');
    
    // Check if the material already exists in the database
    $check_query = "SELECT * FROM lista_materiais WHERE codigo_material='$codigo_material' OR foto_material='$foto_material'";
    $check_result = mysqli_query($conexao, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "O material já existe no banco de dados";
    } else {
        // Insert the new material into the database
        $Criar_Material = "INSERT INTO lista_materiais (codigo_material, nome_material, foto_material, quantidade_material, valor_material) VALUES ( '$codigo_material', '$nome_material', '$foto_material', '$quantidade_material', '$valor_material')";
        $Update_Criar_Material = mysqli_query($conexao, $Criar_Material);

        if ($Update_Criar_Material) {
            header("Location: almoxarifado.php");
            exit();
        } else {
            header("Location: almoxarifado.php");
            exit();
        }
    }
};
?>

<?php
ob_end_flush(); // Envia a saída do buffer
?>

