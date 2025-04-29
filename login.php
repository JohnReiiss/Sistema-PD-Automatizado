<?php
session_start();
include('includes/db.php');

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT ID, SENHA FROM PD_usuario WHERE USUARIO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $dados = $result->fetch_assoc();
        $senhaArmazenada = $dados['SENHA'];

        if ($senha === $senhaArmazenada) {
            $_SESSION['usuario_id'] = $dados['ID'];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['erro'] = "Senha incorreta.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['erro'] = "Usuário não encontrado.";
        header("Location: login.php");
        exit();
    }
}

if (isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/styles/global-reset.css">
    <link rel="stylesheet" href="src/styles/login.css">
    <link rel="stylesheet" href="src/styles/toastbar.css">
</head>

<body>
    <header>
        <h2>Sistema PD Automatizado</h2>
    </header>

    <form method="POST" action="login.php">
        <h3>Login</h3>
        <p>Por favor, faça login para acessar o sistema.</p>
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
        <p>Não tem um cadastro? <a href="register.php">Registre-se aqui</a></p>
    </form>

    <?php if (!empty($erro)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showToast('<?= addslashes($erro) ?>');
            });
        </script>
    <?php endif; ?>

    <footer>
        <p>Desenvolvido pela Eng. Automação</p>
        <p>&copy; Grupo Multi - <span id="ano-atual"></span></p>
    </footer>


    <script src="src/js/toastRemove.js"></script>
    <script src="src/js/footerYear.js"></script>
</body>

</html>