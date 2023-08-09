<h1 class="fw-bolder my-5 text-center">Kumpulan Kategori</h1>

<div class="card">
    <div class="card-header col text-start">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <span class="text">Tambah Kategori</span>
        </button>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= site_url('Admin/addCategory') ?>">
                        <div class="input-group">
                            <input type="text" name="nama_kategori" class="form-control"
                                placeholder="Masukkan Judul Kategori.." required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body text-center pt-0">
        <div class="row">
            <?php
            $db = db_connect();
            $query = "SELECT * FROM tb_kategori";
            $result = $db->query($query);

            if (!$result || $result->getNumRows() === 0) {
                echo '<p class="mt-5 mb-5 pb-5 text-center fs-6 pt-5">Tidak ada data yang ditemukan.</p>';
            } else {
                foreach ($result->getResult() as $row) {
                    $id = $row->id_kategori;
                    $title = $row->nama_kategori;
                    ?>
                    <div class="col-lg-3 g-4">
                        <div class="card">
                            <div class="card-body">
                                <a href="<?= site_url('Admin/category/' . $id) ?>" style="text-decoration: none; color:black">
                                    <p>
                                        <?= $title ?>
                                    </p>
                                </a>
                                <button class="btn btn-danger mx-2 px-3" type="button"
                                    onclick="konfirmasiHapus(<?= $id ?>)">Hapus</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus kategori ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("<?= site_url('Admin/deleteCategory/') ?>" + id)
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: data.status === 'success' ? 'Sukses!' : 'Error!',
                            text: data.message,
                            icon: data.status === 'success' ? 'success' : 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (data.status === 'success') {
                                window.location = "<?= site_url('Admin/dashboard') ?>";
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    }
</script>