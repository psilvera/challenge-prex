<?php

namespace App\Exceptions;

use Throwable;
use App\Helpers\ApiResponse;
use App\Exceptions\GiphyApiException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler {
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void {
        $this->reportable(function (Throwable $e) {
            throw new GiphyApiException($e->getPrevious()->getMessage(), 30, $e->getPrevious());
        });
    }

    public function render($request, Throwable $e) {

        // customizo algunos errores

        $status = 500;
        $friendlyMessage = 'Ha ocurrido un error intente nuevamente';

        if ($e instanceof NotFoundHttpException) {
            $status = 404;
            $friendlyMessage = 'El endpoint no existe';
        } elseif ($e instanceof GiphyApiException) {

            $status = 403;
            $message = $e->getMessage();
            $friendlyMessage = $message;

            if (str_contains($message, 'The token is expired')) {
                $status = 401;
                $friendlyMessage = 'Token expirado';
            } elseif (str_contains($message, 'Base64Url')) {
                $status = 400;
                $friendlyMessage = 'Token incorrecto';
            }
        } elseif ($e instanceof ValidationException) {

            $status = 422;
            $friendlyMessage = 'La validacion de los datos fallo';
        }

        return ApiResponse::error($friendlyMessage, $status, [$e->getMessage()]);
    }
}
