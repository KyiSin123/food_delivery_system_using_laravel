<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShopTest extends TestCase
{
    /**
     * Test shops route return ok.
     *
     * @return void
     */
    public function test_shops_route_return_ok()
    {
        $response = $this->get('/shop/register');

        $response->assertStatus(200);
    }
}
