<?php
namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\SendTaskNotification;

class TaskService
{
    public function createTask(array $data)
    {
        return Task::create($data);
    }

    public function assignTask(Task $task, $userId)
    {
        $task->assigned_to = $userId;
        $task->save();

        $user = User::find($userId);

        SendTaskNotification::dispatch($task, $user)->onQueue('default');
    }

    public function completeTask(Task $task)
    {
        $task->update(['status' => 'completed']);
    }

    public function getAllTasks($filters = [])
    {
        $query = Task::query();

        if (!empty($filters['status'])) 
        {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['assigned_to'])) 
        {
            $query->where('assigned_to', $filters['assigned_to']);
        }

        return $query->get();
    }
}