<?php

namespace App\Jobs;

use Illuminate\Redis\Database;

class Job
{
    private $n;

    public function __construct($n)
    {
        $this->n = $n;
    }

    public function handle(Database $database)
    {
        $database->connection()->hdel('hash_table', $this->n);
    }
}
