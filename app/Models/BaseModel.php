<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $request;
    protected $session;

    public function initialize()
    {
        $this->request = \Config\Services::request();
        $this->session = \Config\Services::session();
    }

    public function getUserById($id_user = null, $array = false)
    {
        if (!$id_user) {
            if (!$this->user) {
                return false;
            }
            $id_user = $this->user['id_user'];
        }
        
        $query = $this->db->query('SELECT * FROM user WHERE id_user = ?', [$id_user]);
        $user = $query->getRowArray();
        
        if (!$user) {
            return;
        }
        
        $user['role'] = [];
        $query = $this->db->query('SELECT * FROM user_role 
                                LEFT JOIN role USING(id_role) 
                                LEFT JOIN module USING(id_module) 
                                WHERE id_user = ? 
                                ORDER BY  nama_role', [$id_user]
                            );
                            
        $result = $query->getResultArray();
        if ($result) {
            foreach ($result as $val) {
                $user['role'][$val['id_role']] = $val;
            }
        }
                
        $query = $this->db->query('SELECT * FROM module WHERE id_module = ?', [$user['default_page_id_module']]);
        $user['default_module'] = $query->getRowArray();
        
        return $user;
    }

    public function checkUser($username) 
    {
        $builder = $this->db->table('user');
        $builder->select('*');
        $builder->where('username', $username);
        $user = $builder->get()->getRowArray();
        if (!$user)
            return;
        
        $user = $this->getUserById($user['id_user']); //akan merefer ke baseController mustnotlogin
        return $user;
    }

    public function getModule($nama_module) {
        $builder = $this->db->table('module');
        $builder->select('module.*');
        $builder->join('module_status', 'module.id_module_status=module_status.id_module_status');
        $builder->where('nama_module', $nama_module);
        $result = $builder->get()->getRowArray();
        return $result;
    }

    public function getSettingAplikasi()
    {
        $builder = $this->db->table('setting');
        $builder->select('*');
        $builder->where('type', 'app');
        $query = $builder->get()->getResultArray();
        foreach($query as $val){
            $settingAplikasi[$val['param']] = $val['value'];
        }
        return $settingAplikasi;
    }

    public function getSettingRegistrasi()
    {
        $builder = $this->db->table('setting');
        $builder->select('*');
        $builder->where('type', 'register');
        $query = $builder->get()->getResultArray();
        foreach($query as $val){
            $settingRegistrasi[$val['param']] = $val['value'];
        }
        return $settingRegistrasi;
    }

}
