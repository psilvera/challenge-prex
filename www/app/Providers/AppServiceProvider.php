<?php

namespace App\Providers;

use GuzzleHttp\Client;
use App\Services\GiphyApiService;
use Illuminate\Support\ServiceProvider;
use App\Services\UserFavoriteGifService;
use App\Services\GiphyApiServiceInterface;
use App\Services\UserFavoriteGifServiceInterface;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {

        // bindeo las interfaces para las inyecciones en cosnstructores

        $this->app->bind(GiphyApiServiceInterface::class, GiphyApiService::class);

        $this->app->bind(UserFavoriteGifServiceInterface::class, UserFavoriteGifService::class);

        $this->app->singleton(GiphyApiService::class, function () {
            $client = new Client([
                'base_uri' => rtrim(config('services.giphy.base_url'), '/') . '/',
            ]);

            return new GiphyApiService(
                $client,
                config('services.giphy.key')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
