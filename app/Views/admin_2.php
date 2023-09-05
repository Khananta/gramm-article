<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Link Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Menambahkan link ke CSS FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <link rel="shortcut icon" href="/img/LogoNew.png">

    <title>Gramm</title>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #111111;">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <span style="font-family: 'Inter'; font-weight: bold; color: red;">Gra</span><span
                    style="font-family: 'Inter'; font-weight: bold; color: white;">mm
                    <span style="font-family: 'Inter'; font-weight: bold; color: white;">- Admin</span>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto nav">
                    <li class="nav-item">
                        <a class="nav-link <?= ($current_page === 'dashboard') ? 'active' : '' ?>"
                            href="/dashboard">Beranda</a>
                    </li>
                </ul>
                <a href="/logout">
                    <button class="btn btn-primary px-4 col-sm-12 my-lg-0 mt-1 mb-2">Logout</button>
                </a>
            </div>
        </div>
    </nav>
    <!-- AKHIR NAVBAR -->
    <div class="container-fluid g-0">
        <?php if (!empty($admin) && !isset($_SESSION['alert_shown'])): ?>
            <div class="alert alert-success" id="welcome-alert">
                <p class="mb-0 text-center">Selamat datang,
                    <?= $admin['nama'] ?>!
                </p>
            </div>
            <?php $_SESSION['alert_shown'] = true; ?>
        <?php endif; ?>
    </div>
    <div class="contain container">
        <div>
            <?php
            if ($page) {
                echo view($page);
            }
            ?>
        </div>
    </div>
    <footer>
        <div class="container-fluid  mt-5" style="background-color: #EEEDED;">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="text-center m-3">© Copyright 2023</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- LINK JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
        </script>
</body>

</html>