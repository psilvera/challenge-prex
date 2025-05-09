<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserLoginAccessService;

class LoginUserMiddleware {

    protected UserLoginAccessService $logger;

    public function __construct(UserLoginAccessService $logger) {
        $this->logger = $logger;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        $response = $next($request);

        $this->logger->log($request, $response);

        return $response;
    }
}
