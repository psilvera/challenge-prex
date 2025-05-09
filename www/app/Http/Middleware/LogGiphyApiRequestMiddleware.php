<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LoginUsersAccess;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogGiphyApiRequestMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        $response = $next($request);

        LoginUsersAccess::create([
            'user_id' => Auth::id(),
            'service' => $request->path(),
            'request_body' => json_encode($request->all()),
            'response_code' => $response->status(),
            'response_body' => $response->getContent(),
            'ip_request' => $request->ip(),
        ]);

        return $response;
    }
}
