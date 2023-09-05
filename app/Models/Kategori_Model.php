<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_Model extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori', 'status', 'last_updated'];

    // dapatin artikel berdasarkan kategori
    public function getArticlesByKategori($id_kategori = null, $search = '')
    {
        if ($id_kategori === null) {
            return $this->findAll();
        }

        $builder = $this->db->table('tb_artikel');
        $builder->where('id_kategori', $id_kategori);

        // menambah filter pencarian jika ada input search
        if (!empty($search)) {
            $builder->like('judul', $search);
            $builder->orLike('konten', $search);
        }

        return $builder->get()->getResultArray();
    }
    public function getCategories($id = false)
    {
        if ($id === false) {
            return $this->findAll(); //kalau gak ada id yang ditentukan, maka akan mengambil semua id
        } else {
            return $this->find($id); //kalau ada id yang ditentukan, maka akan mengambil berdasarkan id yang ditentukan
        }
    }
    public function deleteCategory($id)
    {
        return $this->delete($id);
    }
    public function updateKategoriWithLastUpdated($id, $data)
    {
        $data['last_updated'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }
}