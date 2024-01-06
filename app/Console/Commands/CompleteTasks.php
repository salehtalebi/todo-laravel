<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CompleteTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'tasks:complete';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Complete tasks older than 2 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Task::where('completed', false)
            ->where('created_at', '<=', now()->subDays(2))
            ->update(['completed' => true, 'completed_at' => now()]);

            // Broadcast the event
            event(new TaskStatusChanged($task));

        $this->info('Tasks completed successfully');
    }
}
