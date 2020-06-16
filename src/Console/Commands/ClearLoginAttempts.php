<?php

namespace LamaLama\LoginAttempts\Console\Commands;

use Illuminate\Console\Command;
use LamaLama\LoginAttempts\Models\LoginAttempt;

class ClearLoginAttempts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'login-attempts:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all login attempts in the database';

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
        $this->info('Started ClearLoginAttempts...');

        LoginAttempt::delete();

        $this->info('Finished ClearLoginAttempts...');
    }
}
