<?php

namespace App\Http\Controllers\Admin\Task;

use App\Contract\Repositories\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UpdateTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        CreateTaskRequest $request,
        Task $task,
        TaskRepositoryInterface $taskRepository
    ) {
        $payload = $request->validated();
        if (!$payload) {
            return response()->json(['status' => 'failed', 'error' => $payload], 422);
        }
        
        $taskRepository->update($task->id, $payload);
        Cache::flush();

        return response()->json(['status' => 'success'], 200);
    }
}
