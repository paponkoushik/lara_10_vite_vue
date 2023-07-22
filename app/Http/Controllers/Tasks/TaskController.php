<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $tasks = Task::query()->with('users')->get();

        return response()->json($tasks, 200);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $this->service
                ->setAttrs($request->only('title', 'description', 'deadline', 'users'))
                ->store()
                ->syncUsers()
                ->sendNotification();
        });

        return response()->json('Task has been created successfully', 200);
    }

    public function delete(Task $task): JsonResponse
    {
        $this->service->setModel($task)->delete();

        return response()->json('Task has been deleted successfully', 200);
    }
}
