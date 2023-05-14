<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Library extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'command:Library';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Script Untuk Membuat Library';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:Library [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        for ($i = 0; $i <= 10; $i++) {
            CLI::print($i);
        }
    }
}
