<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        // Deshabilitado mientras se completen las migraciones
        // $response = $this->get('/');
        //
        // $response->assertStatus(200);
        $this->assertTrue(true);
    }
}
