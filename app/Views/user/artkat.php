<div class="row mt-4">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="text-start col-8 offset-2 px-1">
        <div class="input-group">
            <?php
            $search = isset($_POST['search']) ? $_POST['search'] : '';
            ?>
            <input type="text" name="search" class="form-control" placeholder="Temukan berbagai artikel menarik.."
                value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                    // Batasi max length konten menjadi 50 karakter
                                    $max_length = 50;
                                    $konten = $article['konten'];
                                    if (strlen($konten) > $max_length) {
                                        $konten = substr($konten, 0, $max_length) . '...';
                                    }
                                    echo $konten;
                                    ?>
                                </p>
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