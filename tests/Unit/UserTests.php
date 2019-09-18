<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTests extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function user_can_not_see_admin_page_if_does_not_have_permissions()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $this->get('/admin')->assertRedirect('/');
    }
    /** @test */
    public function user_can_visit_admin_page_if_is_admin()
    {
        $this->withoutExceptionHandling();
        $admin = factory('App\User')->create();
        $admin['is_admin'] = true;
        $this->actingAs($admin);
        $this->get('/admin')->assertStatus(200)->assertViewIs('admin');
    }
    /** @test */
}
