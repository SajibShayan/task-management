<?php

namespace App\Http\Controllers\Admin\Task;

use App\Contract\Repositories\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Jobs\SendTaskEmailJob;
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

        $taskStatus = $task->status->value;
        $task = $taskRepository->update($task->id, $payload);

        if (
            $payload['status'] === 'complete'
            && $task->status->value === 'complete'
            && $taskStatus === 'incomplete'
        ) {

            SendTaskEmailJob::dispatch($task->user);

        }

        Cache::flush();
        return response()->json(['status' => 'success', 'data' => $taskStatus], 200);
    }
}
