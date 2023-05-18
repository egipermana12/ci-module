<?php
namespace App;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class TestFoo extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    /**
     * untuk menjalankan script ini gunakan di terminal
     * \vendor\bin\phpunit --testsuit myApp
     */

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'Tests\Support';

    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testIndexLogin()
    {
        $result = $this->call('get', '/');
        $result->assertOK();
    }

    public function testTitleLogin()
    {
        $result = $this->call('get', '/');
        $result->assertSee('<title>Login ke akun Anda</title>');
    }

    /**
    public function testUserBelumAktif()
    {
        $result = $this->call('post', '/', [
            'username'  => 'admin',
            'password' => '12'
        ]);
        $result->assertSee('User belum aktif');
    }

    public function testUserSuspended()
    {
        $result = $this->call('post', '/', [
            'username'  => 'admin',
            'password' => '12'
        ]);
        $result->assertSee('Status akun Anda Suspended');
    }
    
   public function testUserWrongPassword()
    {
        $result = $this->call('post', '/', [
            'username'  => 'admin',
            'password' => '12' //harusnya 12345
        ]);
        $result->assertSee('Username dan/atau Password tidak cocok');
    }
    
    public function testUserNotFound()
    {
        $result = $this->call('post', '/', [
            'username'  => 'adminpilar',
            'password' => '12' //harusnya 12345
        ]);
        $result->assertSee('User tidak ditemukan');
    }
    */
   
   public function testUserSuccess()
    {
        $result = $this->call('post', '/', [
            'username'  => 'admin',
            'password' => '12345' //harusnya 12345
        ]);
        $result->assertSessionHas('logged_in', true);
        $result->assertSessionHas('user');
    }

}
