<div class="row align-items-center mb-3 mt-5">
    <div class="col-lg-12">
        <a href="/dashboard" style="text-decoration:none;" class="fs-5"><i
                class="fa-solid mb-4 fa-arrow-left text-decoration:none;"></i> Kembali</a>
        <h1>List Artikel</h1>
        <?php if (isset($kategori_nama)): ?>
            <p>Kategori
                <?= $kategori_nama ?>
            </p>
        <?php endif; ?>
    </div>

    <form class="col-lg-12 mt-3">
        <div class="input-group">
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Temukan artikel..">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var currentURL = window.location.href;
            var start = currentURL.lastIndexOf('/') + 1;
            var id_kategori = currentURL.substring(start);
            var tambahDataUrl = "/addarticle?id_kategori=" + id_kategori;
            document.getElementById('tambahArtikelLink').href = tambahDataUrl;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var currentURL = window.location.href;
            var start = currentURL.lastIndexOf('/') + 1;
            var id_kategori = currentURL.substring(start);
            var tambahDataUrl = "/deletearticle?id_kategori=" + id_kategori;
            document.getElementById('hapusArtikelLink').href = tambahDataUrl;
        });
    </script>
</div>


<div class="card mt-4">
    <div class="card-header col text-start">
        <div class="row">
            <div class="col-6">
                <a id="tambahArtikelLink" href="#" data-id-kategori="<?= $id_kategori ?>">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span class="text"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Tambah
                            Artikel</span>
                    </button>
                </a>
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-danger" onclick="konfirmasiHapusMultiple()"><i
                        class="fa-solid fa-trash" style="color: #ffffff;"></i> Hapus Artikel Terpilih</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form id="delete-form" action="<?= site_url('/deletearticle') ?>" method="post">
            <?php if (!empty($articles)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>No.</th>
                            <th>Nama Artikel</th>
                            <th>Terakhir Update</th>
                            <th>Pembuat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="article_to_delete[]" value="<?= $article['id'] ?>"
                                        id="hapusArtikelLink">
                                </td>
                                <td>
                                    <?= $counter++; ?>
                                </td>
                                <td class="col-4">
                                    <p>
                                        <?= $article['judul'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?= $article['last_updated'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?= $article['pembuat'] ?>
                                    </p>
                                </td>
                                <td><span
                                        class="status-indicator <?= $article['status'] === 'aktif' ? 'aktif' : 'nonaktif' ?> mx-3"></span>
                                </td>
                                <td>
                                    <a href="<?= site_url('/editarticle/' . $article['id']) ?>"><button
                                            class="btn btn-primary px-4" type="button">Edit</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="mt-5 text-center fs-6 pt-5 mb-5 pb-5">Tidak ada data yang ditemukan.</p>
            <?php endif; ?>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('konten');

    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('searchInput');
        const articleRows = document.querySelectorAll('.table tbody tr');

        searchInput.addEventListener('input', () => {
            const searchKeyword = searchInput.value.trim().toLowerCase();

            articleRows.forEach(row => {
                const titleCell = row.querySelector('.col-4 p');
                const title = titleCell.textContent.trim().toLowerCase();

                if (title.includes(searchKeyword)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('input[name="article_to_delete[]"]');

    selectAllCheckbox.addEventListener('change', () => {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    function konfirmasiHapusMultiple() {
        const selectedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

        if (selectedCheckboxes.length === 0) {
            Swal.fire({
                title: 'Tidak ada data yang dipilih',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data kategori terpilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteForm = document.getElementById('delete-form');
                    const formData = new FormData(deleteForm);

                    fetch(deleteForm.action, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message,
                                    icon: 'error',
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
    }
</script>