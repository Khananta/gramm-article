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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">


    <title>Login Admin</title>
</head>
<!-- 
<div class="container">
    <div class="row">
        <div class="col-1 offset-5">
        <img src="/img/Gramm_Logo.png" alt="Logo" class="img-fluid mx-5 mt-4">
        </div>
    </div>
</div> -->

<body class="bg-dark">
    <div class="mt-5 offset-4">
        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-6 bg-secondary bg-opacity-25 p-5 rounded-3">
                    <h2 class="fw-bold text-light">Login</h2>

                    <form method="post" action="<?= site_url('/Auth/login') ?>">
                        <div class="mt-4">
                            <label class="form-label text-light">Username</label>
                            <input type="text" name="username" placeholder="Masukan username kamu" class="form-control" required>
                        </div>
                        <div class="mt-4">
                            <label for="exampleInputPassword1" class="form-label text-light">Password</label>
                            <input type="password" name="password" placeholder="Masukan password kamu" class="form-control" id="exampleInputPassword1" required>
                        </div>
                        <button type="submit" class="btn btn-danger rounded-2 px-5 mt-5 col-12">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- LINK JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
        </script>
</body>

</html>