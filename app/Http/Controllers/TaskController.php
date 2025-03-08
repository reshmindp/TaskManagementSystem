<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->getAllTasks($request->all());

       return response()->json(['status' => true, 'tasks' => $tasks]);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), 
                    [
                        'title' => 'required|string',
                        'description' => 'nullable|string',
                        'due_date' => 'nullable|date',
                    ]);

        if($validate->fails())
        {
            return response()->json(['status' => false, 'message' => 'Validation Error', 'errors' => $validate->errors()]);
        }

        return $this->taskService->createTask($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assign(Request $request, Task $task)
    {
        $validate = Validator::make($request->all(), ['assigned_to' => 'required|exists:users,id']);

        if($validate->fails())
        {
            return response()->json(['status' => false, 'message' => 'Validation Error', 'errors' => $validate->errors()]);
        }

        $this->taskService->assignTask($task, $request->assigned_to);

        return response()->json(['status' => true, 'message' => 'Task assigned successfully']);
    }

    public function complete(Task $task)
    {
        $this->taskService->completeTask($task);
        return response()->json(['status' => true, 'message' => 'Task marked as completed']);
    }
}
