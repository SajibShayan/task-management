<?php

namespace App\Http\Controllers\Admin\Task;

use App\Contract\Repositories\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CreateTaskController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateTaskRequest $request, TaskRepositoryInterface $taskRepository)
    {
        $payload = $request->validated();
        
         $payload['user_id'] = Auth::id();
         $taskRepository->create($payload);
         Cache::flush();

        return response()->json(['status' => 'success'], 200);
    }
}
