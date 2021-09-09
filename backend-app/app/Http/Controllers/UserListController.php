<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Resources\UserResource;

class UserListController extends Controller
{

    protected UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function __invoke(Request $request): JsonResponse {
        $users = $this->userRepository->findAll();

        return UserResource::collection($users)->response();
    }
}
