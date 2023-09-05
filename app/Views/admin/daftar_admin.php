<h1 class="fw-bolder my-5 text-center">Manajemen Admin</h1>

<div class="card">
    <div class="card-header col text-start">
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="text"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Tambah Admin</span>
                </button>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Admin</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('register') ?>" method="post">
                                <div class="mb-3 mt-4">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control" pattern="^\S(.*\S)?$"
                                        title="Tidak boleh mengisi spasi atau mengosongkan field" required>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" pattern="^\S+$"
                                        title="Username tidak boleh mengandung spasi" required>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="exampleInputEmail1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" pattern="^\S(.*\S)?$"
                                        title="Tidak boleh mengisi spasi atau mengosongkan field" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1" pattern="^\S+$"
                                            title="Password tidak boleh mengandung spasi" required>
                                        <button class="btn btn-primary" type="button" id="toggle-password">
                                            <i class="fa fa-eye-slash" aria-hidden="true" id="eye-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tipe</label>
                                    <select name="tipe" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="superuser">Superuser</option>
                                    </select>
                                </div>
                                <div class="mb-3">
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
                <button type="button" class="btn btn-success" onclick="konfirmasiHapusMultiple()"><i
                        class="fa-solid fa-check" style="color: #ffffff;"></i> Aktifkan Terpilih</button>
                <button type="button" class="btn btn-warning fw-bold text-light" onclick="konfirmasiHapusMultiple()"><i
                        class="fa-solid fa-x" style="color: #ffffff;"></i> Nonaktifkan Terpilih</button>
                <button type="button" class="btn btn-danger" onclick="konfirmasiHapusMultiple()"><i
                        class="fa-solid fa-trash" style="color: #ffffff;"></i> Hapus Terpilih</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form id="delete-form" action="<?= site_url('Admin/hapus_multiple_admin') ?>" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all">
                        </th>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Terakhir Update</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="admins_to_delete[]" value="<?= $admin['id'] ?>">
                            </td>
                            <td>
                                <?= $counter++; ?>
                            </td>
                            <td>
                                <?= $admin['nama']; ?>
                            </td>
                            <td>
                                <?= $admin['email']; ?>
                            </td>
                            <td>
                                <?= $admin['username']; ?>
                            </td>
                            <td>
                                <?= $admin['last_updated']; ?>
                            </td>
                            <td>
                                <?= $admin['tipe']; ?>
                            </td>
                            <td>
                                <span
                                    class="status-indicator mx-3 <?= $admin['status'] === 'aktif' ? 'aktif' : 'nonaktif' ?>"></span>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="openEditModal(
                                        '<?= $admin['id'] ?>',
                                        '<?= $admin['nama'] ?>',
                                        '<?= $admin['username'] ?>',
                                        '<?= $admin['email'] ?>',
                                        '<?= $admin['password'] ?>',
                                        '<?= $admin['tipe'] ?>',
                                        '<?= $admin['status'] ?>'
                                    )">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form" action="<?= site_url('Admin/edit_admin') ?>" method="post">
                    <input type="hidden" name="admin_id" id="edit-admin-id">
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama</label>
                        <input type="text" name="edit_nama" id="edit-nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-username" class="form-label">Username</label>
                        <input type="text" name="edit_username" id="edit-username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" name="edit_email" id="edit-email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="edit_password" id="edit-password" class="form-control"
                                required>
                            <button class="btn btn-primary" type="button" id="toggle-password-edit">
                                <i class="fa fa-eye-slash" aria-hidden="true" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tipe" class="form-label">Tipe</label>
                        <select name="edit_tipe" id="edit-tipe" class="form-control">
                            <option value="superuser">Superuser</option>
                            <option value="admin">Admin</option>
                        </select>
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
    // ICON MATA Tambah
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("exampleInputPassword1");
        const togglePasswordButton = document.getElementById("toggle-password");

        togglePasswordButton.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePasswordButton.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            } else {
                passwordInput.type = "password";
                togglePasswordButton.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            }
        });
    });

    // ICON MATA EDIT
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("edit-password");
        const togglePasswordButton = document.getElementById("toggle-password-edit");

        togglePasswordButton.addEventListener("click", function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePasswordButton.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            } else {
                passwordInput.type = "password";
                togglePasswordButton.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            }
        });
    });

    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('input[name="admins_to_delete[]"]');

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
                title: 'Apakah Anda yakin ingin menghapus data admin terpilih?',
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

<script>
    function openEditModal(id, nama, username, email, password, tipe, status) {
        const editForm = document.getElementById('edit-form');
        document.getElementById('edit-admin-id').value = id;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-username').value = username;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-password').value = password;
        document.getElementById('edit-tipe').value = tipe;
        document.getElementById('edit-status').value = status;

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function confirmSave() {
    const editForm = document.getElementById('edit-form');
    const statusDropdown = document.getElementById('edit-status');
    const tipeDropdown = document.getElementById('edit-tipe');

    const namaValue = document.getElementById("edit-nama").value.trim();
    const usernameValue = document.getElementById("edit-username").value;
    const emailValue = document.getElementById("edit-email").value.trim();
    const passwordValue = document.getElementById("edit-password").value;

    if (namaValue === '' || usernameValue === '' || emailValue === '' || passwordValue === '') {
        Swal.fire({
            title: 'Data tidak boleh ada yang kosong!',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
        });
        return false;
    }

    if (/\s/.test(usernameValue) || /\s/.test(emailValue) || /\s/.test(passwordValue)) {
        Swal.fire({
            title: 'Data tidak boleh mengandung spasi!',
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok',
        });
        return false;
    }

    const selectedStatus = statusDropdown.value;
    const selectedTipe = tipeDropdown.value;

    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'edit_status';
    statusInput.value = selectedStatus;

    const tipeInput = document.createElement('input');
    tipeInput.type = 'hidden';
    tipeInput.name = 'edit_tipe';
    tipeInput.value = selectedTipe;

    editForm.appendChild(statusInput);
    editForm.appendChild(tipeInput);

    Swal.fire({
        title: 'Konfirmasi perubahan data',
        text: 'Anda yakin ingin menyimpan perubahan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            editForm.submit();
        }
    });
}


</script>

<?php $response = session()->getFlashdata('response'); ?>
<?php if ($response): ?>
    <?php if ($response['status'] === 'success'): ?>
        <script>
            Swal.fire({
                title: "Sukses!",
                text: "<?= $response['message']; ?>",
                icon: "success",
                button: "OK",
            });
        </script>
    <?php elseif ($response['status'] === 'error'): ?>
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "<?= $response['message']; ?>",
                icon: "error",
                button: "OK",
            });
        </script>
    <?php endif; ?>
<?php endif; ?>


