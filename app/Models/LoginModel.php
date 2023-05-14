<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Libraries\Auth;


class LoginModel extends BaseModel
{
    public function recordLogin($user)
    {
        $data = array('id_user' => $user['id_user']
                    , 'id_activity' => 1
                    , 'time' => date('Y-m-d H:i:s')
                );
        
    }
    public function setUserToken($user)
    {
        $auth = new Auth;
        $token = $auth->generateDbToken();
        $expired_time = time() + (7*24*3600); // 7 day
        setcookie('remember', $token['selector'] . ':' . $token['external'], $expired_time, '/');

        $data_db = array ( 'id_user' => $user['id_user']
                        , 'selector' => $token['selector']
                        , 'token' => $token['db']
                        , 'action' => 'remember'
                        , 'created' => date('Y-m-d H:i:s')
                        , 'expires' => date('Y-m-d H:i:s', $expired_time)
                    );
        $builder = $this->db->table('user_token');
        $builder->insert($data_db);
    }

    public function deleteAuthCookie($id_user)
    {
        $this->db->table('user_token')->delete(['action' => 'remember', 'id_user' => $id_user]);
        setcookie('remember', '', time() - 360000, '/');
    }
}
