<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_Model extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori'];

    // dapatin artikel berdasarkan kategori
    public function getArticlesByKategori($id_kategori = null)
    {
        if ($id_kategori === null) {
            return $this->findAll();
        }
        $db = db_connect();
        $query = "SELECT * FROM tb_artikel WHERE id_kategori = ?";
        $result = $db->query($query, [$id_kategori]);
        return $result ? $result->getResultArray() : [];
    }


    public function getCategories($id = false)
    {
        if ($id === false) {
            return $this->findAll(); //kalau gak ada id yang ditentukan, maka akan mengambil semua id
        } else {
            return $this->find($id); //kalau ada id yang ditentukan, maka akan mengambil berdasarkan id yang ditentukan
        }
    }
    public function saveCategory($data)
    {
        return $this->insert($data);
    }
    public function deleteCategory($id)
    {
        return $this->delete($id);
    }
}