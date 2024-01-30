<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, Sluggable;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'user_id',
    ];
    protected $casts = [
        'status' => TaskStatus::class,
    ];

    //define slug as route key name
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
     //define title column for making slug unique
    public function getSluggableColumnName(): string
    {
        return 'title';
    }
    //scoped methods
    public function whereUser($userId)
    {
        return $this->where('user_id', $userId);
    }
    public function whereIncomplete()
    {
        return $this->where('status', TaskStatus::INCOMPLETE);
    }
    public function whereComplete()
    {
        return $this->where('status', TaskStatus::COMPLETE);
    }
}
