<?php

namespace App\Services;

use Throwable;
use Illuminate\Http\Request;
use App\Models\LoginUsersAccess;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserLoginAccessService {

    public function log(Request $request, Response $response): void {

        try {
            LoginUsersAccess::create([
                'user_id' => Auth::user()->id,
                'service' => $request->path(),
                'request_body' => json_encode($request->all()),
                'http_response_code' => $response->getStatusCode(),
                'response_body' => $this->getResponseBody($response),
                'ip_request' => $request->ip(),
            ]);
        } catch (Throwable $e) {
            // aca guardo en el laravel.log ya que no se retorna por api
            Log::error('GiphyAPI', ['exception' => $e->getMessage()]);
        }
    }

    private function getResponseBody(Response $response): string {
        $content = $response->getContent();
        return $this->isJson($content) ? $content : json_encode(['raw' => $content]);
    }

    private function isJson(string $string): bool {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
