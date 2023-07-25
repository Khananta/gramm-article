<?php 
namespace App\Models;
use CodeIgniter\Model;
 
class Kategori_Model extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori'];

    public function getArticle($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['id' => $id]);
        }
    }

    public function simpan($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }
}