<?php

namespace App\Services;

use Throwable;
use Illuminate\Support\Facades\Http;
use App\Exceptions\GiphyApiException;

class OAuthService {

    /**
     * Token
     *
     * @param string $username
     * @param string $password
     * @return array
     * @throws GiphyApiException
     */
    public function requestToken(string $username, string $password): array {

        try {

            $response = Http::asForm()->post(config('app.nginx_local'), [
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'username' => $username,
                'password' => $password,
                'scope' => ''
            ]);

            if (!$response->successful()) {
                throw new GiphyApiException('Error en Passport: ' . $response->status() . ' - ' . $response->body());
            }

            return $response->json();

        } catch (Throwable $e) {
            throw new GiphyApiException($e->getMessage());
        }
    }
}
