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
        
        $builUser = $this->db->table('user');
        $builUser->select('*');
        $builUser->where('id_user', $id_user);
        $user = $builUser->get()->getRowArray();
        
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

    /**
     * untuk get menu
     */
    
    //highliht parent and child menu
    private function menuCurrent(&$result, $current_id)
    {
        $parent = $result[$current_id]['id_parent'];
        $result[$parent]['highlight'] = 1; // Highlight menu parent
        if (@$result[$parent]['id_parent']) {
            $this->menuCurrent($result, $parent);
        }
    }

    //get menu from db
    public function getMenu($current_module = '')
    {
        $where_role = $_SESSION['user']['role'] ? join(',', array_keys($_SESSION['user']['role'])) : 'null';
        $sql = 'SELECT * FROM menu 
                    LEFT JOIN menu_role USING (id_menu) 
                    LEFT JOIN module USING (id_module)
                    LEFT JOIN menu_kategori USING(id_menu_kategori)
                WHERE menu_kategori.aktif = "Y" AND id_role IN ( ' . $where_role . ')
                ORDER BY menu_kategori.urut, menu.urut';

        $query_result = $this->db->query($sql)->getResultArray();

        $current_id = '';
        $menu = [];
        foreach ($query_result as $val) 
        {
            $menu[$val['id_menu']] = $val;
            $menu[$val['id_menu']]['highlight'] = 0;
            $menu[$val['id_menu']]['depth'] = 0;

            if ($current_module == $val['nama_module']) {
                
                $current_id = $val['id_menu'];
                $menu[$val['id_menu']]['highlight'] = 1;
            }
        }

        if ($current_id) {
            $this->menuCurrent($menu, $current_id);
        }

        $menu_kategori = [];
        foreach ($menu as $id_menu => $val) {
            if (!$id_menu)
                continue;
            
            $menu_kategori[$val['id_menu_kategori']][$val['id_menu']] = $val;
        }
        
        $sql = 'SELECT * FROM menu_kategori WHERE aktif = "Y" ORDER BY urut';
        $query_result = $this->db->query($sql)->getResultArray();
        $result = [];
        foreach ($query_result as $val) {
            if (key_exists($val['id_menu_kategori'], $menu_kategori)) {
                $result[$val['id_menu_kategori']] = [ 'kategori' => $val, 'menu' => $menu_kategori[$val['id_menu_kategori']] ];
            }
        }       
        // echo '<pre>'; print_r($result); die;
        return $result;

    }

}
