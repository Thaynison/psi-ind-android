<?php
include 'conexao/conexao.php';
session_start();

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

        if ($senha_colaborador == $senha_user && $codigo_user == $codigo_colaborador) {
            $usuario_logado = true;
            $_SESSION['nome_colaborador'] = $nome_colaborador; // Armazena o nome do colaborador na sessão
            header("Location: paginas/dashboard.php");
        } else {
            $usuario_logado = false;
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
                    <input class="btn-login_input" type="number" name="codigo_user">
                </div>
                <div class="options_login">
                    <h1 class="text-logar_usuario">Senha:</h1>
                    <input class="btn-login_input" type="password" name="senha_user">
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


<div class="notification" id="NotificationID" style="display: none">
    <div class="options1">
        <h1 class="aviso">Erro:</h1>
        <img class="logo-notify" src="img/psi-logo.png">
    </div>
    <div class="options2">
        <h1 class="Descricao">Erro ao efetuar o login!</h1>
    </div>
    <div class="options1">
        <h1 class="Direitos">© 2023 - PSI INDUSTRIAL | Todos Direitos Reservados.</h1>
    </div>
</div>

<script>
    var usuarioLogado = <?php echo json_encode($usuario_logado); ?>;
    var notificationDiv = document.getElementById("NotificationID");

    // Atrasa a exibição da notificação por 3 segundos
    setTimeout(function() {
        if (!usuarioLogado) {
            notificationDiv.style.display = "block";
        }
    }, 1000); // 3000 milissegundos = 3 segundos

    // Esconde a notificação após 30 segundos
    setTimeout(function() {
        notificationDiv.style.display = "none";
    }, 10000); // 30000 milissegundos = 30 segundos
</script>
