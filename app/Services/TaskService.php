<?php

namespace App\Services;

use App\Dtos\TaskDto;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService {
    protected Task $model;

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function create(TaskDto $taskDto): Task
    {
        return $this->model->create($taskDto->all());
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function findOrFail(string $id): Task|null
    {
        return $this->model->findOrFail($id);
    }

    public function update(TaskDto $taskDto)
    {
        return tap($this->findOrFail($taskDto->id))->update($taskDto->except('user_id')->toArray());
    }

    public function delete(string $id): void
    {
        $this->findOrFail($id)->delete();
    }

    public function getAllTrashed(): array|Collection|\Illuminate\Support\Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    public function restore(string $id)
    {
        return tap($this->model->withTrashed()->findOrFail($id))->restore();
    }
}
