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

    public function simpan($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function edit($data, $id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('id', $id);
        return $builder->update($data);
    }
    public function hapus_data($id)
    {
        $builder = $this->db->table($this->table);
        return $builder->delete(['id' => $id]);
    }
}