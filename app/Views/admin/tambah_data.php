<div class="container">
    <div class="row mt-4">
        <h4 class="display-6 mb-3 fw-semibold">Tambah Artikel</h4>
        <form method="post" action="<?= site_url('Admin/simpanData') ?>" class="col-lg-12 mb-4"
            enctype="multipart/form-data">
            <div class="input-group">
                <input type="text" name="judul" class="form-control" placeholder="Judul Artikel" required>
            </div>
            <div class="input-group mt-2 col-6">
                <textarea name="konten" class="form-control" placeholder="Konten Artikel" id="konten"
                    required></textarea>
            </div>
            <div class="form-group mt-2 col-6">
                <label class="fw-semibold mt-2">Pilih Kategori:</label><br>
                <?php
                $host = 'localhost';
                $user = 'root';
                $password = '';
                $database = 'artikel';

                $conn = mysqli_connect($host, $user, $password, $database);
                if (!$conn) {
                    die('Koneksi ke database gagal: ' . mysqli_connect_error());
                }

                // Query untuk mendapatkan data kategori
                $query = "SELECT * FROM tb_kategori";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die('Query tidak berhasil: ' . mysqli_error($conn));
                }

                // Looping untuk menampilkan radio button untuk setiap opsi kategori
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_kategori = $row['id_kategori'];
                    $nama_kategori = $row['nama_kategori'];
                    echo '<div class="form-check">';
                    echo '<input class="form-check-input" type="radio" name="kategori" id="kategori' . $id_kategori . '" value="' . $id_kategori . '">';
                    echo '<label class="form-check-label" for="kategori' . $id_kategori . '">' . $nama_kategori . '</label>';
                    echo '</div>';
                }
                ?>
            </div>


            <div class="input-group mt-4">
                <input type="file" name="gambar" class="form-control" required>
            </div>
            <div class="mt-4 text-end">
                <a href="/Admin/dashboard" class ="btn btn-danger" style="text-decoration: none;">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan ini pada bagian head halaman Anda -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<!-- Tambahkan ini sebelum tag penutup </body> -->
<script>
    // Inisialisasi CKEditor
    CKEDITOR.replace('konten');
</script>