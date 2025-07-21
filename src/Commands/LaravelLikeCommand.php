<?php

namespace stevecreekmore\LaravelLike\Commands;

use Illuminate\Console\Command;

class LaravelLikeCommand extends Command
{
    public $signature = 'laravel-like';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
