<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UrlShortener;
use Illuminate\Support\Facades\Validator;

class UrlShortenerController2 extends Controller
{
    protected $urlShortener;

    public function __construct(UrlShortener $urlShortener)
    {
        $this->urlShortener = $urlShortener;
    }

    public function encode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $shortUrl = $this->urlShortener->encode($request->url);
        return response()->json(['short_url' => url($shortUrl)], 200);
    }

    public function decode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'short_url' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $originalUrl = $this->urlShortener->decode($request->short_url);
        if ($originalUrl) {
            return response()->json(['url' => $originalUrl], 200);
        } else {
            return response()->json(['error' => 'Short URL not found'], 404);
        }
    }
}
