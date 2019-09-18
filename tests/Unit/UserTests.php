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
        $this->signIn();
        $this->get('/admin')->assertRedirect('/');
    }
    /** @test */
    public function user_can_visit_admin_page_if_is_admin()
    {
        $admin = factory('App\User')->create();
        $admin['is_admin'] = true;
        $this->actingAs($admin);
        $this->get('/admin')->assertStatus(200)->assertViewIs('admin');
    }
    /** @test */
    public function admin_can_see_all_clients_of_his_clients() 
    {
        $this->withoutExceptionHandling();
        $admin = factory('App\User')->create();
        $admin['is_admin'] = true;
        $admin['service_id'] = 1;
        $this->actingAs($admin);
        $client = factory('App\Client')->create();
        $client['service'] = $admin->service_id;
        $client->save();
        $this->get('/admin')->assertSee($client->name);
    }
}
