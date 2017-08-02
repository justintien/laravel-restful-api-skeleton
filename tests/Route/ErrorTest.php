<?php

namespace Tests\Route;

use Tests\TestCase;

class ErrorTest extends TestCase
{
    public function testError()
    {
        $response = $this->get('/e');
        $response->assertStatus(400);
        $response->assertJsonFragment([
            'code' => 99,
            'msg' => 'throw a exception.'
        ]);
    }

    public function testNotFound()
    {
        $response = $this->get('__404');
        $response->assertStatus(404);
        $response->assertJsonFragment([
            'code' => 99,
            'msg' => 'Page not found'
        ]);
    }

    public function testMethodNotAllowed()
    {
        $response = $this->post('/');
        $response->assertStatus(405);
        $response->assertJsonFragment([
            'code' => 99,
            'msg' => 'Method must be one of: OPTIONS'
        ]);
    }

    public function testInternalServerError()
    {
        $response = $this->get('/internal_server_error');
        $response->assertStatus(500);
    }
}
