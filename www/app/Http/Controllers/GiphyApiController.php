<?php

namespace App\Http\Controllers;

use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\GiphyApiService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\GiphyApiException;
use App\Http\Requests\SearchGifsRequest;
use App\Services\UserFavoriteGifService;
use App\Services\GiphyApiServiceInterface;
use App\Http\Requests\SaveFavoriteGifRequest;
use App\Services\UserFavoriteGifServiceInterface;

class GiphyApiController extends Controller {

    /**
     * @var GiphyApiServiceInterface
     */
    protected $giphy;

    /**
     * @var UserFavoriteGifService
     */
    protected $userFavoriteGifService;

    /**
     * @param GiphyApiService
     * @param UserFavoriteGifService $userFavoriteGifService
     */
    public function __construct(GiphyApiServiceInterface $giphy, UserFavoriteGifServiceInterface $userFavoriteGifService) {
        $this->userFavoriteGifService = $userFavoriteGifService;
        $this->giphy = $giphy;
    }

    /**
     * Busca GIFs por filtros
     *
     * @param Request $request
     * @return JsonResponse Respuesta JSON
     */
    public function searchGifs(SearchGifsRequest $request) {

        try {

            $data = $request->validated();

            return ApiResponse::success($this->giphy->search($data));

        } catch (Throwable $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
    }


    /**
     * Obtiene un GIF por ID
     *
     * @param string $id
     * @return JsonResponse Respuesta JSON
     */
    public function getGifById($id) {

        // el challenge dice validar id numerico pero son alfanumericos

        // ejemplo: xT1Ra1NBgzJbnyibIY

        try {

            $response = $this->giphy->getById($id);
            return ApiResponse::success($response);

        } catch (GiphyApiException $e) {
            return ApiResponse::error('Error al obtener el gif', 422, [$e->getMessage()]);
        }
    }

    /**
     * Graba un GIF
     *
     * @param string $id
     * @return Response|JsonResponse
     */
    public function saveFavoriteGif(SaveFavoriteGifRequest $request): Response|JsonResponse {

        try {

            $data = $request->validated();

            $this->userFavoriteGifService->store($data);
            return response()->noContent(201);

        } catch (GiphyApiException $e) {
            return ApiResponse::error('Error al grabar el gif', 422, [$e->getMessage()]);
        }
    }
}
