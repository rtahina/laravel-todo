<?php

use App\Domains\Task\Exceptions\TaskNotFoundException;
use App\Domains\User\Exceptions\UserNotFoundException;
use App\Helpers\HttpApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e) {
            return HttpApiResponse::errorResponse(
                errors: [$e->getMessage()],
                message: 'Resource not found.',
                code: Response::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (TaskNotFoundException $e) {
            return HttpApiResponse::errorResponse(
                errors: ['The task was not found.'],
                message: 'Resource not found.',
                code: Response::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (UserNotFoundException $e) {
            return HttpApiResponse::errorResponse(
                errors: ['The user was not found.'],
                message: 'Resource not found.',
                code: Response::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (AccessDeniedHttpException $e) {
            return HttpApiResponse::errorResponse(
                errors: [$e->getMessage()],
                message: 'This action is unauthorized.',
                code: Response::HTTP_UNAUTHORIZED
            );
        });
    })->create();
