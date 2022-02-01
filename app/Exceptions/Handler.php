<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Exception $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    public function handleException($request, Exception $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return $this->responseError('Route Not Found', Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof ValidationException) {
            return $this->responseError($e->getMessage(), Response::HTTP_BAD_REQUEST, $this->getCustomErrorMessage($e->errors()));
        }

        if ($e instanceof ResourceConflictException) {
            return $this->responseError($e->getMessage(), Response::HTTP_CONFLICT);
        }

        if ($e instanceof ResourceNotFoundException) {
            return $this->responseError($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof ResourceForbiddenException) {
            return $this->responseError($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof RouteNotFoundException) {
            return $this->responseError('Not Authenticated', Response::HTTP_UNAUTHORIZED);
        }
    }

    private function getCustomErrorMessage(array $errors)
    {
        $customErrors = [];
        foreach ($errors as $key => $error) {
            $custom['key'] = $key;
            $custom['message'] = $error[0];

            array_push($customErrors, $custom);
        }

        return $customErrors;
    }

    private function responseError($message = 'fatal error', $code = 500, $errors = [])
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
            'errors' => $errors
        ], $code);
    }
}
