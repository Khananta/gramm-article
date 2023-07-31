<div class="row align-items-center mb-3 mt-5">
    <div class="col">
        <h1>List Artikel</h1>
        <?php if (isset($kategori_nama)): ?>
            <p>Kategori
                <?= $kategori_nama ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="col text-end">
        <a id="tambahArtikelLink" href="#" data-id-kategori="<?= $id_kategori ?>">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <span class="text">Tambah Artikel</span>
            </button>
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mendapatkan URL saat ini
            var currentURL = window.location.href;
            // Mencari posisi awal angka id_kategori
            var start = currentURL.lastIndexOf('/') + 1;
            // Mengambil angka id_kategori dari URL
            var id_kategori = currentURL.substring(start);
            // URL untuk halaman "tambahData" dengan parameter id_kategori
            var tambahDataUrl = "/Admin/addArticle?id_kategori=" + id_kategori;
            // Mengubah href pada link "Tambah Artikel"
            document.getElementById('tambahArtikelLink').href = tambahDataUrl;
        });
    </script>
</div>

<hr>

<div class="row">
    <div class="col">
        <?php if (!empty($articles)): ?>
            <table class="table">
                <tbody>
                    <?php foreach ($articles as $article): ?>
                        <tr>
                            <td class="pb-4">
                                <img src="/img/<?= $article['gambar'] ?>" alt="Card Image" width="200px" height="115px" class="rounded-1">
                            </td>
                            <td>
                                <?= $article['judul'] ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= site_url('admin/editArticle/' . $article['id']) ?>"><button
                                        class="btn btn-primary px-4" type="button">Edit</button></a>
                                <button class="btn btn-danger mx-2 px-3" type="button"
                                    onclick="konfirmasiHapus(<?= $article['id'] ?>)">Hapus</button>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mt-5 text-center fs-6 pt-5">Tidak ada data yang ditemukan.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Tambahkan ini pada bagian head halaman Anda -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<!-- Tambahkan ini sebelum tag penutup </body> -->
<script>
    // Inisialisasi CKEditor
    CKEDITOR.replace('konten');

    function konfirmasiHapus(id, id_kategori) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus artikel ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, make an AJAX request to delete the data
                fetch("<?= site_url('Admin/deleteArticle/') ?>" + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Sukses!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location = "<?= site_url('Admin/category/') ?>" + id_kategori;
                                location.reload(); // Refresh the page
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>
