<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDA System</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/pda-new-logo-png.png" type="image/x-icon">
    <!-- /Favicon -->

    <!-- Script for token storage -->
    <script>
        const token = localStorage.getItem('authToken');
        if (!token) { window.location.href = 'login.php'; }
    </script>
    <!-- /Script for token storage -->
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- /Google Fonts -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- /Font Awesome -->

    <!-- Sweet Alert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- /Sweet Alert2 -->

    <!-- Library Hamburgers -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.2.1/hamburgers.min.css" rel="stylesheet">
    <!-- /Library Hamburgers -->
    
    <!-- base css -->
    <link rel="stylesheet" href="assets/css/base.css">
    <!-- /base css -->
    
    <!-- layout css -->
    <link rel="stylesheet" href="assets/css/layout.css">
    <!-- /layout css -->

    <!-- components css -->
    <link rel="stylesheet" href="assets/css/components.css">
    <!-- /components css -->

    <!-- sidebar css -->
    <link rel="stylesheet" href="assets/css/components/sidebar.css">
    <!-- /sidebar.css -->
</head>
<body>
    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2 class="header-title">Menu</h2>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="user.php"><i class="fas fa-user-circle"></i> Perfil</a>
            </li>

            <li class="nav-item-dropdown" id="pda-menu">
                <a href="#" class="dropdown-toggle">
                    <span><i class="fas fa-memory"></i> PDA</span>
                    <i class="fas fa-caret-down caret"></i>
                </a>
                <ul class="submenu">
                    <li><a href="registerProduct.php">Cadastrar Produto</a></li>
                    <li><a href="index.php">Editar Produto</a></li>
                    <li><a href="deleteProduct.php">Excluir Produto</a></li>
                </ul>
            </li>

            <li class="hokage-only" id="hokage-menu" style="display: none;">
                <a href="painelHokage.php"><img src="assets/images/logo-painel-hokage.png" alt="Icon Painel do Hokage" class="sidebar-icon"> Painel do Hokage</a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <ul class="sidebar-nav">
                <li>
                    <a href="#" id="logout-link"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="overlay" id="overlay"></div>

    <header class="main-header">
        <h1 class="header-title">
        <a href="index.php">PDA System</a>
        </h1>
        <button class="hamburger hamburger--spin" type="button" id="hamburger-menu">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>
    </header>