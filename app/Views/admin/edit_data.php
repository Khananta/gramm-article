<div class="row mt-4">
    <div class="col-lg-12 mb-4">
        <h3 class="display-6 mb-2">Edit Artikel</h3>
        <form method="POST" action="<?= site_url('/updatearticle') ?>" enctype="multipart/form-data"
            onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?= $artikel->id ?>">
            <div class="form-group my-2">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= $artikel->judul ?>">
            </div>
            <div class="form-group my-2">
                <label for="konten">Konten</label>
                <textarea class="form-control" id="konten" name="konten"><?= nl2br($artikel->konten) ?></textarea>
            </div>
            <div class="form-group my-2">
                <label for="gambar">Gambar</label>
                <?php if (empty($artikel->gambar)): ?>
                    <input type="file" class="form-control" id="gambar" name="gambar" required>
                <?php else: ?>
                    <div class="mb-2">
                        <img src="<?= base_url('/img/' . $artikel->gambar) ?>" alt="Gambar saat ini"
                            style="max-width: 200px;">
                    </div>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <label for="status">Status Artikel:</label>
                <select name="status" id="status">
                    <option value="aktif" <?= $artikel->status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $artikel->status == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="pembuat">Pilih Pembuat:</label>
                <select name="pembuat" id="pembuat">
                    <?php foreach ($pembuatList as $pembuat): ?>
                        <option value="<?= $pembuat['nama'] ?>" <?= $artikel->pembuat == $pembuat['nama'] ? 'selected' : '' ?>>
                            <?= $pembuat['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-3 text-end">
                <a href="<?= site_url('/article/' . $artikel->id_kategori) ?>" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>

<script>
    var editor;

    CKEDITOR.replace('konten', {
        on: {
            instanceReady: function (evt) {
                editor = evt.editor;
            }
        }
    });

    function validateForm() {
        const judulValue = document.getElementById("judul").value.trim();
        const editorContent = editor.getData().trim();

        if (judulValue === "") {
            alert("Maaf, judul tidak boleh kosong");
            return false;
        }

        if (!editorContent.replace(/<[^>]*>|&nbsp;|\s/g, '').trim()) {
            alert("Maaf, konten artikel tidak boleh kosong");
            return false;
        }
        return true;
    }
</script>