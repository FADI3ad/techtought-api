<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {

        // Model Not Found (404) – Route Model Binding
        $exceptions->render(function (ModelNotFoundException $e, $request) {

            $model = class_basename($e->getModel());

            return response()->json([
                'status' => 'error',
                'message' => "$model not found",
            ], 404);
        });


        // Validation Errors (422)
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        });

        // HTTP Exceptions (401, 403, 404, 405, ...)
        $exceptions->render(function (HttpExceptionInterface $e, $request) {
            $message = $e->getMessage();

            if (str_contains($message, 'No query results for model')) {

                preg_match('/model \[([^\]]+)\]/', $message, $matches);
                $model = $matches[1] ?? 'Resource';
                $model = class_basename($model);
                $message = "$model not found";
            } else {
                $message = $message ?: match ($e->getStatusCode()) {
                    401 => 'Unauthorized',
                    403 => 'Forbidden',
                    404 => 'Not Found',
                    405 => 'Method Not Allowed',
                    default => 'HTTP Error',
                };
            }

            return response()->json([
                'status' => 'error',
                'message' => $message,
            ], $e->getStatusCode());
        });

        $exceptions->render(function (\Throwable $e, $request) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server Error',
            ], 500);
        });
    })

    ->create();
