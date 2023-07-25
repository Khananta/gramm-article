<div class="container">
    <div class="row mt-4">
        <h4 class="display-6 col-4 offset-1 mb-3 mt-3">Tambah Kategori</h4>
        <form method="post" action="<?= site_url('Admin/simpanData') ?>" class="col-lg-10 offset-1 mb-4" enctype="multipart/form-data">
            <div class="input-group">
                <input type="text" name="judul" class="form-control" placeholder="Tambahkan Kategori" required>
            </div>
            <button type="submit" class="btn btn-primary col-lg-1 offset-lg-11 mt-2 px-2">Simpan</button>
        </form>
    </div>
</div>