<?php

namespace App\Http\Middleware;

use Closure;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\RotatingFileHandler;

class LogRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $logger = new Logger(env("APP_NAME"));
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new RotatingFileHandler(
            storage_path() . '/logs/route/api.log',
            Logger::DEBUG
        ));
        $logger->info(json_encode([
            'method' => $request->getMethod(),
            'type' => 'req',
            'path' => $request->fullUrl(),
            'body' => json_encode($request->all()),
        ]));

        $response = $next($request);

        $logger->info(json_encode([
            'method' => $request->getMethod(),
            'type' => 'res',
            'path' => $request->fullUrl(),
            'body' => json_decode($response->getContent()),
        ]));

        return $response;
    }
}
