<?php

namespace App\Modules\API\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

/**
 * @SWG\Post(path="/auth/request-password-reset",
 *     tags={"Auth"},
 *     summary="Send request for password reset.",
 *     @SWG\Parameter(in = "formData", name = "email", required = true, type = "string"),
 *     @SWG\Response(
 *         response = 200,
 *         description = "Email is successfully sent.",
 *     ),
 *     @SWG\Response(response = 422, description = "Validation Failed"),
 *     @SWG\Response(response = 500, description = "Error while sending message")
 * )
 */
class ForgotPasswordController extends APIController
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'status' => trans($response),
        ]);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $response
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $this->errorUnprocessableEntity([
            'email' => trans($response),
        ]);
    }
}
