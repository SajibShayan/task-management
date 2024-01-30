<?php

namespace App\Http\Controllers\Admin\Task;

use App\Contract\Repositories\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DestroyTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
     Task $task,
     TaskRepositoryInterface $taskRepository
     )
    {
        $taskRepository->delete($task->id);
        Cache::flush();

        return response()->json(['status' => 'success'], 200);
    }
}
