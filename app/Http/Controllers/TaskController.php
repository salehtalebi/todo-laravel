<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TaskStatusChanged;
use App\Models\Task;


class TaskController extends Controller
{

    // protected $taskService;

    public function __construct()
    {
        // $this->taskService = $taskService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:255',
        ]);

        // $task = $this->taskService->createTask($request->description, $request->user()->id);

        $task = Task::create([
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);


        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'completed' => 'required|boolean',
        ]);

        // $task = $this->taskService->updateTask($task, $request->completed);

        $task->completed = $request->completed;
        $task->completed_at = $request->completed ? now() : null;
        $task->save();

        event(new TaskStatusChanged($task));


        return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);


    }
}
