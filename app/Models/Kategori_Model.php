<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_Model extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori'];

    // Get articles by id_kategori from the database
    public function getArticlesByKategori($id_kategori = null)
    {
        if ($id_kategori === null) {
            return $this->findAll();
        } else {
            // Load the db connection
            $db = db_connect();

            // Query to get articles by id_kategori
            $query = "SELECT * FROM tb_artikel WHERE id_kategori = ?";
            $result = $db->query($query, [$id_kategori]);

            if ($result) {
                return $result->getResultArray();
            } else {
                return [];
            }
        }
    }

    public function getCategories($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }
    public function simpan($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }
    public function hapus($id)
    {
        return $this->delete($id);
    }
}