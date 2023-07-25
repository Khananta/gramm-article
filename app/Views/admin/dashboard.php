<div class="row align-items-center mb-3 mt-5">
    <div class="col">
        <h1>List Artikel</h1>
    </div>
    <div class="col text-end">
        <a href="<?= site_url('Admin/tambahData') ?>" style="text-decoration: none;">
            <button type="submit" class="btn btn-primary">Tambah Artikel</button>
        </a>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Kategori
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?= site_url('Admin/tambahkategori') ?>">
                            <div class="input-group">
                                <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan Judul Kategori.."
                                    required>
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
    </div>
    <form method="GET" action="" class="pt-4">
        <div class="input-group mb-2">
            <input type="text" name="search" class="form-control" placeholder="Cari artikel">
        </div>
    </form>
</div>

<div class="row">
    <div>
        <table class="table">
            <?php

            // Mendapatkan instance dari database
            $db = db_connect();

            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Query untuk melakukan pencarian
            $query = "SELECT * FROM tb_artikel WHERE judul LIKE '%$search%' OR konten LIKE '%$search%'";
            $result = $db->query($query);

            if (!$result) {
                die('Query tidak berhasil: ' . $db->error());
            }

            if ($result->getNumRows() > 0) {
                foreach ($result->getResult() as $row) {
                    $id = $row->id;
                    $title = $row->judul;
                    $image = '/img/' . $row->gambar;
                    $timestamp = $row->timestamp; // Kolom timestamp pada tabel
            
                    // Mengubah format timestamp menjadi format tanggal dan jam yang sesuai
                    $uploadedDate = date('d/m/Y', strtotime($timestamp));
                    $uploadedTime = date('H:i', strtotime($timestamp));

                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>';
                    echo '<img src="' . $image . '" alt="Card Image" width="180px" class="rounded-1">';
                    echo '</td>';
                    echo '<td>' . $title . '</td>';
                    echo '<td>';
                    echo '<a href="' . site_url('admin/edit_data/' . $row->id) . '"><button class="btn btn-primary px-4" type="button">Edit</button></a>';
                    echo '<a href="' . site_url('admin/hapus/' . $row->id) . '"><button class="btn btn-danger mx-2 px-3" type="button">Hapus</button></a>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</tbody>';
                }
            } else {
                $empty = "Tidak ada data yang ditemukan.";
                echo '<p class="mt-5 text-center fs-6 pt-5">' . $empty . '</p>';
            }
            ?>
        </table>
    </div>
</div>