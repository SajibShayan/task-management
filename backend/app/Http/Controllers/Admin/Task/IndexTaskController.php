<?php

namespace App\Http\Controllers\Admin\Task;

use App\Contract\Repositories\TaskRepositoryInterface;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IndexTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TaskRepositoryInterface $taskRepository)
    {
        $status = $request->query('status');
        $status = $status == 'all' ? null : $status;
        Cache::flush();
        $data = Cache::rememberForever('tasks', function () use ($status, $taskRepository) {
            return $taskRepository->getAllTask(status: $status);
        });

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
