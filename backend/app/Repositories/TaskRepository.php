<?php

namespace App\Repositories;

use App\Contract\Repositories\TaskRepositoryInterface;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
    
    public function getAllTask(?int $limit = 3, ?string $status = null): Collection|Paginator
    {
        return $this->model->when($status, fn($query) => $query->where('status', $status))
        ->orderByDesc('id')->paginate($limit);
    }
    
}
