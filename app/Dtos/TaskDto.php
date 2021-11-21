<?php

namespace App\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class TaskDto extends DataTransferObject {
    public string $title;
    public string|null $description;
    public bool $completed;
    public string $due_date;
    public string $user_id;
}
