<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class ExpireOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark overdue tasks as expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueTasks = Task::where('due_date', '<', now())->where('status', 'pending')->get();

        if ($overdueTasks->isEmpty()) {
            Log::info('No overdue tasks found.');
            return;
        }

        foreach ($overdueTasks as $task) {
            $task->update(['status' => 'expired']);
            Log::info("Task ID {$task->id} marked as expired.");
        }

        Log::info("Expired overdue tasks: " . count($overdueTasks));
    }
}
