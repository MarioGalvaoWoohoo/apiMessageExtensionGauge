<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSanctumToken extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanctum:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Sanctum token and save it to .env file';

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
     * @return int
     */
    public function handle()
    {
        $token = Str::random(80);
        $envFile = base_path('.env');
        file_put_contents($envFile, str_replace(
            'SANCTUM_TOKEN=',
            'SANCTUM_TOKEN=' . $token,
            file_get_contents($envFile)
        ));

        $this->info("New Sanctum token generated and saved to .env file: $token");
    }
}
