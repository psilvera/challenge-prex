<?php

namespace App\Services;

use Throwable;
use App\Models\UserFavoriteGif;
use App\Exceptions\GiphyApiException;
use App\Services\UserFavoriteGifServiceInterface;

class UserFavoriteGifService implements UserFavoriteGifServiceInterface {

    protected UserFavoriteGif $model;

    public function __construct(UserFavoriteGif $model) {
        $this->model = $model;
    }

    /**
     * Guarda un GIF favorito de usuario
     *
     * @param array $data
     * @return mixed
     * @throws GiphyApiException
     */
    public function store(array $data): mixed {

        try {
            return $this->model->create([
                'gif_id' => $data['gif_id'],
                'alias' => $data['alias'],
                'user_id' => $data['user_id'],
            ]);
        } catch (Throwable $e) {
            throw new GiphyApiException($e->getMessage());
        }
    }
}
