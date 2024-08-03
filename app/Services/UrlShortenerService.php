<?php

namespace App\Services;

use App\Repositories\UrlShortenerRepositoryInterface;

/**
 * Service layer for encoding and decoding URLs and for easy testing.
 */

class UrlShortenerService
{
    protected $repository;

    public function __construct(UrlShortenerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function encode(string $url): string
    {
        return $this->repository->encode($url);
    }

    public function decode(string $key): ?string
    {
        return $this->repository->decode($key);
    }
}
