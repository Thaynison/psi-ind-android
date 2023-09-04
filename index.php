<?php
session_start();
include 'conexao/conexao.php';

if (isset($_POST['LogarUsuario'])) {
    $codigo_user = $_POST['codigo_user']; // Codigo do usuario
    $senha_user = $_POST['senha_user']; // Senha do usuario

    $consulta_user = "SELECT * FROM lista_colaboradores WHERE codigo_colaborador = '$codigo_user'";
    $resultado_consulta_user = $conexao->query($consulta_user);

    if (mysqli_num_rows($resultado_consulta_user) > 0) {
        $row = $resultado_consulta_user->fetch_assoc();
        $codigo_colaborador = $row['codigo_colaborador'];
        $senha_colaborador = $row['senha_colaborador'];
        $nome_colaborador = $row['nome_colaborador']; // Nome do colaborador

        if ($senha_colaborador == $senha_user || $codigo_user == $codigo_colaborador) {
            echo "Logado com sucesso!";
            $_SESSION['nome_colaborador'] = $nome_colaborador; // Armazena o nome do colaborador na sessão
            header("Location: ./paginas/dashboard.php");
        } else {
            echo "Você precisa ser registrar";
            header("Location: registro.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
    <link rel="shortcut icon" href="img/psi-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/notifications.css">
    <title>PSI - Android</title>
</head>
<body>
    <div>
        <form class="login_send" method="post" enctype="multipart/form-data">
            <div class="top_login">
                <div class="options_login">
                    <img src="img/psi-logo.png">
                </div>
                <div class="options_login">
                    <h1 class="text-logar_usuario">Usuário:</h1>
                    <input class="btn-login_input" type="text" name="codigo_user">
                </div>
                <div class="options_login">
                    <h1 class="text-logar_usuario">Senha:</h1>
                    <input class="btn-login_input" type="text" name="senha_user">
                </div>
            </div>
            <div class="buttom_login">
                <input class="btn-logar_usuario" type="submit" name="LogarUsuario" value="Logar">
                <h1 class="text-logar_usuario">Entre com o código de usuário</h1>
            </div>
        </form>
    </div>
</body>
</html>


<div class="notifcation" id="NotifcationID">
    <div class="options1">
        <h1 class="aviso">Erro:</h1>
        <img class="logo-notify" src="img/psi-logo.png">
    </div>
    <div class="options2">
        <h1 class="Descricao">Erro ao efetuar o login!</h1>
    </div>
    <div class="options1">
        <h1 class="Direitos">© PSI INDUSTRIAL | 2023 - Todos Direitos Reservados.</h1>
    </div>
</div>