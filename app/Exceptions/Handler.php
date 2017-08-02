<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $data = [];
        $data['msg'] = $e->getMessage();
        $data['code'] = $e->getCode();
        if ($data['code'] == 0) {
            $data['code'] = 99;
        }
        if (env('APP_DEBUG')) {
            $data['trace'] = $e->getTrace();
        }
        $httpCode = 400;
        if ($e instanceof Error) {
            $httpCode = $e->getStatusCode();
            $data['args'] = $e->getArguments();
        } elseif ($e instanceof HttpException) {
            $httpCode = $e->getStatusCode();
            switch ($httpCode) {
                case 404:
                    $data['msg'] = 'Page not found';
                    break;
                case 405:
                    $data['msg'] = 'Method must be one of: OPTIONS';
                    break;
            }
        }

        return new Response($data, $httpCode);
        // return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
