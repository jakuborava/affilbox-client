<?php

namespace JakubOrava\AffilboxClient\Commands;

use Illuminate\Console\Command;

class AffilboxClientCommand extends Command
{
    public $signature = 'affilbox-client';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
