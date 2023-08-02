<div class="container">
    <div class="row mt-4">
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Temukan berbagai artikel menarik.."
                    value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <div class="col-lg-8 col-md-12 offset-lg-2 mt-3">
            <?php
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'artikel';

            $conn = mysqli_connect($host, $user, $password, $database);
            if (!$conn) {
                die('Koneksi ke database gagal: ' . mysqli_connect_error());
            }

            // Query untuk mendapatkan 3 data berita populer secara acak
            $query_popular = "SELECT * FROM tb_artikel ORDER BY RAND() LIMIT 1";
            $result_popular = mysqli_query($conn, $query_popular);

            if (!$result_popular) {
                die('Query tidak berhasil: ' . mysqli_error($conn));
            }
            ?>

            <div id="carouselExampleCaptions" class="carousel slide mt-4" data-bs-ride="false">
                <div class="carousel-indicators">
                    <?php
                    $active_indicator = true;
                    $slide_number = 0;

                    while ($row_popular = mysqli_fetch_assoc($result_popular)) {
                        $image_popular_slide = '/img/' . $row_popular['gambar'];
                        $title_popular_slide = $row_popular['judul'];
                        $article_id = $row_popular['id']; // Simpan ID artikel
                        ?>

                        <button type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide-to="<?php echo $slide_number; ?>"
                            class="<?php echo ($active_indicator ? 'active' : ''); ?>"
                            aria-current="<?php echo ($active_indicator ? 'true' : 'false'); ?>"
                            aria-label="Slide <?php echo $slide_number + 1; ?>"></button>

                        <?php
                        $active_indicator = false;
                        $slide_number++;
                    } // End while loop
                    mysqli_free_result($result_popular);
                    mysqli_close($conn);
                    ?>
                </div>

                <div class="carousel-inner">
                    <?php
                    $conn = mysqli_connect($host, $user, $password, $database);
                    if (!$conn) {
                        die('Koneksi ke database gagal: ' . mysqli_connect_error());
                    }

                    // Query untuk mendapatkan 3 data berita populer secara acak (slide)
                    $conn = mysqli_connect($host, $user, $password, $database);
                    $query_popular_slide = "SELECT * FROM tb_artikel ORDER BY RAND() LIMIT 3";
                    $result_popular_slide = mysqli_query($conn, $query_popular_slide);

                    if (!$result_popular_slide) {
                        die('Query tidak berhasil: ' . mysqli_error($conn));
                    }

                    $active_slide = true;
                    while ($row_popular_slide = mysqli_fetch_assoc($result_popular_slide)) {
                        $image_popular_slide = '/img/' . $row_popular_slide['gambar'];
                        $title_popular_slide = $row_popular_slide['judul'];
                        $article_id_slide = $row_popular_slide['id']; // Simpan ID artikel
                    
                        // Tambahkan link untuk mengarahkan ke halaman artikel berdasarkan ID
                        ?>

                        <a href="<?php echo base_url('user/artikel/' . $article_id_slide); ?>"
                            style="text-decoration: none;">
                            <div class="carousel-item <?php echo ($active_slide ? 'active' : ''); ?>">
                                <img src="<?php echo $image_popular_slide; ?>" class="d-block w-100 rounded-2"
                                    alt="Sampul <?php echo $slide_number; ?>" />
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>
                                        <?php echo $title_popular_slide; ?>
                                    </h5>
                                </div>
                            </div>
                        </a>
                        <?php

                        $active_slide = false;
                    } // End while loop
                    mysqli_free_result($result_popular_slide);
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
        <?php ?>

        <?php
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'artikel';

        $conn = mysqli_connect($host, $user, $password, $database);
        if (!$conn) {
            die('Koneksi ke database gagal: ' . mysqli_connect_error());
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Query untuk mengambil data artikel dan kategori serta mengelompokkan artikel berdasarkan kategori dengan batasan 3 artikel per kategori
        $query = " SELECT k.id_kategori, k.nama_kategori, a.id AS artikel_id, a.judul, a.konten, a.gambar
                FROM ( SELECT id, judul, konten, gambar, id_kategori,
                    ROW_NUMBER() OVER (PARTITION BY id_kategori ORDER BY id) AS row_num FROM tb_artikel
                    WHERE judul LIKE '%$search%' OR konten LIKE '%$search%'
                    ) a INNER JOIN tb_kategori k ON a.id_kategori = k.id_kategori
                        WHERE a.row_num <= 3
                        ORDER BY k.id_kategori, a.id";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            die('Query tidak berhasil: ' . mysqli_error($conn));
        }

        $current_kategori = null;
        if (mysqli_num_rows($result) > 0) {
            ?>
            <div class="row justify-content-center">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $kategori_id = $row['id_kategori'];
                    $kategori_nama = $row['nama_kategori'];
                    $title = $row['judul'];
                    $content = $row['konten'];
                    $upload_date = $row['timestamp'];
                    $image = '/img/' . $row['gambar'];
                    $article_id = $row['artikel_id'];

                    if ($kategori_id !== $current_kategori) {
                        ?>
                    </div>
                    <div class="row mt-5 align-items-center">
                        <div class="col">
                            <h2 class="mb-3 fw-semibold">
                                <?= $kategori_nama ?>
                            </h2>
                        </div>
                        <div class="col text-end">
                            <a href="/User/artkat/<?= $kategori_id ?>" class="btn btn-link text-decoration-none text-danger fw-semibold text-end ">Lihat
                                Semua </a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <?php
                        $current_kategori = $kategori_id;
                    }

                    // tampilkan artikel dalam setiap kategori
                    ?>
                <div class="col-lg-4">
                <a href="/User/artikel/<?= $article_id ?>" style="text-decoration: none;">
                    <div class="card h-100">
                        <img src="<?= $image ?>" class="card-img-top img-fluid" alt="Sampul">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $title ?>
                            </h5>
                            <p class="card-text mb-0">
                                <?= substr($content, 0, 80) ?>...
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <?= $upload_date ?>
                            </small>
                        </div>
                    </div>
                </a>
                </div>

                <?php
                }
                ?>
            </div>
            <?php
        } else {
            echo 'Tidak ada data yang ditemukan.';
        }

        mysqli_close($conn);
        ?>
    </div>
</div>