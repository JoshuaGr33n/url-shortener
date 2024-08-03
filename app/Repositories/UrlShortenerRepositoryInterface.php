<?php

namespace App\Repositories;

interface UrlShortenerRepositoryInterface
{
    public function encode(string $url): string;
    public function decode(string $key): ?string;
}
