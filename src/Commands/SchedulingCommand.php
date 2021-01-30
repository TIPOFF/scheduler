<?php

namespace Tipoff\Scheduling\Commands;

use Illuminate\Console\Command;

class SchedulingCommand extends Command
{
    public $signature = 'scheduling';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
