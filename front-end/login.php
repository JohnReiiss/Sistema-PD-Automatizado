<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PDA System</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/pda-new-logo-png.png" type="image/x-icon">
    <!-- /Favicon -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- /Google Fonts -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- /Font Awesome -->

    <!-- auth css -->
    <link rel="stylesheet" href="assets/css/login.css">
    <!-- /auth css -->

    <!-- Sweet Alert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- /Sweet Alert2 -->
</head>
<body>

    <div class="container" id="main-container">
        <div class="form-container">
            <form id="login-form">
                <h2>Login</h2>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="login-usuario" placeholder="Usuário" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="login-senha" placeholder="Senha" required>
                </div>
                <button type="submit">Entrar</button>
                <p class="toggle-text">Não tem cadastro? <a id="show-register">Registre-se</a></p>
            </form>

            <form id="register-form">
                <h2>Cadastro</h2>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="register-usuario" placeholder="Usuário" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="register-senha" placeholder="Senha" required>
                </div>
                <button type="submit">Cadastrar</button>
                <p class="toggle-text">Já tem uma conta? <a id="show-login">Faça login</a></p>
            </form>
        </div>
    </div>

    <!-- Auth js -->
    <script src="assets/js/login.js" defer></script>
    <!-- /Auth js -->

</body>
</html>