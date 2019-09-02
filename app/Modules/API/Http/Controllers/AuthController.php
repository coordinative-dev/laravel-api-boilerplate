<?php

namespace App\Modules\API\Http\Controllers;

use App\Models\User;
use App\Modules\API\Http\Requests\LoginRequest;
use App\Modules\API\Http\Requests\RegistrationRequest;
use App\Modules\API\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends APIController
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['refresh']]);
    }

    /**
     * @SWG\Post(path="/auth/login",
     *     tags={"Auth"},
     *     summary="Log in by email.",
     *     @SWG\Parameter(in = "formData", name = "email", required = true, type = "string"),
     *     @SWG\Parameter(in = "formData", name = "password", required = true, type = "string", format = "password"),
     *     @SWG\Response(
     *         response = 200,
     *         description = "The User has been successfully logging in",
     *         @SWG\Schema(ref = "#/definitions/Token")
     *     ),
     *     @SWG\Response(response = 422, description = "Validation Failed"),
     * )
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = $this->guard()->attempt($credentials)) {
            $this->errorUnprocessableEntity([
                'password' => [trans('auth.failed')],
            ]);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @SWG\Post(path="/auth/register",
     *     tags={"Auth"},
     *     summary="Register a user.",
     *     @SWG\Parameter(in = "formData", name = "email", required = true, type = "string"),
     *     @SWG\Parameter(in = "formData", name = "name", required = true, type = "string"),
     *     @SWG\Parameter(in = "formData", name = "password", required = true, type = "string", format = "password"),
     *     @SWG\Response(response = 201, description = "Success", @SWG\Schema(ref = "#/definitions/User")),
     *     @SWG\Response(response = 422, description = "Validation Failed"),
     * )
     *
     * @param RegistrationRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request)
    {
        $user = new User();
        $user->fill($request->except(['password']));
        $user->password = Hash::make($request->get('password'));
        $user->save();

        event(new Registered($user));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Refresh a token.
     *
     * @SWG\Post(path="/auth/refresh-token",
     *     tags={"Auth"},
     *     summary="Refresh a token.",
     *     @SWG\Parameter(
     *         in = "header",
     *         name = "Authorization",
     *         required = true,
     *         type = "string",
     *         description = "Example: Bearer token"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "The Token has been successfully refreshed",
     *         @SWG\Schema(ref = "#/definitions/Token")
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
        ]);
    }
}
