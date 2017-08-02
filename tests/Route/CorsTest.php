<?php

namespace Tests\Route;

use Tests\TestCase;

class CrosTest extends TestCase
{
    public function testPublicRoute()
    {
        $response = $this->get('/', [
            'Origin' => 'test.com'
        ]);
        $response->assertStatus(200);
        $response->assertHeader('Access-Control-Allow-Origin', '*');
    }
}
