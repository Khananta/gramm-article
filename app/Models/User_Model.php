<?php
namespace App\Models;

use CodeIgniter\Model;

class User_Model extends Model
{
    protected $table = 'tb_artikel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'konten', 'gambar', 'id_kategori'];
    public function getArticle($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['id' => $id]);
        }
    }

    public function saveDataArticle($data)
    {
        return $this->insert($data);
    }

    public function editDataArticle($data, $id)
    {
        return $this->db->table($this->table)->update($data, ['id' => $id]);
    }

    public function deleteDataArticle($id)
    {
        return $this->delete($id);
    }
}