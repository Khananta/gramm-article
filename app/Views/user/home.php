<?php
$is_searching = isset($_GET['search']) && !empty($_GET['search']);
?>

<!-- Search -->
<div class="container">
    <div class="row mt-4">
        <form method="GET" action="" class="col-lg-8 offset-lg-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control rounded-5 px-4 py-2" placeholder="Temukan berbagai artikel menarik.."
                    value="<?= $is_searching ? $_GET['search'] : ''; ?>">
                <!-- <button type="submit" class="btn btn-primary rounded-1"><i class="fas fa-search"></i></button> -->
            </div>
        </form>
    </div>
<!-- Search -->
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 offset-lg-2 offset-md-0 offset-sm-0">
                <?php
                $db = db_connect();
                $query = "SELECT * FROM tb_kategori WHERE status = 'aktif'";
                $result = $db->query($query);

                if (!$result) {
                    die('Koneksi ke database gagal: ' . mysqli_connect_error());
                }

                if ($result->getNumRows() > 0) {
                    foreach ($result->getResult() as $row) {
                        $id = $row->id_kategori;
                        $title = $row->nama_kategori;
                        echo '<a href="' . site_url('User/artkat/' . $id) . '" class="btn btn-outline-danger rounded-5 px-4 mt-3" style="margin-right: 16px;">' . $title . '</a>';
                    }
                } else {
                    $empty = "Tidak ada data yang ditemukan.";
                    echo '<p class="my-5 py-5 mx-5 text-center fs-6">' . $empty . '</p>';
                }
                ?>
            </div>
        </div>

    <?php if (!$is_searching): ?>
        <div class="row mt-3">
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

                $query_popular = "SELECT * FROM tb_artikel WHERE status = 'aktif' ORDER BY RAND() LIMIT 1";
                $result_popular = mysqli_query($conn, $query_popular);

                if ($result_popular):
                    $active_indicator = true;
                    $slide_number = 0;
                    ?>
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-indicators">
                            <?php
                            while ($row_popular = mysqli_fetch_assoc($result_popular)):
                                $image_popular_slide = '/img/' . $row_popular['gambar'];
                                $title_popular_slide = $row_popular['judul'];
                                $article_id = $row_popular['id'];
                                ?>

                                <button type="button" data-bs-target="#carouselExampleCaptions"
                                    data-bs-slide-to="<?= $slide_number; ?>" class="<?= ($active_indicator ? 'active' : ''); ?>"
                                    aria-current="<?= ($active_indicator ? 'true' : 'false'); ?>"
                                    aria-label="Slide <?= $slide_number + 1; ?>"></button>

                                <?php
                                $active_indicator = false;
                                $slide_number++;
                            endwhile;
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

                            $query_popular_slide = "SELECT * FROM tb_artikel WHERE status = 'aktif' ORDER BY RAND() LIMIT 3";
                            $result_popular_slide = mysqli_query($conn, $query_popular_slide);

                            if ($result_popular_slide):
                                $active_slide = true;
                                ?>
                                <?php while ($row_popular_slide = mysqli_fetch_assoc($result_popular_slide)): ?>
                                    <a href="<?= base_url('user/artikel/' . $row_popular_slide['id']); ?>"
                                        style="text-decoration: none;">
                                        <div class="carousel-item <?= ($active_slide ? 'active' : ''); ?>">
                                            <img src="<?= '/img/' . $row_popular_slide['gambar']; ?>" class="d-block w-100 rounded-2"
                                                alt="Sampul <?= $slide_number; ?>" />
                                            <div class="carousel-caption d-none d-md-block">
                                                <h5>
                                                    <?= $row_popular_slide['judul']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                    $active_slide = false;
                                endwhile;
                                mysqli_free_result($result_popular_slide);
                                mysqli_close($conn);
                            endif;
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row mt-4">
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

        $query = "SELECT k.id_kategori, k.nama_kategori, a.id AS artikel_id, a.judul, a.konten, a.gambar, a.timestamp
            FROM (
                SELECT id, judul, konten, gambar, timestamp, id_kategori,
                ROW_NUMBER() OVER (PARTITION BY id_kategori ORDER BY timestamp DESC) AS row_num 
                FROM tb_artikel
                WHERE judul LIKE '%$search%' AND status = 'aktif'
            ) a 
            INNER JOIN tb_kategori k ON a.id_kategori = k.id_kategori
            WHERE a.row_num <= 2 AND k.status = 'aktif'
            ORDER BY k.id_kategori, a.id";

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0):
            $current_kategori = null;
            ?>
            <div class="row justify-content-center">
                <?php
                while ($row = mysqli_fetch_assoc($result)):
                    $kategori_id = $row['id_kategori'];
                    $kategori_nama = $row['nama_kategori'];
                    $title = $row['judul'];
                    $content = $row['konten'];
                    $timestamp = $row['timestamp'];
                    $image = '/img/' . $row['gambar'];
                    $article_id = $row['artikel_id'];

                    $uploadedDate = date('d M Y', strtotime($timestamp));

                    if ($kategori_id !== $current_kategori):
                        ?>
                    </div>
                    <div class="row mt-5 align-items-center">
                        <div class="col">
                            <h2 class="mb-3 fw-semibold">
                                <?= $kategori_nama ?>
                            </h2>
                        </div>
                        <div class="col text-end">
                            <a href="/User/artkat/<?= $kategori_id ?>"
                                class="btn btn-link text-decoration-none text-danger fw-semibold text-end px-0">Lihat Semua </a>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $current_kategori = $kategori_id;
                    endif;
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
                                        <i class="fa-solid fa-calendar-days text-muted"></i>
                                        <?= $uploadedDate ?>
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                endwhile;
                ?>
            </div>
        <?php else: ?>
            <p class="text-center mt-4">Tidak ada data yang ditemukan.</p>
            <?php
        endif;

        mysqli_close($conn);
        ?>
    </div>
</div>