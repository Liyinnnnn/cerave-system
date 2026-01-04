<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeployCommand extends Command
{
    protected $signature = 'deploy';
    protected $description = 'Run deployment tasks safely';

    public function handle()
    {
        $this->info('🚀 Starting deployment...');

        try {
            // Test database connection
            DB::connection()->getPdo();
            $this->info('✅ Database connected');
            
            // Run migrations
            $this->info('🗄️  Running migrations...');
            $this->call('migrate', ['--force' => true]);
            $this->info('✅ Migrations complete');
            
        } catch (\Exception $e) {
            $this->warn('⚠️  Database not ready yet');
            $this->warn('Error: ' . $e->getMessage());
            $this->info('Run: php artisan deploy (once database is ready)');
            return 1;
        }

        $this->info('✅ Deployment successful!');
        return 0;
    }
}
