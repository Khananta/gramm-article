<h1 class="fw-bolder my-5 text-center">Kumpulan Kategori</h1>

<form class="col-lg-12 mt-3 mb-3" method="get">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Temukan artikel.."
            value="<?= htmlspecialchars($searchKeyword) ?>">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
    </div>
</form>

<div class="card">
    <div class="card-header col text-start">
        <div class="row">
            <!-- Button Tambah -->
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="text"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Tambah Kategori</span>
                </button>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?= site_url('/addcategory') ?>">
                                <div class="mb-3 mt-2">
                                    <label class="form-label">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" class="form-control"
                                        placeholder="Masukkan Judul Kategori.." pattern="^\S(.*\S)?$"
                                        title="Tidak boleh mengisi spasi atau mengosongkan field" required>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
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
            <div class="col-6 text-end">
                <button type="button" class="btn btn-danger" onclick="konfirmasiHapusMultiple()"><i
                        class="fa-solid fa-trash" style="color: #ffffff;"></i> Hapus Kategori Terpilih</button>
            </div>
        </div>
    </div>
</div>

<div class="card table-responsive">
    <div class="card-body">
        <form id="delete-form" action="<?= site_url('/deletecategory') ?>" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Terakhir Update</th>
                        <th>Jumlah Artikel</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = ($currentPage - 1) * $itemsPerPage + 1; ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="category_to_delete[]" value="<?= $category['id_kategori'] ?>">
                            </td>
                            <td>
                                <?= $counter++; ?>
                            </td>
                            <td>
                                <a href="<?= site_url('/article/' . $category['id_kategori']) ?>"
                                    style="text-decoration: none; color:black">
                                    <?= $category['nama_kategori']; ?>
                                </a>
                            </td>
                            <td>
                                <?= $category['last_updated']; ?>
                            </td>
                            <td>
                                <span class="mx-5">
                                    <?= $articleCounts[$category['id_kategori']] ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <span
                                    class="status-indicator <?= $category['status'] === 'aktif' ? 'aktif' : 'nonaktif' ?> mx-3"></span>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="openEditModal(
                                    '<?= $category['id_kategori'] ?>',
                                    '<?= $category['nama_kategori'] ?>',
                                    '<?= $category['status'] ?>'
                                )">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="fw-bold"><i class="fa-solid fa-bookmark"></i>
                <?= $totalCategories ?> Kategori
            </p>
            <p class="fw-bold"><i class="fa-solid fa-bookmark"></i>
                <?= $count ?> Artikel
            </p>
        </form>
    </div>
</div>

<div class="pagination">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li
                class="page-item <?= $i === (isset($_GET['halaman-ke']) ? (int) $_GET['halaman-ke'] : 1) ? 'active' : '' ?>">
                <a class="page-link" href="<?= site_url('/dashboard?halaman-ke=' . $i) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="<?= site_url('/editcategory') ?>" method="post"
                    onsubmit="return validateForm()">
                    <input type="hidden" name="kategori_id" id="edit-kategori-id">
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" name="edit_nama" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-status" class="form-label">Status</label>
                        <select name="edit_status" id="edit-status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="confirmSave()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?php
$response = session()->getFlashdata('response');
if ($response && $response['status'] === 'success'):
    ?>
    <script>
        Swal.fire({
            title: "Sukses!",
            text: "<?= $response['message']; ?>",
            icon: "success",
            button: "OK",
        });
    </script>
<?php endif; ?>

<script>
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('input[name="category_to_delete[]"]');

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

    function openEditModal(id_kategori, nama_kategori, status) {
        const editForm = document.getElementById('edit-form');
        document.getElementById('edit-kategori-id').value = id_kategori;
        document.getElementById('edit-nama').value = nama_kategori;
        document.getElementById('edit-status').value = status;

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function confirmSave() {
        const judulValue = document.getElementById("edit-nama").value.trim();
        const editForm = document.getElementById('edit-form');
        const statusDropdown = document.getElementById('edit-status');

        const selectedStatus = statusDropdown.value;

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'edit_status';
        statusInput.value = selectedStatus;

        editForm.appendChild(statusInput);

        if (!judulValue.replace(/<[^>]*>|&nbsp;|\s/g, '').trim()) {
            Swal.fire({
                title: 'Data tidak boleh kosong!',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok',
            });
            return false;
        }

        Swal.fire({
            title: 'Apakah Anda yakin ingin menyimpan perubahan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form via AJAX to handle the response
                fetch(editForm.action, {
                    method: 'POST',
                    body: new FormData(editForm),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Success message
                            Swal.fire({
                                title: 'Sukses!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Redirect or perform any necessary action
                                window.location.reload(); // Example: Reload the page
                            });
                        } else {
                            // Error message
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
</script>

<!-- Add this script to display SweetAlert messages -->
<script>
    <?php if (session()->has('response')): ?>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if (session('response')['status'] === 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '<?= session('response')['message'] ?>',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            <?php elseif (session('response')['status'] === 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '<?= session('response')['message'] ?>',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    <?php endif; ?>
</script>