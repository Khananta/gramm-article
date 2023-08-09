<div class="container">
    <div class="row mt-4">
        <form method="GET" action="" class="text-start col-8 offset-2 px-1">
            <div class="input-group">
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
                
                if (!empty($search)) {
                    $query = "SELECT * FROM tb_artikel WHERE judul LIKE '%$search%'";
                    $result = mysqli_query($conn, $query);

                    // mengambil hasil pencarian dan menyimpannya dalam array $articles
                    $articles = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $articles[] = $row;
                    }
                }
                ?>

                <input type="text" name="search" class="form-control" placeholder="Temukan berbagai artikel menarik.."
                    value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <form method="GET" action="" class="text-start col-3 offset-7 px-1 mt-5">
            <div class="input-group">
                <select name="sort" class="form-select">
                        <option value="asc">Terlama</option>
                        <option value="desc">Terbaru</option>
                </select>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-sort"></i> Urutkan</button>
            </div>
        </form>
    </div>
    <div class="col-8 offset-2">
            <?php if (!empty($articles)): ?>
                <div class="row mt-0">
                    <?php foreach ($articles as $article): ?>
                        <div class="col-lg-4 g-3">
                            <a href="<?php echo base_url('/User/artikel/' . $article['id']); ?>"
                                style="text-decoration:none; color:black;">
                                <div class="card">
                                    <img src="/img/<?= $article['gambar'] ?>" class="card-img-top img-fluid" alt="Card Image">
                                    <div class="card-body">
                                        <h5 class="card-title fw-semibold">
                                            <?= $article['judul'] ?>
                                        </h5>
                                        <p class="card-text">
                                            <?php
                                            // batasi max length konten menjadi 50 karakter
                                            $timestamp = date('d M Y', strtotime($article['timestamp']));
                                            $timestamps = date('H:i', strtotime($article['timestamp']));
                                            $max_length = 50;
                                            $konten = $article['konten'];
                                            if (strlen($konten) > $max_length) {
                                                $konten = substr($konten, 0, $max_length) . '...';
                                            }
                                            echo $konten;
    
                                            ?>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted">
                                            <i class="fa-solid fa-calendar-days text-muted"></i>
                                            <?= $timestamp ?> <?= $timestamps ?>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <p class="mt-5 text-center fs-6 pt-5">Tidak ada data yang ditemukan.</p>
                    </div>
                </div>
            <?php endif; ?>
    </div>
</div>