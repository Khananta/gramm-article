<h1 class="fw-bolder my-5 text-center">Kumpulan Kategori</h1>

<div class="card">
    <div class="card-header col text-start">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <span class="text">Tambah Kategori</span>
        </button>
    </div>

    <!-- Modal -->
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
            // Mendapatkan instance dari database
            $db = db_connect();

            // Query untuk melakukan pencarian
            $query = "SELECT * FROM tb_kategori";
            $result = $db->query($query);

            if (!$result) {
                die('Query tidak berhasil: ' . $db->error());
            }

            if ($result->getNumRows() > 0) {
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
            } else {
                $empty = "Tidak ada data yang ditemukan.";
                echo '<p class="mt-5 mb-5 pb-5 text-center fs-6 pt-5">' . $empty . '</p>';
            }
            ?>
        </div>
    </div>
</div>
<!-- Add this in the head section of your HTML file -->

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
                // If the user confirms, make an AJAX request to delete the data
                fetch("<?= site_url('Admin/deleteCategory/') ?>" + id)
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
                                window.location = "<?= site_url('Admin/dashboard') ?>";
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

