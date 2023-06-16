<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginationResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::query()
            ->with('products')
            ->paginate($request->perPage ?? 20);

        return $this->successPagination(UserResource::class, $users);

    }

    public function list() {
        $users = User::with('products')->get();
        return $this->success(UserResource::collection($users));
    }

    public function show(User $user) {
        $user->load('products');
        return $this->success(new UserResource($user));
    }
}
