<?php

namespace Huynt57\LaravelOptimizeInitDbConnection\Commands;

use Illuminate\Console\Command;

class LaravelOptimizeInitDbConnectionCommand extends Command
{
    public $signature = 'laravel-optimize-init-db-connection';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
