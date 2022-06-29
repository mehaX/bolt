<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsAPIService
{
    private mixed $apiKey;

    public function __construct()
    {
        $this->apiKey = env('NEWS_API_KEY');
    }

    public function getEverything(string $query, $language = 'en')
    {
        $endpoint = '/v2/everything';
        $queryParams = [
            'q' => urlencode($query),
            'language' => $language,
        ];
        return $this->sendRequest('GET', $endpoint, $queryParams, 'articles');
    }

    private function sendRequest(string $method, string $endpoint, array $queryParams, string $collectionKey)
    {
        $url = 'https://newsapi.org' . $endpoint;
        $queryParams['apiKey'] = $this->apiKey;
        $response = Http::send($method, $url, [
            'query' => $queryParams,
        ]);
        if (!$response->successful()) {
            $response->throw();
        }

        return $response->collect($collectionKey);
    }
}
