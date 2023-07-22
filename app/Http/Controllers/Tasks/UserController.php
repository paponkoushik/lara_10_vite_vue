<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = cache()->rememberForever('skills', fn() => User::query()->get());
        return response()->json($users, 200);
    }
}
