<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineGlobo | Registo Sessões</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
        


    <!-- Scripts -->


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/lib/datatables.js"></script>
    <script src="js/lib/sweetalert.js"></script>
    <script src="js/cinema.js"></script>
    <script src="js/filme.js"></script>
    <script src="js/sala.js"></script>
    <script src="js/sessao.js"></script>
    <script src="js/utilizador.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <link rel="stylesheet" href="css/datatables.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Oswald:wght@600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="css/datatables.css">
    <link rel="stylesheet" href="css/select2.css">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-secondary navbar-dark sticky-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="mb-0 text-primary text-uppercase"><i class="fa fa-film me-3"></i>Cineglobo</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Filmes</a>
                    <div class="dropdown-menu m-0">
                        <a href="registofilmes.php" class="dropdown-item">Registo</a>
                        <a href="listagemfilmes.php" class="dropdown-item">Listagem</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cinemas</a>
                    <div class="dropdown-menu m-0">
                        <a href="registocinemas.php" class="dropdown-item">Registo</a>
                        <a href="listagemcinemas.php" class="dropdown-item">Listagem</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Sessões</a>
                    <div class="dropdown-menu m-0">
                        <a href="#" class="dropdown-item">Registo</a>
                        <a href="listagemsessoes.php" class="dropdown-item">Listagem</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-user" style="color: #6C7293;"></i></a>
                    <div class="dropdown-menu m-0">
                        <?php if (!isset($_SESSION['username'])) : ?>
                        <a href="registoutilizadores.php" class="dropdown-item">Registo</a>
                        <?php endif; ?>
                        <?php if (!isset($_SESSION['username'])) : ?>
                        <a href="loginutilizadores.php" class="dropdown-item">Login</a>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['username'])) : ?>
                        <button type="button" class="dropdown-item" onclick="logout()">Logout</button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <?php if (isset($_SESSION['username'])) : ?>
                        <div class="nav-link d-flex align-items-center">
                            <div class="user-info text-end ms-2 ">
                                <div style="color: #6C7293; font-size: 16px;">Bem-vindo, <?php echo $_SESSION['username']; ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header-sessoes py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">Sessões</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Sessões</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Registo</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">Registo de Sessões</p>
                <h1 class="text-uppercase">Efetue aqui o registo de Sessões</h1>
            </div>
            <div class="row justify-content-center"> <!-- Center the content horizontally -->
                <div class="col-md-8"> <!-- Adjust the column size for responsiveness -->
                    <div class="card bg-dark">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-8">
                                    <label for="descricaoSessao" class="form-label">Descrição</label>
                                    <input type="text" class="form-control bg-dark text-white" id="descricaoSessao">
                                </div>
                                <div class="col-4">
                                    <label for="cinemaSessao" class="form-label">Escolha um Cinema</label>
                                    <select class="form-select bg-dark text-white" id="cinemaSessao">
    
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="filmeSessao" class="form-label">Escolha um Filme</label>
                                    <select class="form-select bg-dark text-white" id="filmeSessao">
    
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="salaSessao" class="form-label">Escolha uma Sala</label>
                                    <select class="form-select bg-dark text-white" id="salaSessao">
    
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="horarioSessao" class="form-label">Horário</label>
                                    <input type="datetime-local" class="form-control bg-dark text-white" id="horarioSessao">
                                </div>
                                <div class="col-12 text-center"> <!-- Center the button -->
                                    <button type="button" class="m-3 btn btn-primary" onclick="registaSessao()">Registar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-uppercase mb-4">Entre em Contacto</h4>
                    <div class="d-flex align-items-center mb-2">
                        <div class="btn-square bg-dark flex-shrink-0 me-3">
                            <span class="fa fa-map-marker-alt text-primary"></span>
                        </div>
                        <span>Rua de Cima, nº1, Évora</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="btn-square bg-dark flex-shrink-0 me-3">
                            <span class="fa fa-phone-alt text-primary"></span>
                        </div>
                        <span>+351 266784569</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="btn-square bg-dark flex-shrink-0 me-3">
                            <span class="fa fa-envelope-open text-primary"></span>
                        </div>
                        <span>info@exemplo.com</span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-uppercase mb-4">Acesso Rápido</h4>
                    <a class="btn btn-link" href="listagemfilmes.php">Listagem Filmes</a>
                    <a class="btn btn-link" href="listagemcinemas.php">Listagem Cinemas</a>
                    <a class="btn btn-link" href="listagemsessoes.php">Listagem Sessões</a>
                    <?php if (!isset($_SESSION['username'])) : ?>
                    <a class="btn btn-link" href="loginutilizadores.php">Login</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['username'])) : ?>
                    <a class="btn btn-link" onclick="logout()">Logout</a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-uppercase mb-4">Pesquisar</h4>
                    <div class="position-relative mb-4">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Introduza a sua pesquisa">
                        <button type="button"
                            class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Ir</button>
                    </div>
                    <div class="d-flex pt-1 m-n1">
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i
                                class="fab fa-youtube"></i></a>
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">CINEGLOBO</a>, Todos os direitos reservados.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/select2.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>