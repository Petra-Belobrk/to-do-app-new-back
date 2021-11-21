<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStore;
use App\Http\Resources\Task\TaskDetailsResource;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService) {
        $this->taskService = $taskService;
    }

    public function index()
    {

    }

    public function store(TaskStore $request)
    {
       $st = $this->taskService->create($request->dto());
      return new TaskDetailsResource($st);

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function restore()
    {

    }
}
