<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrlShortener extends Model
{
    protected $urlKeyMap = [];
    protected $keyUrlMap = [];

    public function __construct()
    {
        $this->urlKeyMap = Cache::get('urlKeyMap', []);
        $this->keyUrlMap = Cache::get('keyUrlMap', []);
    }

    public function encode($url)
    {
        if (isset($this->urlKeyMap[$url])) {
            return $this->urlKeyMap[$url];
        }

        $key = $this->generateKey();
        $this->urlKeyMap[$url] = $key;
        $this->keyUrlMap[$key] = $url;

        Cache::put('urlKeyMap', $this->urlKeyMap);
        Cache::put('keyUrlMap', $this->keyUrlMap);

        return $key;
    }

    public function decode($key)
    {
        return $this->keyUrlMap[$key] ?? null;
    }

    private function generateKey($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
