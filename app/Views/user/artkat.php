<div class="container">
    <div class="row mt-4">
        <form method="GET" action="" class="text-start col-8 offset-2 px-1 mt-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control rounded-5 px-4 py-2"
                    placeholder="Temukan berbagai artikel menarik..">
            </div>
        </form>
        <form method="GET" action="" class="text-start col-8 offset-2 px-1 mt-3 ">
            <div class="input-group">
                <select name="sort" class="form-select">
                    <option value="asc">Terlama</option>
                    <option value="desc">Terbaru</option>
                </select>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-sort"></i> Urutkan</button>
            </div>
        </form>
    </div>
</div>

<div class="container">
    <div class="row mt-4">
        <div class="col-8 offset-2">
            <?php if (!empty($articles)): ?>
                <div class="row mt-0">
                    <?php foreach ($articles as $article): ?>
                        <?php if ($article['status'] === 'aktif'): ?>
                            <div class="col-lg-4 g-3">
                                <a href="<?= base_url('/User/artikel/' . $article['id']); ?>"
                                    style="text-decoration:none; color:black;">
                                    <div class="card">
                                        <img src="/img/<?= $article['gambar'] ?>" class="card-img-top img-fluid" alt="Card Image">
                                        <div class="card-body">
                                            <h5 class="card-title fw-semibold">
                                                <?= $article['judul'] ?>
                                            </h5>
                                            <p class="card-text">
                                                <?php
                                                $timestamp = date('d M Y H:i', strtotime($article['timestamp']));
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
                                                <?= $timestamp ?>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
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
</div>