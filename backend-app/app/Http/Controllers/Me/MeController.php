<?php

declare(strict_types=1);

namespace App\Http\Controllers\Me;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse {
        /** @var User $user */
        $user = auth()->user();

        return (new UserResource($user))->response();
    }
}
