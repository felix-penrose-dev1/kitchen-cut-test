<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_a_user_can_view_index_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
