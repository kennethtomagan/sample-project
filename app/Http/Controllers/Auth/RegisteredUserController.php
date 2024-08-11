<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisteredRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * RegisteredUserController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming registration request.
     *
     * @param RegisteredRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(RegisteredRequest $request): JsonResponse
    {
        $user = $this->authService->registerUser($request->validated());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken($request->name)->plainTextToken,
        ]);
    }
}
