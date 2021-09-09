<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @param AuthRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(AuthRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->all())) {
            throw new AuthenticationException();
        }

        /** @var User $user */
        $user = auth()->user();

        return response()->json([$user->createToken('Token')->plainTextToken]);
    }
}
