<?php

namespace App\Models;

use CodeIgniter\Model;

class Kategori_Model extends Model
{
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori', 'status', 'last_updated'];

    public function getArticlesByKategori($id_kategori = null, $search = '', $sort = '')
    {
        if ($id_kategori === null) {
            return [];
        }

        $builder = $this->db->table('tb_artikel');
        $builder->where('id_kategori', $id_kategori);

        if (!empty($search)) {
            $builder->groupStart();
            $builder->like('judul', $search);
            $builder->orLike('konten', $search);
            $builder->groupEnd();
        }

        if ($sort === 'asc') {
            $builder->orderBy('last_updated', 'asc');
        } elseif ($sort === 'desc') {
            $builder->orderBy('last_updated', 'desc');
        }

        return $builder->get()->getResultArray();
    }

    public function getCategories($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->find($id);
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

    public function searchCategories($keyword)
    {
        if (!empty($keyword)) {
            return $this->like('nama_kategori', $keyword)->findAll();
        } else {
            return $this->findAll();
        }
    }

    public function countArticlesInCategory($categoryId)
    {
        $builder = $this->db->table('tb_artikel');
        $builder->where('id_kategori', $categoryId);

        return $builder->countAllResults();
    }
}
