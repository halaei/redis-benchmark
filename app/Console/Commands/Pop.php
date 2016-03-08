<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Queue\QueueManager;
use Illuminate\Redis\Database;

class Pop extends Command
{
    protected $signature = 'pop {n}';

    protected $description = 'pop jobs from queue';

    public function handle(QueueManager $queueManager, Database $database)
    {
        $start = microtime(true);

        $n = $this->argument('n');
        $i = 0;
        while ($i < $n) {
            try {
                $job = $queueManager->connection()->pop();
                if (is_null($job)) {
                    sleep(1);
                } else {
                    $job->fire();
                    $i++;
                }
            } catch (\Exception $e) {
                $database->connection()->incr('pop_exception:' . get_class($e));
            }
        }

        $database->connection()->set('last_pop:' . posix_getpid(), microtime(true) - $start);
    }
}
