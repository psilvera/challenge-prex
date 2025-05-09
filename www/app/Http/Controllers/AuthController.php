<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OAuthService;
use App\Helpers\ApiResponse;
use App\Exceptions\GiphyApiException;

class AuthController extends Controller {

    /**
     * @var OAuthService
     */
    protected $oauthService;

    /**
     * @param OAuthService $oauthService
     */
    public function __construct(OAuthService $oauthService) {
        $this->oauthService = $oauthService;
    }

    /**
     * Login
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request): mixed {

        try {

            // no hago formRequest para estas validaciones
            $data = $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => 'required|string',
            ]);

            return $this->oauthService->requestToken($data['email'], $data['password']);
        } catch (GiphyApiException $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}
