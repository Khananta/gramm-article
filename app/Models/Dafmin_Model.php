<?php

namespace App\Models;

use CodeIgniter\Model;

class Dafmin_Model extends Model
{
    protected $table = 'datmin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'email', 'username', 'password', 'last_updated', 'status', 'tipe'];

    public function getUserByUsernameOrEmail($usernameOrEmail)
    {
        return $this->where('username', $usernameOrEmail)
            ->orWhere('email', $usernameOrEmail)
            ->first();
    }

    public function getPembuatList()
    {
        $query = $this->select('nama')->findAll();
        return $query;
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
        $data['last_updated'] = date('Y-m-d H:i:s');
        return $this->update($id, $data);
    }

    public function isUsernameUnique($username, $adminId)
    {
        // Check if the username exists in the database except for the current admin
        $builder = $this->db->table($this->table);
        $builder->where('username', $username);
        $builder->where('id !=', $adminId); // Exclude the current admin by ID
        $result = $builder->get()->getRow();

        // If a row is returned, the username is not unique
        return empty($result);
    }
    public function updateAdminStatus($adminId, $status)
    {
        // Update the admin's status in the database
        $data = [
            'status' => $status,
        ];
        $this->set($data)->where('id', $adminId)->update();
    }
}