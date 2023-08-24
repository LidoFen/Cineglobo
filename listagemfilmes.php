<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineGlobo | Listagem Filmes</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->

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

    <script src="js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/lib/sweetalert.js"></script>
    <script src="js/filme.js"></script>
    <script src="js/utilizador.js"></script>
    <script src="js/datatables.js"></script>
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
                    <a href="#" class="nav-link active dropdown-toggle" data-bs-toggle="dropdown">Filmes</a>
                    <div class="dropdown-menu m-0">
                        <?php if (isset($_SESSION['username'])) : ?>
                            <a href="registofilmes.php" class="dropdown-item">Registo</a>
                        <?php endif; ?>
                        <a href="#" class="dropdown-item">Listagem</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Cinemas</a>
                    <div class="dropdown-menu m-0">
                        <?php if (isset($_SESSION['username'])) : ?>
                            <a href="registocinemas.php" class="dropdown-item">Registo</a>
                        <?php endif; ?>
                        <a href="listagemcinemas.php" class="dropdown-item">Listagem</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Sessões</a>
                    <div class="dropdown-menu m-0">
                        <?php if (isset($_SESSION['username'])) : ?>
                            <a href="registosessoes.php" class="dropdown-item">Registo</a>
                        <?php endif; ?>
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
    <div class="container-fluid page-header-movies py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-3 text-white text-uppercase mb-3 animated slideInDown">Filmes</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Filmes</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Listagem</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="d-inline-block bg-secondary text-primary py-1 px-4">Listagem de Filmes</p>
                <h1 class="text-uppercase">Conheça a nossa coleção</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <p>Pesquise aqui pelos seus filmes favoritos</p>
                    <input type="text" id="barraPesquisa" class="form-control mt-3 col-md-6 bg-dark text-white" placeholder="">
                </div>
            </div>
            <div class="row g-4 d-flex flex-wrap mt-5" id="listaFilmes">

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
                    <a class="btn btn-link" href="#">Listagem Filmes</a>
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
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Ir</button>
                    </div>
                    <div class="d-flex pt-1 m-n1">
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-lg-square btn-dark text-primary m-1" href=""><i class="fab fa-linkedin-in"></i></a>
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


    <div class="modal fade" id="modalFilmeEdit" tabindex="-1" aria-labelledby="modalFilmeEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: #191C24;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalFilmeEditLabel">Edição de Filme</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="card" style="border: black;">
                            <h5 class="card-header" style="background-color: #191C24;">Edite aqui as informações do Filme</h5>
                            <div class="card-body" style="background-color: #1f2127;">
                                <form class="row g-3">
                                    <div class="col-12">
                                        <label for="nomeFilmeEdit" class="form-label">Nome</label>
                                        <input type="text" class="form-control bg-dark text-white" id="nomeFilmeEdit">
                                    </div>
                                    <div class="col-12">
                                        <label for="descricaoFilmeEdit" class="form-label">Descrição</label>
                                        <textarea class="form-control bg-dark text-white" placeholder="" id="descricaoFilmeEdit" style="height: 100px"></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="selectTipoFilmeEdit" class="form-label">Tipo</label>
                                        <select class="form-select bg-dark text-white" id="selectTipoFilmeEdit">

                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="cartazFilmeEdit" class="form-label">Cartaz</label>
                                        <input type="file" class="form-control bg-dark text-white" id="cartazFilmeEdit">
                                    </div>
                                    <div class="mt-3 d-flex justify-content-center">
                                        <img id="cartazPreviewEdit" src="#" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 300px; display: none;">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnGuardar1">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalFilmeInfo" tabindex="-1" aria-labelledby="modalFilmeInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: #191C24;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalFilmeInfoLabel">Informação do Filme</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="card" style="border: black;">
                            <h5 class="card-header" style="background-color: #191C24;">Consulte aqui todas as informações do Filme</h5>
                            <div class="card-body" style="background-color: #1f2127;">

                                <table class="table table-striped" id="tabelaFilmeInfo">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Cartaz</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaFilmeInfo">

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: #191C24;">
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="w-100" id="trailerVideo" height="720px" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cartazInput = document.getElementById('cartazFilmeEdit');
            const cartazPreview = document.getElementById('cartazPreviewEdit');

            cartazInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        cartazPreview.src = e.target.result;
                        cartazPreview.style.display = 'block'; // Mostra a preview

                    };
                    reader.readAsDataURL(file);
                } else {

                    cartazPreview.src = "#";
                    cartazPreview.style.display = 'none'; // Esconde a preview
                }
            });
        });
    </script>

</body>

</html>