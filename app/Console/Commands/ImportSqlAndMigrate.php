<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class ImportSqlAndMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:dawala {--seed : Seed the database with records}
                                           {--village : Import village data}
                                           {--district : Import district data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run fresh migrations and optionally import SQL files and seed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Run fresh migrations
        $this->info('Running fresh migrations...');
        Artisan::call('migrate:fresh', ['--force' => true]);

        // Seed if option is provided
        if ($this->option('seed')) {
            $this->info('Seeding database...');
            Artisan::call('db:seed');
        }

        // Import village.sql if option is provided
        $this->info('Importing villages.sql...PEPEK');
        $villagePath = public_path('backend/villages-cianjur.sql');
        if (file_exists($villagePath)) {
            DB::unprepared(file_get_contents($villagePath));
        } else {
            $this->error('village.sql file not found!');
        }

        // Import district.sql if option is provided
        $this->info('Importing districts.sql... PEPEK2');
        $districtPath = public_path('backend/districts-cianjur.sql');
        if (file_exists($districtPath)) {
            DB::unprepared(file_get_contents($districtPath));
        } else {
            $this->error('district.sql file not found!');
        }

        $this->info('All done!');
    }
}
