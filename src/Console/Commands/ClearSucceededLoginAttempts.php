<?php

namespace LamaLama\LoginAttempts\Console\Commands;

use Illuminate\Console\Command;

class ClearSucceededLoginAttempts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login-attempts:clear-succeeded';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all succeeded login attempts in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Started ClearSucceededLoginAttempts...');

        $this->info('Finished ClearSucceededLoginAttempts...');
    }
}
