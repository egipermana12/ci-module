<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\App;
use Psr\Log\LoggerInterface;
use App\Models\BaseModel;
use App\Libraries\Auth;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * custom data
     * @var [type]
     */
    protected $data;
    protected $config;
    protected $model;
    protected $isLoggedIn;
    protected $auth;
    protected $user;
    protected $session;
    
    private $methodName;
    private $controllerName;
    
    public $currentModule;

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['csrf', 'utils'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        date_default_timezone_set('Asia/Jakarta');

        $this->session = \Config\Services::session();
        $this->config         = new App;
        $this->model          = new BaseModel;
        $this->auth           = new Auth;

        $this->isLoggedIn = $this->session->get('logged_in');
        $this->data['login'] = $this->isLoggedIn;
        $this->data['config'] = $this->config;
        $this->data['settingAplikasi'] = $this->model->getSettingAplikasi(array('type' => 'app'));
        $this->data['settingRegistrasi'] = $this->model->getSettingRegistrasi();
        

        // $this->data['scripts'] = array();
        // $this->data['styles'] = array();

        // $this->data['scripts'] = array($this->config->baseURL . 'assets/js/app.js');
        

        $web = $this->session->get('web');
        $nama_module = $web['nama_module'];
        $module = $this->model->getModule($nama_module);
        if (!$module) {
            $this->data['content'] = 'Module ' . $nama_module . ' tidak ditemukan di database';
            $this->exitError($this->data);
        }
        $this->currentModule = $module;
        $this->data['currentModule'] = $this->currentModule;

        $this->user = $this->session->get('user');

        // Login? Yes, No, Restrict
        if ($this->currentModule['login'] == 'Y' && $nama_module != 'login') {
            $this->loginRequired();
        } else if ($this->currentModule['login'] == 'R') {
            $this->loginRestricted();
        }

        //if login for layout
        if ($this->isLoggedIn) 
        {
            $userSetting = $this->model->getSettingUser();
            if ($userSetting) {
                $this->data['app_layout'] = json_decode($userSetting->params, true);
            }
        }else{
            $this->data['app_layout'] = $this->model->getSettingAplikasi(array('type' => 'layout'));
        }

        //if login for logic
        if ($this->isLoggedIn) 
        {
            $this->data['menu'] = $this->model->getMenu($this->currentModule['nama_module']);

            //jika module sekarang adalah login maka redirect ke default
            if ($nama_module == 'login') {
                $this->redirectOnLoggedIn();
            }
        }
    }

    /**
     * fungsi untuk custom style dan js yang di inject dari controller
     */
    protected function addStyle($file) {
        $this->data['styles'][] = $file;
    }
    
    protected function addJs($file, $print = false) {
        if ($print) {
            $this->data['scripts'][] = ['print' => true, 'script' => $file];
        } else {
            $this->data['scripts'][] = $file;
        }
    }

    protected function exitError($data) {
        echo view('app_error.php', $data);
        exit;
    }
    

    /**
     * redirect user setelah login
     */
    /* Redirect User setelah login */

    protected function redirectOnLoggedIn() {
        if ($this->isLoggedIn) {
            header('Location: ' . $this->config->baseURL . $this->user['default_module']['nama_module']);
        }
    }

    protected function loginRestricted() {
        if ($this->isLoggedIn) {
            if ($this->methodName !== 'logout') {
                header('Location: ' . $this->config->baseURL);
            }
        }
    }

    protected function loginRequired() 
    {
        if (!$this->isLoggedIn) {
            header('Location: ' . $this->config->baseURL . 'login');
            exit();
        }
    }
    
    protected function mustNotLoggedIn() {
        if ($this->isLoggedIn) {    
            if ($this->currentModule['nama_module'] == 'login') {

                $redirect_url = '';
                if ($this->user['default_page_type'] == 'url') {
                    $redirect_url = str_replace('{{BASE_URL}}', $this->config->baseURL, $this->user['default_page_url']);
                } else if ($this->user['default_page_type'] == 'id_module') {
                    $redirect_url = $this->config->baseURL . $this->user['default_module']['nama_module'];
                } else {
                    $redirect_url = $this->config->baseURL . $this->user['role'][$this->user['default_page_id_role']]['nama_module'];
                }
                // header('Location: ' . $this->config->baseURL . $this->data['module_role']->nama_module);
                header('Location: ' . $redirect_url);
                exit();
            }
        }
    }

}
