<?php

namespace App\Services;

use Throwable;
use GuzzleHttp\Client;
use App\Exceptions\GiphyApiException;
use App\Services\GiphyApiServiceInterface;

class GiphyApiService implements GiphyApiServiceInterface {

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     * @param string $apiKey
     */
    public function __construct(Client $client, string $apiKey) {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * Get interno
     *
     * @param string $uri
     * @param array $query
     * @return array
     * @throws GiphyApiException
     */
    protected function get(string $uri, array $query = []): array {

        try {

            $query['api_key'] = $this->apiKey;

            $response = $this->client->get($uri, [
                'query' => $query,
            ]);

            return $this->parseResponse($response);
        } catch (Throwable $e) {
            throw new GiphyApiException($e->getMessage(), 10, $e);
        }
    }


    /**
     * Get GIF por ID
     *
     * @param string $id
     * @return array
     */
    public function getById(string $id): array {

        try {
            return $this->get($id);
        } catch (Throwable $e) {
            throw new GiphyApiException($e->getMessage(), 23, $e);
        }
    }

    /**
     * Realiza una busqueda
     *
     * @param array $params
     * @return array
     */
    public function search(array $params): array {

        try {

            return $this->get('search', [
                'q' => $params['query'] ?? '',
                'limit' => $params['limit'] ?? 10,
                'offset' => $params['offset'] ?? 0,
            ]);
        } catch (Throwable $e) {
            throw new GiphyApiException($e->getMessage(), 20, $e);
        }
    }


    /**
     * Convierto la respuesta en array
     *
     * @param $response
     * @return array
     */
    protected function parseResponse($response): array {

        $final_response = (is_array($response)) ? $response : json_decode($response->getBody()->getContents(), true);

        return $final_response;
    }
}
