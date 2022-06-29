<?php

namespace Tests\Feature;

use App\Services\NewsAPIService;
use Tests\TestCase;

class NewsApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_everything_should_respond_with_data()
    {
        $query = 'kosovo';
        $service = new NewsAPIService();

        $sut = $service->getEverything($query);

        $this->assertNotEquals(0, $sut->count());
    }
}
