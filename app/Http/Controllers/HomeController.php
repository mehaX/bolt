<?php

namespace App\Http\Controllers;

use App\Services\NewsAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class HomeController extends Controller
{
    private NewsAPIService $newsAPIService;

    public function __construct(NewsAPIService $newsAPIService)
    {
        $this->newsAPIService = $newsAPIService;
    }

    public function index(Request $request)
    {
        $query = $request->query('query', 'kosovo');
        $data['query'] = $query;

        $cacheKey = 'queries/' . sha1($query);
        if (Cache::has($cacheKey)) {
            $data['newsData'] = collect(Cache::get($cacheKey));
        } else {
            $data['newsData'] = $this->newsAPIService->getEverything($query);
            Cache::add($cacheKey, $data['newsData']->toArray(), (60 - date('i')) * (60 - date('s')));
        }

        return Inertia::render('Home', $data);
    }
}
