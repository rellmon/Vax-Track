<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class ProcessQueuedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:process-batch {--limit=10 : Number of jobs to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process queued jobs from database (for Railway deployment without queue worker)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');

        try {
            $worker = Queue::connection('database')->getWorker();
            $worker->daemon(
                connection: 'database',
                queue: 'default',
                options: [
                    'delay' => 0,
                    'memory' => 128,
                    'timeout' => 30,
                    'tries' => 3,
                    'max_jobs' => $limit,
                ]
            );

            $this->info("✅ Processed queued jobs successfully.");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Error processing queued jobs: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
