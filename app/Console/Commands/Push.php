<?php

namespace App\Console\Commands;

use App\Jobs\Job;
use Illuminate\Console\Command;
use Illuminate\Queue\QueueManager;
use Illuminate\Redis\Database;

class Push extends Command
{
    protected $signature = 'push {from} {to} {delay}';

    protected $description = 'Push jobs into queue';

    public function handle(QueueManager $queueManager, Database $database)
    {
        $start = microtime(true);

        $from = $this->argument('from');
        $to = $this->argument('to');
        $delay = $this->argument('delay');
        for ($i = $from; $i <= $to; $i++) {
            $database->connection()->hset('hash_table', $i, 0);
            try {
                $queueManager->connection()->later($delay, new Job($i));
            } catch (\Exception $e) {
                $database->connection()->incr('push_exception:' . get_class($e));
            }
        }

        $database->connection()->set('last_push:' . getmypid(), microtime(true) - $start);
    }
}
