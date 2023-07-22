<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Notifications\TaskCreated;
use App\Services\BaseService;
use Illuminate\Support\Facades\Notification;

class TaskService extends BaseService
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function store(): TaskService
    {
        $this->model = parent::save($this->getAttrs());

        return $this;
    }

    public function syncUsers(): TaskService
    {
        $this->model
            ->users()
            ->sync(array_column($this->getAttr('users'), 'id'));

        return $this;
    }

    public function sendNotification(): TaskService
    {
        Notification::route('mail', array_column($this->getAttr('users'), 'email'))->notify(new TaskCreated($this->model));

        return $this;
    }
}
