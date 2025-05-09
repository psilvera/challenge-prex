<?php

namespace Tests\Unit;

use Mockery;
use Throwable;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserFavoriteGif;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GiphyApiException;
use App\Services\UserFavoriteGifService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFavoriteGifServiceTest extends TestCase {

    //use RefreshDatabase;

    public function testTestDelMetodoStore() {

        $model = new UserFavoriteGif();

        $service = new UserFavoriteGifService($model);

        $user = User::factory()->create();

        $data = [
            'gif_id' => 'xT1Ra1NBgzJbnyibIY',
            'alias' => 'gaturro',
            'user_id' => $user->id,
        ];

        $favoriteGif = $service->store($data);

        $this->assertDatabaseHas('user_favorite_gifs', $data);

        $this->assertInstanceOf(UserFavoriteGif::class, $favoriteGif);
    }

    public function testTestDelMetodoStoreFallando() {

        $mock = Mockery::mock(UserFavoriteGif::class);
        $mock->shouldReceive('create')
            ->once()
            ->andThrow(new \Exception("DB error"));

        $service = new UserFavoriteGifService($mock);

        $this->expectException(GiphyApiException::class);

        $data = [
            'gif_id' => 'error',
            'alias' => 'Broken',
            'user_id' => 999,
        ];

        $service->store($data);
    }

}
