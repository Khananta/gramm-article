<div class="container">
    <div class="row mt-4">
        <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="text-start col-lg-8 offset-lg-2">
            <div class="input-group">
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                ?>
                <input type="text" name="search" class="form-control" placeholder="Temukan berbagai artikel menarik.."
                    value="<?php echo $search; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <?php
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            // Tampilkan hasil pencarian di sini
        } else {
            // Tampilkan carousel berita populer
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $database = 'artikel';

            $conn = mysqli_connect($host, $user, $password, $database);
            if (!$conn) {
                die('Koneksi ke database gagal: ' . mysqli_connect_error());
            }

            // Query untuk mendapatkan 3 data berita populer secara acak
            $query_popular = "SELECT * FROM tb_artikel ORDER BY RAND() LIMIT 3";
            $result_popular = mysqli_query($conn, $query_popular);

            if (!$result_popular) {
                die('Query tidak berhasil: ' . mysqli_error($conn));
            }
            ?>
            <div class="col-lg-8 col-md-12 offset-lg-2 mt-3">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        <?php } ?>
    </div>
</div>