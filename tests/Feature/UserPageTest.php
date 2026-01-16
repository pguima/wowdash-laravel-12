<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_page_can_be_rendered()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
        $response->assertSeeLivewire('users');
    }
}
