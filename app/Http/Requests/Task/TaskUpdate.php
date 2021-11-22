<?php

namespace App\Http\Requests\Task;

use App\Dtos\TaskDto;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'nullable',
            'completed' => 'boolean',
            'due_date' => 'required'
        ];
    }

    public function dto()
    {
        return new TaskDto([
            'id' => $this->id,
            'title' => $this->title,
            'user_id' => auth()->id(),
            'description' => $this->description,
            'completed' => $this->completed,
            'due_date' => $this->due_date
        ]);
    }
}
