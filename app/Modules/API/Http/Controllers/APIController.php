<?php

namespace App\Modules\API\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @SWG\Swagger(
 *     basePath="/api/v1",
 *     produces={"application/json"},
 *     @SWG\Info(version="1.0", title="Laravel API"),
 * )
 */
abstract class APIController extends Controller
{
    /**
     * Return an error response.
     *
     * @param string $message
     * @param int $statusCode
     *
     * @throws HttpException
     *
     * @return void
     */
    protected function error($message, $statusCode): void
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * Return a 404 not found error.
     *
     * @param string $message
     *
     * @throws HttpException
     *
     * @return void
     */
    protected function errorNotFound($message = 'Not Found'): void
    {
        $this->error($message, 404);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string $message
     *
     * @throws HttpException
     *
     * @return void
     */
    protected function errorUnauthorized($message = 'Unauthorized'): void
    {
        $this->error($message, 401);
    }

    /**
     * @param array $messages
     */
    protected function errorUnprocessableEntity(array $messages): void
    {
        throw ValidationException::withMessages($messages);
    }

    /**
     * Respond with a no content response.
     */
    protected function noContent()
    {
        return new JsonResponse(null, 204);
    }

    /**
     * Respond with a created response and associate a location if provided.
     *
     * @param string|null $location
     * @param null $content
     *
     * @return JsonResponse
     */
    protected function created($content = null, $location = null)
    {
        $response = new JsonResponse($content);
        $response->setStatusCode(201);

        if (!is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with a success response
     *
     * @param null $content
     *
     * @return JsonResponse
     */
    protected function success($content = null)
    {
        $response = new JsonResponse($content);
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }
}
