<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ApiExceptionRenderer
{
    public function render(Throwable $e)
    {
        $code = 500;
        $errorCode = 'INTERNAL_ERROR';
        $message = __('errors.internal_error');
        $errors = [];

        if ($e instanceof ValidationException) {
            $code = 422;
            $errorCode = 'VALIDATION_ERROR';
            $message = __('errors.validation_failed');
            $errors = $e->errors();
        } elseif ($e instanceof BusinessException) {
            $code = $e->getStatus();
            $errorCode = $e->getErrorCode();
            $message = __('errors.' . Str::lower($errorCode));
            $errors = $e->getContext();
        } elseif ($e instanceof AuthenticationException) {
            $code = 401;
            $errorCode = 'UNAUTHENTICATED';
            $message = __('errors.unauthenticated');
        } elseif ($e instanceof AuthorizationException || $e instanceof AccessDeniedHttpException) {
            $code = 403;
            $errorCode = 'FORBIDDEN';
            $message = __('errors.forbidden');
        } elseif ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            $code = 404;
            $errorCode = 'NOT_FOUND';
            $message = __('errors.not_found');
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $code = 405;
            $errorCode = 'METHOD_NOT_ALLOWED';
            $message = __('errors.method_not_allowed');
        } elseif (! app()->isProduction()) {
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => false,
            'code' => $errorCode,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
