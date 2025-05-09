<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GiphyApiControllerTest extends TestCase {

    //use RefreshDatabase;

    public function testTestDelMetodoLogin(): void {

        $email = 'prex_challenge@prexcard.com';
        $password = 'pr3x1235';

        $response = $this->postJson('/api/giphy/login', [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'refresh_token'
        ]);
    }

    public function testTestDelMetodoSalvarGifFavorito(): void {

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->postJson('/api/giphy/favorite', [
            'gif_id' => 'xT1Ra1NBgzJbnyibIY',
            'alias' => 'alias test',
            'user_id' => $user->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('user_favorite_gifs', [
            'gif_id' => 'xT1Ra1NBgzJbnyibIY',
            'user_id' => $user->id
        ]);
    }

    public function testTestDelMetodoSearchGifs(): void {

        $user = User::factory()->create();

        Passport::actingAs($user);

        $params = [
            'query' => 'sailboat',
            'limit' => 2
        ];

        $response = $this->getJson('/api/giphy/search?' . http_build_query($params));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'url',
                        'slug',
                        'bitly_gif_url',
                        'bitly_url',
                        'embed_url'
                    ]
                ],
                'meta' => [
                    'status',
                    'msg',
                    'response_id'
                ],
                'pagination' => [
                    'total_count',
                    'count',
                    'offset'
                ]
            ]
        ]);
    }

    public function testTestDelMetodoObtenerGifPorId(): void {

        $user = User::factory()->create();

        Passport::actingAs($user);

        $gifId = 'xT1Ra1NBgzJbnyibIY';

        $response = $this->getJson("/api/giphy/id/{$gifId}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => []
                ],
                'meta' => [
                    'status',
                    'msg',
                    'response_id'
                ]
            ]
        ]);
    }
}
