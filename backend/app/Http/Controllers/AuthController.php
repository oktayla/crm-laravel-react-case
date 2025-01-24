<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseBuilder;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * User Login
     *
     * Authenticate a user and return an access token along with user details.
     *
     * @bodyParam email string required The email of the user. Example: john.doe@example.com
     * @bodyParam password string required The password of the user. Example: password123
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "user": {
     *       "id": 1,
     *       "name": "John Doe",
     *       "email": "john.doe@example.com"
     *     },
     *     "token": "1|abcdefgh1234567890"
     *   }
     * }
     * @responseField user The authenticated user's details.
     * @responseField user.id The ID of the user.
     * @responseField user.name The name of the user.
     * @responseField user.email The email of the user.
     * @responseField token The access token for the authenticated user.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->validateCredentials(
            ...$request->validated()
        );

        if (! $user) {
            return ResponseBuilder::error(
                message: 'Invalid email or password!'
            );
        }

        return ResponseBuilder::success(
            data: [
                'user' => new UserResource($user),
                'token' => $user->createToken('auth-token')->plainTextToken
            ]
        );
    }

    /**
     * User Logout
     *
     * Revoke the current user's access token.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "User logged out successfully!"
     * }
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return ResponseBuilder::success(
            message: 'User logged out successfully!'
        );
    }
}
