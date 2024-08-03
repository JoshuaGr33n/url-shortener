<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EncodeUrlRequest;
use App\Http\Requests\DecodeUrlRequest;
use App\Services\UrlShortenerService;

class UrlShortenerController extends Controller
{
    protected $service;

    public function __construct(UrlShortenerService $service)
    {
        $this->service = $service;
    }

    public function encode(EncodeUrlRequest $request)
    {
        $shortUrl = $this->service->encode($request->url);
        return response()->json(['short_url' => url($shortUrl)], 200);
    }

    public function decode(DecodeUrlRequest $request)
    {
        $originalUrl = $this->service->decode($request->short_url);
        if ($originalUrl) {
            return response()->json(['url' => $originalUrl], 200);
        } else {
            return response()->json(['error' => 'Short URL not found'], 404);
        }
    }
}
