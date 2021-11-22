<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStore;
use App\Http\Requests\Task\TaskUpdate;
use App\Http\Resources\Task\TaskDetailsResource;
use App\Http\Resources\Task\TaskListResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(): AnonymousResourceCollection
    {
        return TaskListResource::collection($this->taskService->getAll());
    }

    public function store(TaskStore $request): TaskDetailsResource
    {
        return new TaskDetailsResource($this->taskService->create($request->dto()));
    }

    public function show(string $id): TaskDetailsResource
    {
        return new TaskDetailsResource($this->taskService->findOrFail($id));

    }

    public function update(TaskUpdate $request): TaskDetailsResource
    {
        return new TaskDetailsResource($this->taskService->update($request->dto()));

    }

    public function delete(string $id): JsonResponse
    {
        $this->taskService->delete($id);
        return response()->json('Task '. $id. ' deleted successfully', 200);
    }

    public function trashed(): AnonymousResourceCollection
    {
        return TaskListResource::collection($this->taskService->getAllTrashed());
    }

    public function restore(string $id): TaskDetailsResource
    {
       return new TaskDetailsResource($this->taskService->restore($id));
    }
}
