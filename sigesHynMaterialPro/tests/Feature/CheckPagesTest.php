<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class CheckPagesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function test_redirect_home_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }

    public function test_home_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['admin@admin.com' => 'admin'])
            ->get('/home')
            ->assertStatus(200);
    }

    public function test_home_two_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['admin@admin.com' => 'admin'])
            ->get('/home-two')
            ->assertStatus(200);
    }

    public function test_home_page_content()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['admin@admin.com' => 'admin'])
            ->get('/home')
            ->assertSeeText('Home One');
    }

    public function test_home_two_page_content()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['admin@admin.com' => 'admin'])
            ->get('/home-two')
            ->assertSeeText('Home Two');
    }
}
