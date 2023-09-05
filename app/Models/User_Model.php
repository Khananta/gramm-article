<?php
namespace App\Models;

use CodeIgniter\Model;

class User_Model extends Model
{
    protected $table = 'tb_artikel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'konten', 'gambar', 'id_kategori', 'status', 'last_updated', 'pembuat'];
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
    public function updateArticleWithLastUpdated($id, $data)
    {
        $data['last_updated'] = date('Y-m-d H:i:s'); 
        return $this->insert($id, $data);
    }
    public function deleteArticle($id)
    {
        return $this->delete($id);
    }
    public function deleteArticlesByCategoryId($categoryId)
    {
        return $this->where('id_kategori', $categoryId)->delete();
    }
    public function updateStatusByKategori($kategoriId, $statusData)
    {
        $data = [
            'status' => $statusData['status'],
            'last_updated' => date('Y-m-d H:i:s')
        ];

        $this->db->table('tb_artikel')
            ->where('id_kategori', $kategoriId)
            ->update($data);
    }
}