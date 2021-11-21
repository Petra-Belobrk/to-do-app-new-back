<?php

namespace App\Services;

use App\Dtos\TaskDto;
use App\Models\Task;

class TaskService {
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function create(TaskDto $taskDto)
    {
        return $this->model->create($taskDto->all());
    }
}
