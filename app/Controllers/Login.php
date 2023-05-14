<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
    private $mLogin;
    public function __construct()
    {
        $this->mLogin = new LoginModel;  
        $this->data['site_title'] = 'Login ke akun Anda';
    }

    public function index()
    {
        $this->mustNotLoggedIn();
        $postPassword = $this->request->getPost('password');
        $this->data['status'] = '';
        if ($postPassword) {
            $this->login();
        }
        
        csrf_settoken();   
        $this->data['style'] = ' style="max-width:420px"';
        return view('Login', $this->data);
    }

    private function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        // Check Token
        $validation_message = csrf_validation();

        // Cek CSRF token
        if ($validation_message) {
            $this->data['status'] = 'error';
            $this->data['message'] = $validation_message['message'];
            return;
        }

        $error = false;
        $user = $this->model->checkUser($username);
        if($user)
        {
            if ($user['verified'] == 0) {
                $message = 'User belum aktif';
                $error = true;
            }

            if ($user['status'] != 'active') {
                $message = 'Status akun Anda ' . ucfirst($user['status']);
                $error = true;
            }

            if (!$error) {
                if (!password_verify($password, $user['password'])) {
                    $message = 'Username dan/atau Password tidak cocok';
                    $error = true;
                }
            }
        }else{
            $message = 'User tidak ditemukan';
            $error = true;
        }

        if ($error)
        {
            $this->data['status'] = 'error';
            $this->data['message'] = $message;
            return;
        }

        if($remember)
        {
            $this->mLogin->setUserToken($user);
        }

        $this->session->set('user', $user);
        $this->session->set('logged_in', true);
        // $this->mLogin->recordLogin($user); belum terlalu penting
    }

    public function logout() 
    {
        $user = $this->session->get('user');
        if ($user) {
            $this->mLogin->deleteAuthCookie($this->session->get('user')['id_user']);
        }
        $this->session->destroy();
        
        header('location: ' . $this->config->baseURL . 'login');
        exit;
    }

}
