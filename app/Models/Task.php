<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'completed',
        'user_id'
    ];

    protected $casts = [
      'completed' => 'boolean'
    ];

    protected $dates = [
      'due_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
