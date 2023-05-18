<?php
namespace App;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;


class SampleTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = false;
    protected $namespace   = 'Tests\Support';
 
    public function testCountTable()
    {
        $criteria = [
            'status' => 'active',
        ];
        $this->seeNumRecords(2, 'user', $criteria);
    }
}
