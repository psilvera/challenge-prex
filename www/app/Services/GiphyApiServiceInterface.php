<?php

namespace App\Services;

interface GiphyApiServiceInterface {

    public function search(array $params): array;

    public function getById(string $id): array;
}
