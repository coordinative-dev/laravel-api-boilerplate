<?php

namespace App\Modules\API\Http\Controllers;

use App\Models\User;
use App\Modules\API\Http\Resources\UserResource;

class UserController extends APIController
{
    /**
     * @SWG\Get(path="/users/{id}",
     *     tags={"Users"},
     *     summary="Retrieves a User resource.",
     *     @SWG\Parameter(in = "path", name = "id", required = true, type = "integer", description = "User ID"),
     *     @SWG\Parameter(
     *         in = "header",
     *         name = "Authorization",
     *         required = true,
     *         type = "string",
     *         description = "Example: Bearer token"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "User resource response",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     *     @SWG\Response(response = 404, description = "The requested user does not exist.")
     * )
     *
     * @param User $user
     *
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
