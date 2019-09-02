<?php

namespace App\Modules\API\Http\Controllers;

use App\Modules\API\Http\Requests\ChangeAvatarRequest;
use App\Modules\API\Http\Requests\ChangePasswordRequest;
use App\Modules\API\Http\Requests\ProfileUpdateRequest;
use App\Modules\API\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserProfileController extends APIController
{
    /**
     * @SWG\Get(path="/user-profile",
     *     tags={"User Profile"},
     *     summary="Retrieves the authenticated user.",
     *     @SWG\Parameter(
     *         in = "header",
     *         name = "Authorization",
     *         required = true,
     *         type = "string",
     *         description = "Example: Bearer token"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "User collection response",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     *     @SWG\Response(response = 422, description = "Validation Failed")
     * )
     */
    public function me(): UserResource
    {
        return new UserResource($this->guard()->user());
    }

    /**
     * @SWG\Patch(path="/user-profile",
     *     tags={"User Profile"},
     *     summary="Updates the authenticated user.",
     *     @SWG\Parameter(in = "formData", name = "name", type = "string"),
     *     @SWG\Parameter(in = "formData", name = "email", type = "string"),
     *     @SWG\Parameter(
     *         in = "header",
     *         name = "Authorization",
     *         required = true,
     *         type = "string",
     *         description = "Example: Bearer token"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "User resource updated",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     *     @SWG\Response(response = 422, description = "Validation Failed"),
     *     @SWG\Response(response = 500, description = "Failed to update the user for unknown reason")
     * )
     *
     * @param ProfileUpdateRequest $request
     *
     * @return UserResource
     */
    public function update(ProfileUpdateRequest $request): UserResource
    {
        $user = $this->guard()->user();

        $user->fill($request->all())->save();

        return new UserResource($user);
    }

    /**
     * @SWG\Patch(path="/user-profile/change-password",
     *     tags={"User Profile"},
     *     summary="Changes the password of the authenticated user.",
     *     @SWG\Parameter(in = "formData", name = "password", required = true, type = "string", format = "password"),
     *     @SWG\Parameter(in = "formData", name = "password_confirmation", required = true, type = "string", format =
     *     "password"),
     *     @SWG\Parameter(
     *         in = "header",
     *         name = "Authorization",
     *         required = true,
     *         type = "string",
     *         description = "Example: Bearer token"
     *     ),
     *     @SWG\Response(response = 200, description = "Password changed successfully"),
     *     @SWG\Response(response = 422, description = "Validation Failed")
     * )
     *
     * @param ChangePasswordRequest $request
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $this->guard()->user();

        $user->password = Hash::make($request->password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        return $this->success('Password changed successfully.');
    }

    /**
     * @SWG\Post(path="/user-profile/change-avatar",
     *     tags={"User Profile"},
     *     summary="Updates the avatar for the authenticated user.",
     *     consumes={"multipart/form-data"},
     *     @SWG\Parameter(in = "formData", name = "image", required = false, type = "file", description = "Max file
     *     size: 10MB, Formats: jpeg, jpg, png"),
     *     @SWG\Parameter(
     *         in = "header",
     *         name = "Authorization",
     *         required = true,
     *         type = "string",
     *         description = "Example: Bearer token"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "User resource updated",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     *     @SWG\Response(response = 422, description = "Validation Failed"),
     *     @SWG\Response(response = 500, description = "Failed to update the user for unknown reason")
     * )
     *
     * @param ChangeAvatarRequest $request
     *
     * @return UserResource
     */
    public function changeAvatar(ChangeAvatarRequest $request): UserResource
    {
        $user = $this->guard()->user();

        $user->addMedia($request->file('image'))->toMediaCollection('avatar');

        return new UserResource($user);
    }
}
