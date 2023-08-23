<?php

namespace App\Models;

use CodeIgniter\Model;

class Dafmin_Model extends Model
{
    protected $table = 'datmin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'email', 'username', 'password', 'last_updated', 'status','tipe'];

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
    public function getAdminData()
    {
        return $this->findAll();
    }
    public function deleteAdmin($id)
    {
        return $this->delete($id);
    }
    public function updateAdminWithLastUpdated($id, $data)
    {
        $data['last_updated'] = date('Y-m-d H:i:s'); // Set last_updated to current timestamp
        return $this->update($id, $data);
    }
    public function toggleStatus($adminId, $newStatus)
    {
        $this->where('id', $adminId)
            ->set('status', $newStatus)
            ->update();
    }
}