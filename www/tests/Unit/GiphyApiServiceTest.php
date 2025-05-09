<?php

namespace Tests\Unit;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Services\GiphyApiService;

class GiphyApiServiceTest extends TestCase {

    public function testTestDelServiceConElMetodoSearch() {

        // fake giphy
        $mockBody = json_encode(['data' => ['ungif']]);
        $mockResponse = new Response(200, [], $mockBody);

        // fake de guzzle
        $client = Mockery::mock(Client::class);

        // search gifs
        $client->shouldReceive('get')
            ->once()
            ->with('search', [
                'query' => [
                    'q' => 'cat',
                    'limit' => 10,
                    'offset' => 0,
                    'api_key' => 'api_key_sarasa'
                ]
            ])->andReturn($mockResponse); // respuesta fake

        $service = new GiphyApiService($client, 'api_key_sarasa');

        $response = $service->search(['query' => 'cat']);

        $this->assertEquals(['data' => ['ungif']], $response);
    }

    public function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }
}
