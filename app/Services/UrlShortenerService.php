<?php

namespace App\Services;

use App\Repositories\UrlShortenerRepositoryInterface;
use  Illuminate\Support\Str;

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
        $key = $this->generateKey();
        return $this->repository->encode($url, $key);
    }

    public function decode(string $key): ?string
    {
        return $this->repository->decode($key);
    }


    private function generateKey(): string
    {
        // // Generate a random string of specified length
        $length = 6;
        return Str::random($length);
    }
}
