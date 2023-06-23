<?php

namespace App\Models;

use CodeIgniter\Model;

class MybaseModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'setting';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tipe','params', 'value'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getSettingAplikasi($where)
    {
        $builder = $this->db->table('setting');
        $builder->select('*');
        $builder->where($where);
        $query = $builder->get()->getResultArray();
        foreach($query as $val){
            $settingAplikasi[$val['param']] = $val['value'];
        }
        return $settingAplikasi;
    }

    public function getSettingUser()
    {
        $id_user = session()->get('user')['id_user'];
        $builder = $this->db->table('setting_user');
        $builder->select('*');
        $builder->where('id_user', $id_user);
        $result = $builder->get()->getRow();
        if(!$result)
        {
            $settingDef = $this->getSettingAplikasi(array('type' => 'layout'));
            $result = new \stdClass;
            $result->params = json_encode($settingDef);
        }
        return $result;
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

    //highliht parent and child menu
    private function menuCurrent(&$result, $current_id)
    {
        $parent = $result[$current_id]['id_parent'];
        $result[$parent]['highlight'] = 1; // Highlight menu parent
        if (@$result[$parent]['id_parent']) {
            $this->menuCurrent($result, $parent);
        }
    }

    public function getModule($nama_module) {
        $builder = $this->db->table('module');
        $builder->select('module.*, module_status.*');
        $builder->join('module_status', 'module.id_module_status=module_status.id_module_status');
        $builder->where('nama_module', $nama_module);
        $result = $builder->get()->getRowArray();
        return $result;
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

        $BuildRole = $this->db->table('user_role');
        $BuildRole->select('user_role.*');
        $BuildRole->join('role', 'role.id_role = user_role.id_role');
        $BuildRole->join('module', 'module.id_module = role.id_module');
        $BuildRole->where('user_role.id_user', $id_user);
        $BuildRole->orderBy('role.nama_role', 'ASC');

        $result = $BuildRole->get()->getResultArray();

        if ($result) {
            foreach ($result as $val) {
                $user['role'][$val['id_role']] = $val;
            }
        }

        $userModulDefault = $user['default_page_id_module'];

        $buildModul = $this->db->table('module');
        $buildModul->select('*');
        $buildModul->where('id_module', $userModulDefault);

        $user['default_module'] = $buildModul->get()->getRowArray();

        return $user;
    }

    function getMenu($current_module = '')
    {
        $where_role = session()->get('user')['role'] ? join(',', array_keys(session()->get('user')['role'])) : '';
        $builderSql = $this->db->table('menu');
        $builderSql->select('*');
        $builderSql->join('menu_role', 'menu_role.id_menu = menu.id_menu', 'left');
        $builderSql->join('module', 'module.id_module = menu.id_module', 'left');
        $builderSql->join('menu_kategori', 'menu_kategori.id_menu_kategori = menu.id_menu_kategori', 'left');
        $builderSql->where('menu_kategori.aktif', 'Y');
        $builderSql->whereIn('id_role', array($where_role));
        $builderSql->orderBy('menu_kategori.urut', 'ASC');
        $builderSql->orderBy('menu.urut', 'ASC');

        $queryResult = $builderSql->get()->getResultArray();

        $current_id = '';
        $menu = [];
        foreach ($queryResult as $val)
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

        $builderMenuKat = $this->db->table('menu_kategori');
        $builderMenuKat->select('*');
        $builderMenuKat->where('aktif', 'Y');
        $builderMenuKat->orderBy('urut', 'ASC');

        $queryMenukat = $builderMenuKat->get()->getResultArray();

        $result = [];
        foreach ($queryMenukat as $val) {
            if (key_exists($val['id_menu_kategori'], $menu_kategori)) {
                $result[$val['id_menu_kategori']] = [ 'kategori' => $val, 'menu' => $menu_kategori[$val['id_menu_kategori']] ];
            }
        }

        // echo '<pre>'; print_r($result); die;
        return $result;
    }

    public function getModulePermission($id_module, $id_user)
    {
        $permission = $this->db->table('user_role_module');
        $permission->select('user_role_module.*, module.*');
        $permission->join('module', 'module.id_module = user_role_module.id_module');
        $permission->join('user', 'user.id_user = user_role_module.id_user');
        $permission->where('user_role_module.id_module', $id_module);
        $permission->where('user_role_module.id_user', $id_user);
        $queryResult = $permission->get()->getResultArray();
        return $queryResult;
    }

//batas    
}
