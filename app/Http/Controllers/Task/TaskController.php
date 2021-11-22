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

/**
 * @group Task
 */
class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Lists all tasks for logged-in user
     * @return AnonymousResourceCollection
     * @authenticated
     *
     *
     * @response status=200 scenario=success [{
     *   "id": "e518d4b9-c8be-4644-96b7-6e8f8968cf4e",
     *   "title": "Shopping",
     *   "description": "Need to go shopping for...",
     *   "completed": false,
     *   "due_date": "07.01.2022."
     *   }]
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     */
    public function index(): AnonymousResourceCollection
    {
        return TaskListResource::collection($this->taskService->getAll());
    }

    /**
     * Creates new task
     * @param TaskStore $request
     * @return TaskDetailsResource
     * @authenticated
     *
     * @bodyParam title string required Title of task. Example: New thing
     * @bodyParam description string Description of task. Example: I really need to go here and there.
     * @bodyParam completed boolean required Has the task been completed. Example: 0
     * @bodyParam due_date string required Date when the task needs to be completed. Example: 2022-01-07
     *
     * @response scenario=success {
     *   "id": "e518d4b9-c8be-4644-96b7-6e8f8968cf4e",
     *   "title": "New thing",
     *   "description": "Something needs to be done here",
     *   "completed": false,
     *   "due_date": "07.01.2022."
     *   }
     *
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     * @response status=422 scenario="Validation error" {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *      "title": [
     *          "The title field is required."
     *          ]
     *      }
     *   }
     */
    public function store(TaskStore $request): TaskDetailsResource
    {
        return new TaskDetailsResource($this->taskService->create($request->dto()));
    }

    /**
     * Show details of task
     * @param string $id
     * @return TaskDetailsResource
     * @authenticated
     *
     * @urlParam id string required The ID of the task.
     * @response scenario=success {
     *   "id": "e518d4b9-c8be-4644-96b7-6e8f8968cf4e",
     *   "title": "New thing",
     *   "description": "Something needs to be done here",
     *   "completed": false,
     *   "due_date": "07.01.2022."
     *   }
     *
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     */
    public function show(string $id): TaskDetailsResource
    {
        return new TaskDetailsResource($this->taskService->findOrFail($id));

    }

    /**
     * Updates a task
     * @param TaskUpdate $request
     * @return TaskDetailsResource
     * @authenticated
     * @urlParam id string required The ID of the task.
     *
     * @bodyParam title string required Title of task. Example: New thing
     * @bodyParam description string Description of task. Example: I really need to go here and there.
     * @bodyParam completed boolean required Has the task been completed. Example: 0
     * @bodyParam due_date string required Date when the task needs to be completed. Example: 2022-01-07
     *
     * @response scenario=success {
     *   "id": "e518d4b9-c8be-4644-96b7-6e8f8968cf4e",
     *   "title": "New thing",
     *   "description": "Something needs to be done here",
     *   "completed": false,
     *   "due_date": "07.01.2022."
     *   }
     *
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     * @response status=422 scenario="Validation error" {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *      "title": [
     *          "The title field is required."
     *          ]
     *      }
     *   }
     */
    public function update(TaskUpdate $request): TaskDetailsResource
    {
        return new TaskDetailsResource($this->taskService->update($request->dto()));

    }

    /**
     * Soft deletes a task
     *
     * @param string $id
     * @return JsonResponse
     *
     * @authenticated
     * @urlParam id string required The ID of the task.
     *
     * @response scenario=success { "Task dcd7f688-d863-4310-abab-0771d521f53e deleted successfully" }
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     */
    public function delete(string $id): JsonResponse
    {
        $this->taskService->delete($id);
        return response()->json('Task '. $id. ' deleted successfully', 200);
    }

    /**
     * List of deleted tasks
     *
     * @return AnonymousResourceCollection
     * @authenticated
     *
     * @response status=200 scenario=success [{
     *   "id": "e518d4b9-c8be-4644-96b7-6e8f8968cf4e",
     *   "title": "Shopping",
     *   "description": "Need to go shopping for...",
     *   "completed": false,
     *   "due_date": "07.01.2022."
     *   }]
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     *
     */
    public function trashed(): AnonymousResourceCollection
    {
        return TaskListResource::collection($this->taskService->getAllTrashed());
    }

    /**
     * Restores deleted task
     *
     * @param string $id
     * @return TaskDetailsResource
     * @authenticated
     * @urlParam id string required The ID of the task.
     *
     * @response scenario=success {
     *   "id": "e518d4b9-c8be-4644-96b7-6e8f8968cf4e",
     *   "title": "New thing",
     *   "description": "Something needs to be done here",
     *   "completed": false,
     *   "due_date": "07.01.2022."
     *   }
     *
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     */
    public function restore(string $id): TaskDetailsResource
    {
       return new TaskDetailsResource($this->taskService->restore($id));
    }
}
